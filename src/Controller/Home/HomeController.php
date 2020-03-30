<?php

namespace App\Controller\Home;

use App\Dto\BackpackDto;
use App\Dto\RubricDto;
use App\Dto\UnderRubricDto;
use App\Repository\BackpackDtoRepository;
use App\Repository\MessageRepository;
use App\Repository\RubricDtoRepository;
use App\Repository\RubricRepository;
use App\Repository\UnderRubricDtoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        RubricDto $rubricDto,
        RubricDtoRepository $rubricDtoRepository,
        RubricRepository $rp,
        MessageRepository $messageRepository
    )
    {
        $rubricDto
            ->setEnable(RubricDto::TRUE)
            ->setThematicEnable(RubricDto::TRUE)
            ->setUnderRubricEnable(RubricDto::TRUE)
            ->setUnderThematicEnable(RubricDto::TRUE);

        if (!$this->isgranted('ROLE_GESTIONNAIRE')) {
            $rubricDto
                ->setUser($this->getUser());
        }

        return $this->render('home/home.html.twig', [
            'rubrics' => $rubricDtoRepository->findAllForDto($rubricDto, RubricDtoRepository::FILTRE_DTO_INIT_HOME),
            'messages'=> $messageRepository->findBy(['name'=>'home'])
        ]);
    }


    /**
     * @Route("/search/", name="home_search", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function homeSearchAction(
        Request $request,
        RubricDtoRepository $rubricDtoRepository,
        UnderRubricDtoRepository $underRubricDtoRepository,
        BackpackDtoRepository $backpackDtoRepository
    ): Response
    {
        $underRubricDto = new UnderRubricDto();
        $rubricDto = new RubricDto();
        $backpackDto = new BackpackDto();
        $backpackDtoArchiving = new BackpackDto();
        $backpackDtoEnable = new BackpackDto();

        $underRubricDto
            ->setUser($this->getUser())
            ->setWordSearch($request->request->get('search'))
            ->setEnable(UnderRubricDto::TRUE)
            ->setThematicEnable(UnderRubricDto::TRUE)
            ->setUnderThematicEnable(UnderRubricDto::TRUE)
            ->setRubricEnable(UnderRubricDto::TRUE);

        $rubricDto
            ->setUser($this->getUser())
            ->setWordSearch($request->request->get('search'))
            ->setEnable(RubricDto::TRUE)
            ->setThematicEnable(RubricDto::TRUE)
            ->setUnderRubricEnable(RubricDto::TRUE)
            ->setUnderThematicEnable(RubricDto::TRUE);

        $backpackDto
            ->setArchiving(BackpackDto::FALSE)
            ->setWordSearch($request->request->get('search'))
            ->setEnable(BackpackDto::TRUE)
            ->setUnderThematicEnable(BackpackDto::TRUE)
            ->setThematicEnable(BackpackDto::TRUE)
            ->setUnderRubricEnable(BackpackDto::TRUE)
            ->setRubricEnable(BackpackDto::TRUE);

        $backpackDtoArchiving
            ->setArchiving(BackpackDto::TRUE)
            ->setWordSearch($request->request->get('search'))
            ->setEnable(BackpackDto::TRUE)
            ->setUnderThematicEnable(BackpackDto::TRUE)
            ->setThematicEnable(BackpackDto::TRUE)
            ->setUnderRubricEnable(BackpackDto::TRUE)
            ->setRubricEnable(BackpackDto::TRUE);

        $backpackDtoEnable
            ->setWordSearch($request->request->get('search'))
            ->setEnable(BackpackDto::FALSE);

        if (!$this->isgranted('ROLE_GESTIONNAIRE')) {
            $rubricDto
                ->setUser($this->getUser());
            $underRubricDto
                ->setUser($this->getUser());
            $backpackDto
                ->setUser($this->getUser());
            $backpackDtoArchiving
                ->setUser($this->getUser());
            $backpackDtoEnable
                ->setUser($this->getUser());
        }

        return $this->render(
            'home/search.html.twig',
            [
                'rubrics' => $rubricDtoRepository->findAllForDto($rubricDto),
                'underrubrics' => $underRubricDtoRepository->findAllForDto($underRubricDto),
                'backpacks'=>$backpackDtoRepository->findAllForDto($backpackDto),
                'archivings'=>$backpackDtoRepository->findAllForDto($backpackDtoArchiving),
                'enables'=>$this->isGranted('ROLE_EDITEUR')?$backpackDtoRepository->findAllForDto($backpackDtoEnable):[]
            ]);
    }
}
