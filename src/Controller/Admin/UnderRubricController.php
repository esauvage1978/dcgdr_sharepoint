<?php

namespace App\Controller\Admin;

use App\Controller\AppControllerAbstract;
use App\Entity\UnderRubric;
use App\Form\Admin\UnderRubricType;
use App\Repository\UnderRubricRepository;
use App\Manager\UnderRubricManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/underrubric")
 */
class UnderRubricController extends AppControllerAbstract
{
    const ENTITYS = 'underrubrics';
    const ENTITY = 'underrubric';

    /**
     * @Route("/", name="admin_underrubric_index", methods={"GET"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function indexAction(UnderRubricRepository $repository): Response
    {
        return $this->render(self::ENTITY.'/index.html.twig', [
            self::ENTITYS => $repository->findAllForAdmin(),
        ]);
    }

    /**
     * @Route("/new", name="admin_underrubric_new", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function newAction(Request $request, UnderRubricManager $manager): Response
    {
        $entity=new UnderRubric();
        $form = $this->createForm(UnderRubricType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($entity)) {
                $this->addFlash(self::SUCCESS, self::MSG_CREATE);

                if (!empty($entity->getId())) {
                    return $this->redirectToRoute('admin_'.self::ENTITY . '_edit', ['id' => $entity->getId()]);
                } else {
                    return $this->redirectToRoute('admin_'.self::ENTITY . '_index');
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
     * @Route("/{id}/edit", name="admin_underrubric_edit", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function editAction(
        Request $request,
        UnderRubric $entity,
        UnderRubricManager $manager
    ): Response
    {
        $form = $this->createForm(UnderRubricType::class, $entity);

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
     * @Route("/{id}", name="admin_underrubric_show", methods={"GET"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function showAction(
        UnderRubric $underrubric
    ): Response
    {
        return $this->render(self::ENTITY.'/show.html.twig', [
            self::ENTITY => $underrubric
        ]);
    }

    /**
     * @Route("/{id}", name="admin_underrubric_delete", methods={"DELETE"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function deleteAction(Request $request, UnderRubric $entity, UnderRubricManager $manager): Response
    {
        return $this->delete($request, $entity, $manager, self::ENTITY);
    }
}
