<?php

namespace App\Controller\Rubric;

use App\Controller\AppControllerAbstract;
use App\Dto\RubricDto;
use App\Dto\UnderRubricDto;
use App\Entity\Rubric;
use App\Form\Admin\RubricType;
use App\Repository\RubricDtoRepository;
use App\Repository\RubricRepository;
use App\Manager\RubricManager;
use App\Repository\UnderRubricDtoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/")
 */
class RubricController extends AppControllerAbstract
{
    const ENTITYS = 'rubrics';
    const ENTITY = 'rubric';


    /**
     * @Route("/rubric/{id}", name="rubric_show", methods={"GET"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function showAction(
        Rubric $rubric,
        UnderRubricDto $underrubricDto,
        UnderRubricDtoRepository $underrubricDtoRepository
    ) {
        $underrubricDto
            ->setRubric($rubric);

        if (!$this->isGranted('ROLE_GESTIONNAIRE')) {
            $underrubricDto
                ->setEnable(RubricDto::TRUE)
                ->setRubricEnable(RubricDto::TRUE)
                ->setUnderThematicEnable(RubricDto::TRUE)
                ->setThematicEnable(RubricDto::TRUE);
        }

        return $this->render(self::ENTITY.'/list.html.twig', [
            self::ENTITY => $rubric,
            'underRubrics'=> $underrubricDtoRepository->findAllForDto($underrubricDto)
        ]);
    }

}
