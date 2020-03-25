<?php

namespace App\Controller\Ajax;

use App\Controller\AppControllerAbstract;
use App\Dto\RubricDto;
use App\Dto\UnderRubricDto;
use App\Repository\AxeRepository;
use App\Repository\BackpackRepository;
use App\Repository\RubricDtoRepository;
use App\Repository\RubricRepository;
use App\Repository\UnderRubricDtoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FillComboboxController extends AppControllerAbstract
{
    /**
     * @Route("/ajax/getrubrics", name="ajax_fill_combobox_rubrics", methods={"POST"})
     *
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function AjaxGetRubrics(Request $request, RubricDtoRepository $rubricDtoRepository): Response
    {
        $rubricDto=new RubricDto();
        $rubricDto
            ->setEnable(RubricDto::TRUE)
            ->setThematicEnable(RubricDto::TRUE)
            ->setUnderThematicEnable(RubricDto::TRUE)
            ->setUnderRubricEnable(RubricDto::TRUE)
            ->setUser($this->getUser());

        if ($request->isXmlHttpRequest()) {
            return $this->json(
                $rubricDtoRepository->findForCombobox($rubricDto)
            );
        }

        return new Response("Ce n'est pas une requête Ajax");
    }
    /**
     * @Route("/ajax/getunderrubrics", name="ajax_fill_combobox_underrubrics", methods={"POST"})
     *
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function AjaxGetUnderRubrics(
        Request $request,
        UnderRubricDtoRepository $underrubricDtoRepository,
        RubricRepository $rubricRepository): Response
    {
        $idRubric=$request->request->get('id');
        $rubric=$rubricRepository->find($idRubric);

        $underrubricDto=new UnderRubricDto();
        $underrubricDto
            ->setRubric($rubric)
            ->setEnable(UnderRubricDto::TRUE)
            ->setThematicEnable(UnderRubricDto::TRUE)
            ->setUnderThematicEnable(UnderRubricDto::TRUE)
            ->setRubricEnable(UnderRubricDto::TRUE)
            ->setUser($this->getUser());

        if ($request->isXmlHttpRequest()) {
            return $this->json(
                $underrubricDtoRepository->findForCombobox($underrubricDto)
            );
        }

        return new Response("Ce n'est pas une requête Ajax");
    }

    /**
     * @Route("/ajax/getdir1", name="ajax_fill_combobox_dir1", methods={"POST"})
     *
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function AjaxGetDir1(Request $request, BackpackRepository $repository): Response
    {
        $data=null;
        if($request->request->has('id')) {
            $data=$request->request->get('id');
        }
        if ($request->isXmlHttpRequest()) {
            return $this->json(
                $repository->findAllFillComboboxDir1(
                    $data)
                );
        }

        return new Response("Ce n'est pas une requête Ajax");
    }
    /**
     * @Route("/ajax/getdir2", name="ajax_fill_combobox_dir2", methods={"POST"})
     *
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function AjaxGetDir2(Request $request, BackpackRepository $repository): Response
    {
        $id=null;
        $data=null;
        if($request->request->has('id')) {
            $id=$request->request->get('id');
        }

        if($request->request->has('data')) {
            $data=$request->request->get('data');
        }
        if ($request->isXmlHttpRequest()) {
            return $this->json(
                $repository->findAllFillComboboxDir2(
                    $id,$data)
            );
        }

        return new Response("Ce n'est pas une requête Ajax");
    }
    /**
     * @Route("/ajax/getdir3", name="ajax_fill_combobox_dir3", methods={"POST"})
     *
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function AjaxGetDir3(Request $request, BackpackRepository $repository): Response
    {
        $id=null;
        $data=null;
        if($request->request->has('id')) {
            $id=$request->request->get('id');
        }

        if($request->request->has('data')) {
            $data=$request->request->get('data');
        }
        if ($request->isXmlHttpRequest()) {
            return $this->json(
                $repository->findAllFillComboboxDir3(
                    $id,$data)
            );
        }

        return new Response("Ce n'est pas une requête Ajax");
    }
    /**
     * @Route("/ajax/getdir4", name="ajax_fill_combobox_dir4", methods={"POST"})
     *
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function AjaxGetDir4(Request $request, BackpackRepository $repository): Response
    {
        $id=null;
        $data=null;
        if($request->request->has('id')) {
            $id=$request->request->get('id');
        }

        if($request->request->has('data')) {
            $data=$request->request->get('data');
        }
        if ($request->isXmlHttpRequest()) {
            return $this->json(
                $repository->findAllFillComboboxDir4(
                    $id,$data)
            );
        }

        return new Response("Ce n'est pas une requête Ajax");
    }
    /**
     * @Route("/ajax/getdir5", name="ajax_fill_combobox_dir5", methods={"POST"})
     *
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function AjaxGetDir5(Request $request, BackpackRepository $repository): Response
    {
        $id=null;
        $data=null;
        if($request->request->has('id')) {
            $id=$request->request->get('id');
        }

        if($request->request->has('data')) {
            $data=$request->request->get('data');
        }
        if ($request->isXmlHttpRequest()) {
            return $this->json(
                $repository->findAllFillComboboxDir5(
                    $id,$data)
            );
        }

        return new Response("Ce n'est pas une requête Ajax");
    }
}
