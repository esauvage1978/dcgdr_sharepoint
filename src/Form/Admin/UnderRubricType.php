<?php

namespace App\Form\Admin;

use App\Entity\Civilite;
use App\Entity\Picture;
use App\Entity\Rubric;
use App\Entity\Thematic;
use App\Entity\UnderRubric;
use App\Entity\UnderThematic;
use App\Form\AppTypeAbstract;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnderRubricType extends AppTypeAbstract
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder = $this->buildFormNameEnableContent($builder);
        $builder = $this->buildFormReaders($builder);
        $builder = $this->buildFormWriters($builder);
        $builder
            ->add('showall', CheckboxType::class,
                [
                    self::LABEL => '  Visible par tous',
                    self::REQUIRED => false,
                ])
            ->add('picture', EntityType::class, [
                self::CSS_CLASS => Picture::class,
                self::LABEL=>'Image de présentaion',
                self::CHOICE_LABEL => 'href',
                self::MULTIPLE => false,
                self::ATTR => [self::CSS_CLASS => 'select2'],
                self::REQUIRED => true,
                self::QUERY_BUILDER => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->select('c')
                        ->orderBy('c.name', 'ASC');
                }])
            ->add('rubric', EntityType::class, [
                self::CSS_CLASS => Rubric::class,
                self::CHOICE_LABEL => 'name',
                self::LABEL=>'Rubrique',
                self::MULTIPLE => false,
                self::ATTR => [self::CSS_CLASS => 'select2'],
                self::REQUIRED => false,
                self::QUERY_BUILDER => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->select('c')
                        ->orderBy('c.name', 'ASC');
                }])
            ->add('underthematic', EntityType::class, [
                self::CSS_CLASS => UnderThematic::class,
                self::CHOICE_LABEL => 'name',
                self::LABEL=>'Sous thématique',
                self::MULTIPLE => false,
                self::ATTR => [self::CSS_CLASS => 'select2'],
                self::REQUIRED => true,
                self::QUERY_BUILDER => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->select('c')
                        ->orderBy('c.name', 'ASC');
                }])
            ->add('showOrder',IntegerType::class,[
                self::LABEL=>'Ordre d\'affichage'

            ] );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UnderRubric::class,
        ]);
    }
}
