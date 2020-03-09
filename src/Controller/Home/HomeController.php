<?php

namespace App\Controller\Home;

use App\Dto\BackpackDto;
use App\Dto\RubricDto;
use App\Dto\UnderRubricDto;
use App\Repository\BackpackDtoRepository;
use App\Repository\RubricDtoRepository;
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
     * @IsGranted("ROLE_USER")
     */
    public function index(
        RubricDto $rubricDto,
        RubricDtoRepository $rubricDtoRepository
    )
    {
        if (!$this->isGranted('ROLE_GESTIONNAIRE')) {
            $rubricDto
                ->setEnable(RubricDto::TRUE)
                ->setThematicEnable(RubricDto::TRUE);
        }

        return $this->render('home/home.html.twig', [
            'rubrics' => $rubricDtoRepository->findAllForDto($rubricDto),
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

        $underRubricDto
            ->setWordSearch($request->request->get('search'));;
        $rubricDto
            ->setWordSearch($request->request->get('search'));
        $backpackDto
            ->setArchiving(BackpackDto::FALSE)
            ->setWordSearch($request->request->get('search'));
        $backpackDtoArchiving
            ->setArchiving(BackpackDto::TRUE)
            ->setWordSearch($request->request->get('search'));


        if (!$this->isGranted('ROLE_GESTIONNAIRE')) {
            $underRubricDto
                ->setEnable(UnderRubricDto::TRUE)
                ->setThematicEnable(UnderRubricDto::TRUE)
                ->setUnderThematicEnable(UnderRubricDto::TRUE)
                ->setRubricEnable(UnderRubricDto::TRUE);

            $rubricDto
                ->setEnable(RubricDto::TRUE)
                ->setThematicEnable(RubricDto::TRUE);

            $backpackDto
                ->setEnable(RubricDto::TRUE)
                ->setUnderThematicEnable(RubricDto::TRUE)
                ->setThematicEnable(RubricDto::TRUE)
                ->setUnderRubricEnable(RubricDto::TRUE)
                ->setRubricEnable(RubricDto::TRUE);

            $backpackDtoArchiving
                ->setEnable(RubricDto::TRUE)
                ->setUnderThematicEnable(RubricDto::TRUE)
                ->setThematicEnable(RubricDto::TRUE)
                ->setUnderRubricEnable(RubricDto::TRUE)
                ->setRubricEnable(RubricDto::TRUE);
        }

        return $this->render(
            'home/search.html.twig',
            [
                'rubrics' => $rubricDtoRepository->findAllForDto($rubricDto),
                'underrubrics' => $underRubricDtoRepository->findAllForDto($underRubricDto),
                'backpacks'=>$backpackDtoRepository->findAllForDto($backpackDto),
                'archivings'=>$backpackDtoRepository->findAllForDto($backpackDtoArchiving)
            ]);
    }
}
