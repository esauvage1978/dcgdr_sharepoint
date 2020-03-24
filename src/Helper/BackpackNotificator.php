<?php

namespace App\Helper;

use App\Dto\BackpackDto;
use App\Entity\Backpack;
use App\Repository\BackpackDtoRepository;
use App\Repository\UserRepository;

class BackpackNotificator extends Messagor
{
    /**
     * @var mixed
     */
    private $usersSubscription;

    /**
     * @var BackpackDto
     */
    private $backpackDto;

    /**
     * @var BackpackDtoRepository
     */
    private $backpackRepository;

    /**
     * @var SendMail
     */
    private $sendMail;

    public function __construct(
        UserRepository $userRepository,
        BackpackDto $backpackDto,
        backpackDtoRepository $backpackRepository,
        SendMail $sendMail
    ) {
        $this->usersSubscription = $userRepository->findAllUserSubscription();
        $this->backpackDto = $backpackDto;
        $this->backpackRepository = $backpackRepository;
        $this->sendMail = $sendMail;

        parent::__construct();
    }

    public function notifyNew()
    {
        $this->addMessage('Lancement des notifications pour '. count($this->usersSubscription) .' utilisateurs :');
        $this->notifyBackpackNew($this->usersSubscription);

        return $this->getMessages();
    }

    private function notifyBackpackNew(array $users)
    {
        foreach ($users as $user) {
            $this->backpackDto
                ->setUser($user)
                ->setEnable(BackpackDto::TRUE)
                ->setRubricEnable(BackpackDto::TRUE)
                ->setThematicEnable(BackpackDto::TRUE)
                ->setUnderRubricEnable(BackpackDto::TRUE)
                ->setUnderThematicEnable(BackpackDto::TRUE)
                ->setNew(BackpackDto::TRUE)
            ;

            /** @var Backpack[] $result */
            $result = $this->backpackRepository->findAllForDto($this->backpackDto, BackpackDtoRepository::FILTRE_DTO_INIT_HOME);

            if (!empty($result)) {
                $this->addMessage(
                    Messagor::TABULTATION.
                    ' Notification à '.$user->getName().
                    ' ['.$user->getEmail().']'. ' -> ' . count($result) .' nouveautés');

                $this->sendMail->send(
                    [
                        'user' => $user,
                        'backpacks' => $result,
                    ],
                    SendMail::BACKPACK_NEW,
                    'DCGDR SHAREPOINT : Liste des dernières modifications'
                );
            } else {
                $this->addMessage( $user->getName() . ' -> pas de nouveauté');
            }
        }
    }
}
