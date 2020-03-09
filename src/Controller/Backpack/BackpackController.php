<?php

namespace App\Controller\Backpack;

use App\Controller\AppControllerAbstract;
use App\Dto\BackpackDto;
use App\Entity\Backpack;
use App\Entity\Thematic;
use App\Form\Admin\ThematicType;
use App\Form\Backpack\BackpackType;
use App\Manager\BackpackManager;
use App\Repository\BackpackDtoRepository;
use App\Repository\ThematicRepository;
use App\Manager\ThematicManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/")
 */
class BackpackController extends AppControllerAbstract
{
    const ENTITYS = 'backpacks';
    const ENTITY = 'backpack';

    /**
     * @Route("/backpack/archiving", name="backpack_archiving", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function homeSearchAction(
        Request $request,
        BackpackDtoRepository $backpackDtoRepository
    ): Response
    {
        $backpackDtoArchiving = new BackpackDto();

        $backpackDtoArchiving
            ->setArchiving(BackpackDto::TRUE);


        if (!$this->isGranted('ROLE_GESTIONNAIRE')) {
            $backpackDtoArchiving
                ->setEnable(BackpackDto::TRUE)
                ->setUnderThematicEnable(BackpackDto::TRUE)
                ->setThematicEnable(BackpackDto::TRUE)
                ->setUnderRubricEnable(BackpackDto::TRUE)
                ->setRubricEnable(BackpackDto::TRUE);
        }

        return $this->render(
            'backpack/archiving.html.twig',
            [
                'backpacks' => $backpackDtoRepository->findAllForDto($backpackDtoArchiving)
            ]);
    }

    /**
     * @Route("/backpack/new", name="backpack_new", methods={"GET","POST"})
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
     * @Route("/backpack/{id}/edit", name="backpack_edit", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function editAction(
        Request $request,
        Backpack $entity,
        BackpackManager $manager
    ): Response
    {
        $form = $this->createForm(BackpackType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($entity)) {
                $this->addFlash(self::SUCCESS, self::MSG_MODIFY);


                    return $this->redirectToRoute(self::ENTITY . '_edit', ['id' => $entity->getId()]);

            }
            $this->addFlash(self::DANGER, self::MSG_ERROR . $manager->getErrors($entity));
        }

        return $this->render(self::ENTITY . '/edit.html.twig', [
            self::ENTITY => $entity,
            self::FORM => $form->createView(),
        ]);
    }

    /**
     * @Route("/backpack/{id}", name="backpack_show", methods={"GET"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function showAction(
        Backpack $backpack
    ): Response
    {
        return $this->render(self::ENTITY.'/show.html.twig', [
            self::ENTITY => $backpack
        ]);
    }

    /**
     * @Route("/backpack/{id}", name="backpack_delete", methods={"DELETE"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function deleteAction(Request $request, Thematic $entity, ThematicManager $manager): Response
    {
        return $this->delete($request, $entity, $manager, self::ENTITY);
    }


}
