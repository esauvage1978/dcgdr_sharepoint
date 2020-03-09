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
        $rubricDto
            ->setEnable(RubricDto::TRUE)
            ->setThematicEnable(RubricDto::TRUE);

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
        $underRubricDto
            ->setEnable(UnderRubricDto::TRUE)
            ->setThematicEnable(UnderRubricDto::TRUE)
            ->setUnderThematicEnable(UnderRubricDto::TRUE)
            ->setRubricEnable(UnderRubricDto::TRUE)
            ->setWordSearch($request->request->get('search'));;

        $rubricDto = new RubricDto();
        $rubricDto
            ->setEnable(RubricDto::TRUE)
            ->setThematicEnable(RubricDto::TRUE)
            ->setWordSearch($request->request->get('search'));

        $backpackDto = new BackpackDto();
        $backpackDto
            ->setEnable(BackpackDto::TRUE)
            ->setUnderRubricEnable(BackpackDto::TRUE)
            ->setThematicEnable(BackpackDto::TRUE)
            ->setUnderThematicEnable(BackpackDto::TRUE)
            ->setRubricEnable(BackpackDto::TRUE)
            ->setWordSearch($request->request->get('search'));

        return $this->render(
            'home/search.html.twig',
            [
                'rubrics' => $rubricDtoRepository->findAllForDto($rubricDto),
                'underrubrics' => $underRubricDtoRepository->findAllForDto($underRubricDto),
                'backpacks'=>$backpackDtoRepository->findAllForDto($backpackDto)
            ]);
    }
}
