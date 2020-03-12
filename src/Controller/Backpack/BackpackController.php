<?php

namespace App\Controller\Backpack;

use App\Controller\AppControllerAbstract;
use App\Dto\BackpackDto;
use App\Entity\Backpack;
use App\Entity\Rubric;
use App\Entity\Thematic;
use App\Entity\UnderRubric;
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
     * @Route("/backpack/new", name="backpack_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function backpackNew(
        Request $request,
        BackpackDtoRepository $backpackDtoRepository
    ): Response
    {
        $backpackDto = new BackpackDto();

        $backpackDto
            ->setNew(BackpackDto::TRUE)
            ->setEnable(BackpackDto::TRUE)
            ->setUnderThematicEnable(BackpackDto::TRUE)
            ->setThematicEnable(BackpackDto::TRUE)
            ->setUnderRubricEnable(BackpackDto::TRUE)
            ->setRubricEnable(BackpackDto::TRUE);

        if (!$this->isgranted('ROLE_GESTIONNAIRE')) {
            $backpackDto
                ->setUser($this->getUser());
        }

        return $this->render(
            'backpack/listNew.html.twig',
            [
                'backpacks' => $backpackDtoRepository->findAllForDto($backpackDto)
            ]);
    }


    /**
     * @Route("/backpack/archiving", name="backpack_archiving", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function archiving(
        Request $request,
        BackpackDtoRepository $backpackDtoRepository
    ): Response
    {
        $backpackDtoArchiving = new BackpackDto();

        $backpackDtoArchiving
            ->setArchiving(BackpackDto::TRUE)
            ->setEnable(BackpackDto::TRUE)
            ->setUnderThematicEnable(BackpackDto::TRUE)
            ->setThematicEnable(BackpackDto::TRUE)
            ->setUnderRubricEnable(BackpackDto::TRUE)
            ->setRubricEnable(BackpackDto::TRUE);

        if (!$this->isgranted('ROLE_GESTIONNAIRE')) {
            $backpackDtoArchiving
                ->setUser($this->getUser());
        }

        return $this->render(
            'backpack/archiving.html.twig',
            [
                'backpacks' => $backpackDtoRepository->findAllForDto($backpackDtoArchiving)
            ]);
    }

    /**
     * @Route("/backpack/disable", name="backpack_disable", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function disable(
        Request $request,
        BackpackDtoRepository $backpackDtoRepository
    ): Response
    {
        $backpackDto = new BackpackDto();

        $backpackDto
            ->setEnable(BackpackDto::FALSE);

        if (!$this->isgranted('ROLE_GESTIONNAIRE')) {
            $backpackDto
                ->setUser($this->getUser());
        }

        return $this->render(
            'backpack/disable.html.twig',
            [
                'backpacks' => $backpackDtoRepository->findAllForDto($backpackDto)
            ]);
    }


    /**
     * @Route("/backpack/new/rubric/{id}", name="backpack_new_rubric", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function backpackNewRubric(
        Request $request,
        BackpackDtoRepository $backpackDtoRepository,
        Rubric $rubric
    ): Response
    {
        $backpackDto = new BackpackDto();

        $backpackDto
            ->setRubric($rubric)
            ->setNew(BackpackDto::TRUE)
            ->setEnable(BackpackDto::TRUE)
            ->setUnderThematicEnable(BackpackDto::TRUE)
            ->setThematicEnable(BackpackDto::TRUE)
            ->setUnderRubricEnable(BackpackDto::TRUE)
            ->setRubricEnable(BackpackDto::TRUE);

        if (!$this->isgranted('ROLE_GESTIONNAIRE')) {
            $backpackDto
                ->setUser($this->getUser());
        }

        return $this->render(
            'backpack/listNew.html.twig',
            [
                'backpacks' => $backpackDtoRepository->findAllForDto($backpackDto)
            ]);
    }

    /**
     * @Route("/backpack/new/underrubric/{id}", name="backpack_new_underrubric", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function backpackNewUnderRubric(
        Request $request,
        BackpackDtoRepository $backpackDtoRepository,
        UnderRubric $underrubric
    ): Response
    {
        $backpackDto = new BackpackDto();

        $backpackDto
            ->setUnderRubric($underrubric)
            ->setNew(BackpackDto::TRUE)
            ->setEnable(BackpackDto::TRUE)
            ->setUnderThematicEnable(BackpackDto::TRUE)
            ->setThematicEnable(BackpackDto::TRUE)
            ->setUnderRubricEnable(BackpackDto::TRUE)
            ->setRubricEnable(BackpackDto::TRUE);

        if (!$this->isgranted('ROLE_GESTIONNAIRE')) {
            $backpackDto
                ->setUser($this->getUser());
        }

        return $this->render(
            'backpack/listNew.html.twig',
            [
                'backpacks' => $backpackDtoRepository->findAllForDto($backpackDto)
            ]);
    }


    /**
     * @Route("/backpack/add", name="backpack_add", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function addAction(Request $request, ThematicManager $manager): Response
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
