<?php

namespace App\Controller\Admin;

use App\Controller\AppControllerAbstract;
use App\Entity\Corbeille;
use App\Form\Admin\CorbeilleGestLocalType;
use App\Form\Admin\CorbeilleType;
use App\Manager\CorbeilleManager;
use App\Repository\CorbeilleRepository;
use App\Security\CorbeilleVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/corbeille")
 */
class CorbeilleController extends AppControllerAbstract
{
    const ENTITYS = 'corbeilles';
    const ENTITY = 'corbeille';

    /**
     * @Route("/", name="corbeille_index", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function indexAction(CorbeilleRepository $repository): Response
    {
        return $this->render(self::ENTITY . '/index.html.twig', [
            self::ENTITYS => $repository->findAllForAdmin(),
        ]);
    }

    /**
     * @Route("/new", name="corbeille_new", methods={"GET","POST"})
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function newAction(Request $request, CorbeilleManager $manager): Response
    {
        return $this->editAction($request, new Corbeille(), $manager, self::MSG_CREATE);
    }

    /**
     * @Route("/{id}", name="corbeille_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function showAction(Corbeille $entity): Response
    {
        return $this->render(self::ENTITY . '/show.html.twig', [
            self::ENTITY => $entity,
        ]);
    }

    /**
     * @Route("/use/{id}", name="corbeille_show_use", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function showUseAction(Corbeille $entity): Response
    {
        return $this->render(self::ENTITY . '/showuse.html.twig', [
            self::ENTITY => $entity,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="corbeille_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function editAction(
        Request $request,
        Corbeille $entity,
        CorbeilleManager $manager,
        string $message = self::MSG_MODIFY): Response
    {

        $form = $this->createForm(CorbeilleType::class, $entity);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($entity)) {
                $this->addFlash(self::SUCCESS, $message);

                return $this->redirectToRoute(self::ENTITY . '_edit',['id'=>$entity->getId()]);
            }
            $this->addFlash(self::DANGER, self::MSG_ERROR . $manager->getErrors($entity));
        }

        return $this->render(self::ENTITY . '/' .
            (self::MSG_CREATE === $message ? 'new' : 'edit') . '.html.twig', [
            self::ENTITY => $entity,
            self::FORM => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="corbeille_delete", methods={"DELETE"})
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function deleteAction(Request $request, Corbeille $entity, CorbeilleManager $manager): Response
    {
        return $this->delete($request, $entity, $manager, self::ENTITY);
    }
}
