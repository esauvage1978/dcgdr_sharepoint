<?php

namespace App\Controller\Admin;

use App\Controller\AppControllerAbstract;
use App\Entity\Thematic;
use App\Form\Admin\ThematicType;
use App\Repository\ThematicRepository;
use App\Manager\ThematicManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/thematic")
 */
class ThematicController extends AppControllerAbstract
{
    const ENTITYS = 'thematics';
    const ENTITY = 'thematic';

    /**
     * @Route("/", name="admin_thematic_index", methods={"GET"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function indexAction(ThematicRepository $repository): Response
    {
        return $this->render(self::ENTITY.'/index.html.twig', [
            self::ENTITYS => $repository->findAllForAdmin(),
        ]);
    }

    /**
     * @Route("/new", name="admin_thematic_new", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function newAction(Request $request, ThematicManager $manager): Response
    {
        $entity=new Thematic();
        $form = $this->createForm(ThematicType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($entity)) {
                $this->addFlash(self::SUCCESS, self::MSG_CREATE);

                if (!empty($entity->getId())) {
                    return $this->redirectToRoute('admin_'. self::ENTITY . '_edit', ['id' => $entity->getId()]);
                } else {
                    return $this->redirectToRoute('admin_'. self::ENTITY. 'index');
                }
            }
            $this->addFlash(self::DANGER, self::MSG_ERROR . $manager->getErrors($entity));
        }

        return $this->render(self::ENTITY . '/new.html.twig', [
            self::ENTITY => $entity,
            self::FORM => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_thematic_edit", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function editAction(
        Request $request,
        Thematic $entity,
        ThematicManager $manager
    ): Response
    {
        $form = $this->createForm(ThematicType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($entity)) {
                $this->addFlash(self::SUCCESS, self::MSG_MODIFY);

                if (!empty($entity->getId())) {
                    return $this->redirectToRoute('admin_'.self::ENTITY . '_edit', ['id' => $entity->getId()]);
                } else {
                    return $this->redirectToRoute('admin_'.self::ENTITY . '_index');
                }
            }
            $this->addFlash(self::DANGER, self::MSG_ERROR . $manager->getErrors($entity));
        }

        return $this->render(self::ENTITY . '/edit.html.twig', [
            self::ENTITY => $entity,
            self::FORM => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_thematic_show", methods={"GET"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function showAction(
        Thematic $thematic
    ): Response
    {
        return $this->render(self::ENTITY.'/show.html.twig', [
            self::ENTITY => $thematic
        ]);
    }

    /**
     * @Route("/{id}", name="admin_thematic_delete", methods={"DELETE"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function deleteAction(Request $request, Thematic $entity, ThematicManager $manager): Response
    {
        return $this->delete($request, $entity, $manager, self::ENTITY);
    }
}
