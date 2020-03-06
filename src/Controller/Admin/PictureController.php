<?php

namespace App\Controller\Admin;

use App\Controller\AppControllerAbstract;
use App\Entity\Picture;
use App\Form\Admin\PictureType;
use App\Repository\PictureRepository;
use App\Manager\PictureManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/picture")
 */
class PictureController extends AppControllerAbstract
{
    const ENTITYS = 'pictures';
    const ENTITY = 'picture';

    /**
     * @Route("/", name="admin_picture_index", methods={"GET"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function indexAction(PictureRepository $repository): Response
    {
        return $this->render(self::ENTITY.'/index.html.twig', [
            self::ENTITYS => $repository->findAllForAdmin(),
        ]);
    }

    /**
     * @Route("/new", name="admin_picture_new", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function newAction(Request $request, PictureManager $manager): Response
    {
        $entity=new Picture();
        $form = $this->createForm(PictureType::class, $entity);

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
     * @Route("/{id}/edit", name="admin_picture_edit", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function editAction(
        Request $request,
        Picture $entity,
        PictureManager $manager
    ): Response
    {
        $form = $this->createForm(PictureType::class, $entity);

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
     * @Route("/{id}", name="admin_picture_show", methods={"GET"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function showAction(
        Picture $picture
    ): Response
    {
        return $this->render(self::ENTITY.'/show.html.twig', [
            self::ENTITY => $picture
        ]);
    }

    /**
     * @Route("/{id}", name="admin_picture_delete", methods={"DELETE"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function deleteAction(Request $request, Picture $entity, PictureManager $manager): Response
    {
        return $this->delete($request, $entity, $manager, 'admin_'.self::ENTITY);
    }
}
