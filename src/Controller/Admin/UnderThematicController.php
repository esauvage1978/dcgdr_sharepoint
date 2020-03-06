<?php

namespace App\Controller\Admin;

use App\Controller\AppControllerAbstract;
use App\Entity\UnderThematic;
use App\Form\Admin\UnderThematicType;
use App\Repository\UnderThematicRepository;
use App\Manager\UnderThematicManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/underthematic")
 */
class UnderThematicController extends AppControllerAbstract
{
    const ENTITYS = 'underthematics';
    const ENTITY = 'underthematic';

    /**
     * @Route("/", name="admin_underthematic_index", methods={"GET"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function indexAction(UnderThematicRepository $repository): Response
    {
        return $this->render(self::ENTITY.'/index.html.twig', [
            self::ENTITYS => $repository->findAllForAdmin(),
        ]);
    }

    /**
     * @Route("/new", name="admin_underthematic_new", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function newAction(Request $request, UnderThematicManager $manager): Response
    {
        $entity=new UnderThematic();
        $form = $this->createForm(UnderThematicType::class, $entity);

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
     * @Route("/{id}/edit", name="admin_underthematic_edit", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function editAction(
        Request $request,
        UnderThematic $entity,
        UnderThematicManager $manager
    ): Response
    {
        $form = $this->createForm(UnderThematicType::class, $entity);

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
     * @Route("/{id}", name="admin_underthematic_show", methods={"GET"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function showAction(
        UnderThematic $underthematic
    ): Response
    {
        return $this->render(self::ENTITY.'/show.html.twig', [
            self::ENTITY => $underthematic
        ]);
    }

    /**
     * @Route("/{id}", name="admin_underthematic_delete", methods={"DELETE"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function deleteAction(Request $request, UnderThematic $entity, UnderThematicManager $manager): Response
    {
        return $this->delete($request, $entity, $manager, self::ENTITY);
    }
}
