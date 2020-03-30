<?php

namespace App\Controller\Admin;

use App\Command\CalculTauxCommand;
use App\Command\NotificatorCommand;
use App\Command\WorkflowCommand;
use App\Helper\DeployementJalonNotificator;
use App\Repository\MessageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_home", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function adminHomeAction(
        MessageRepository $messageRepository
    ): Response
    {
        return $this->render('admin/home.html.twig',
            ['messages'=> $messageRepository->findBy(['name'=>'admin'])]);
    }


    /**
     * @Route("/command/notificator", name="command_notificator", methods={"GET"})
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     *
     * @return Response
     */
    public function commandNotificator(NotificatorCommand $notificatorCommand)
    {
        $notificatorCommand->runTraitement();

        $this->addFlash('info', $notificatorCommand->getMessagesForAlert());

        return $this->redirectToRoute('admin_home');
    }
}
