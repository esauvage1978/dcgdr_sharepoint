<?php

namespace App\Controller\Backpack;

use App\Controller\AppControllerAbstract;
use App\Dto\BackpackDto;
use App\Entity\Action;
use App\Entity\Backpack;
use App\Entity\Rubric;
use App\Entity\Thematic;
use App\Entity\UnderRubric;
use App\Form\Admin\ThematicType;
use App\Form\Backpack\BackpackNewType;
use App\Form\Backpack\BackpackType;
use App\History\BackpackHistory;
use App\History\HistoryShow;
use App\Manager\BackpackManager;
use App\Repository\ActionFileRepository;
use App\Repository\BackpackDtoRepository;
use App\Repository\BackpackFileRepository;
use App\Repository\ThematicRepository;
use App\Manager\ThematicManager;
use App\Security\ActionVoter;
use App\Security\BackpackVoter;
use App\Security\RubricVoter;
use App\Security\UnderRubricVoter;
use Symfony\Component\HttpFoundation\File\File;
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
     * @Route("/backpack/news", name="backpack_news", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function backpackNews(
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
     * @Route("/backpack/new", name="backpack_new", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_EDITEUR")
     */
    public function newAction(Request $request, BackpackManager $manager): Response
    {
        $entity=new Backpack();
        $form = $this->createForm(BackpackNewType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($entity)) {
                $this->addFlash(self::SUCCESS, self::MSG_CREATE);

                if (!empty($entity->getId())) {
                    return $this->redirectToRoute(self::ENTITY . '_edit', ['id' => $entity->getId()]);
                } else {
                    return $this->redirectToRoute(self::ENTITY . '_index');
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
                'backpacks' => $backpackDtoRepository->findAllForDto($backpackDto,BackpackDtoRepository::FILTRE_DTO_INIT_HOME)
            ]);
    }


    /**
     * @Route("/backpack/news/rubric/{id}", name="backpack_new_rubric", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function backpackNewRubric(
        Request $request,
        BackpackDtoRepository $backpackDtoRepository,
        Rubric $rubric
    ): Response
    {
        $this->denyAccessUnlessGranted(RubricVoter::READ, $rubric);

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
     * @Route("/backpack/news/underrubric/{id}", name="backpack_new_underrubric", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function backpackNewUnderRubric(
        Request $request,
        BackpackDtoRepository $backpackDtoRepository,
        UnderRubric $underrubric
    ): Response
    {

        $this->denyAccessUnlessGranted(UnderRubricVoter::READ, $underrubric);

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
        Backpack $backpack,
        BackpackManager $manager,
        backpackHistory $backpackHistory
    ): Response
    {

        $this->denyAccessUnlessGranted(BackpackVoter::UPDATE, $backpack);
        $backpackOld = clone($backpack);
        $form = $this->createForm(BackpackType::class, $backpack);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($backpack)) {
                $this->addFlash(self::SUCCESS, self::MSG_MODIFY);

                $backpackHistory->compare($backpackOld, $backpack);
                    return $this->redirectToRoute(self::ENTITY . '_edit', ['id' => $backpack->getId()]);

            }
            $this->addFlash(self::DANGER, self::MSG_ERROR . $manager->getErrors($backpack));
        }

        return $this->render(self::ENTITY . '/edit.html.twig', [
            self::ENTITY => $backpack,
            self::FORM => $form->createView(),
        ]);
    }
    /**
     * @Route("/backpack/{id}/history", name="backpack_history", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function history(
        Request $request,
        Backpack $entity
    ): Response
    {
        $historyShow=new HistoryShow(
            $this->generateUrl('backpack_edit',['id'=>$entity->getId()]),
            "Porte-document : " . $entity->getName(),
            "Historiques des modifications du porte-document"
        );
        return $this->render('history/show.html.twig', [
            'histories' => $entity->getHistories(),
            'data'=>$historyShow->getParams()
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
        $this->denyAccessUnlessGranted(BackpackVoter::READ, $backpack);

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

    /**
     * @Route("/backpack/{id}/file/{fileId}", name="backpack_file_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function actionFileShowAction(
        Request $request,
        Backpack $backpack,
        string $fileId,
        BackpackFileRepository $backpackFileRepository): Response
    {
        $this->denyAccessUnlessGranted(BackpackVoter::READ, $backpack);

        $actionFile = $backpackFileRepository->find($fileId);

        // load the file from the filesystem
        $file = new File($actionFile->getHref());

        // rename the downloaded file
        return $this->file($file, $actionFile->getTitle().'.'.$actionFile->getFileExtension());
    }
}
