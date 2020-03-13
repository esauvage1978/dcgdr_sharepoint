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
use App\Security\ActionVoter;
use App\Security\RubricVoter;
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
        $this->denyAccessUnlessGranted(RubricVoter::READ, $rubric);

        $underrubricDto
            ->setRubric($rubric)
            ->setEnable(UnderRubricDto::TRUE)
            ->setRubricEnable(UnderRubricDto::TRUE)
            ->setUnderThematicEnable(UnderRubricDto::TRUE)
            ->setThematicEnable(UnderRubricDto::TRUE);

        if (!$this->isgranted('ROLE_GESTIONNAIRE')) {
            $underrubricDto
                ->setUser($this->getUser());
        }

        return $this->render(self::ENTITY.'/list.html.twig', [
            self::ENTITY => $rubric,
            'underRubrics'=> $underrubricDtoRepository->findAllForDto($underrubricDto, UnderRubricDtoRepository::FILTRE_DTO_INIT_HOME)
        ]);
    }

}
