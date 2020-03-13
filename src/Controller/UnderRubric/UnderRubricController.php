<?php

namespace App\Controller\UnderRubric;

use App\Controller\AppControllerAbstract;
use App\Dto\BackpackDto;
use App\Dto\RubricDto;
use App\Entity\UnderRubric;
use App\Repository\BackpackDtoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/")
 */
class UnderRubricController extends AppControllerAbstract
{
    const ENTITYS = 'underrubrics';
    const ENTITY = 'underrubric';


    /**
     * @Route("/underrubric/{id}", name="underrubric_show", methods={"GET"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function showAction(
        UnderRubric $underrubric,
        BackpackDto $backpackDto,
        BackpackDtoRepository $backpackDtoRepository
    ) {
        $backpackDto
            ->setArchiving(BackpackDto::FALSE)
            ->setUnderRubric($underrubric)
            ->setEnable(RubricDto::TRUE)
            ->setUnderThematicEnable(RubricDto::TRUE)
            ->setThematicEnable(RubricDto::TRUE)
            ->setUnderRubricEnable(RubricDto::TRUE)
            ->setRubricEnable(RubricDto::TRUE);

        if (!$this->isgranted('ROLE_GESTIONNAIRE')) {
            $backpackDto
                ->setUser($this->getUser());
        }

        return $this->render(self::ENTITY.'/list.html.twig', [
            self::ENTITY => $underrubric,
            'backpacks'=> $backpackDtoRepository->findAllForDto($backpackDto)
        ]);
    }

}
