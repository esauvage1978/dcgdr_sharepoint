<?php

namespace App\Controller\Mailer;

use App\Controller\AppControllerAbstract;
use App\Entity\Action;
use App\Entity\Backpack;
use App\Entity\Deployement;
use App\Entity\Mailer;
use App\Form\Mailer\MailerFormBackpackType;
use App\Form\Mailer\MailerFormDeployementType;
use App\Helper\SendMail;
use App\Manager\MailerManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AppControllerAbstract
{
    /**
     * @Route("/mailer/composer/{id}", name="mailer_backpack_composer")
     * @return Response
     */
    public function mailerBackpackComposer(
        Request $request,
        Backpack $backpack,
        MailerManager $manager,
        SendMail $sendMail
    )
    {
        $form = $this->createForm(MailerFormBackpackType::class, ['data' => $backpack->getId()]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailer = $manager->initialiseMailer($form->getData());
            if (is_a($mailer, Mailer::class)) {
                $sendMail->send(
                    [
                        SendMail::USERS_FROM => [$this->getUser()->getEmail() => $this->getUser()->getName()],
                        SendMail::USERS_TO => $manager->getUsersEmailTo(),
                        'backpack' => $backpack,
                        'content' => $mailer->getContent()
                    ],
                    SendMail::MAILER_BACKPACK,
                    'DCGDR PAR - ' . $mailer->getSubject()
                );

                $mailer->setBackpack($backpack);

                $manager->save($mailer);

                $this->addFlash(self::SUCCESS, 'Message envoyé');
            } else {
                $this->addFlash(self::DANGER, 'Une erreur est survenue. Le mail n\'est pas envoyé. La cause probable est une absence de destinataire');
            }
        }
        return $this->render('mailer/composerAction.html.twig', [
            'controller_name' => 'MailerController',
            'backpack' => $backpack,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mailer/{id}", name="mailer_backpack_history")
     * @return Response
     */
    public function mailierActionHistory(
        Backpack $backpack
    )
    {
        return $this->render('mailer/history_action.html.twig', [
            'backpack' => $backpack,
        ]);
    }


}
