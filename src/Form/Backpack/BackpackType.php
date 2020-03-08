<?php

namespace App\Form\Backpack;

use App\Entity\Backpack;
use App\Entity\UnderRubric;
use App\Form\AppTypeAbstract;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BackpackType extends AppTypeAbstract
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder = $this->buildFormNameEnableContent($builder);
        $builder
            ->add('underrubric', EntityType::class, [
                self::CSS_CLASS => UnderRubric::class,
                self::CHOICE_LABEL => 'name',
                self::GROUP_BY => 'rubric.name',
                self::LABEL=>'Sous-rubrique',
                self::MULTIPLE => false,
                self::ATTR => [self::CSS_CLASS => 'select2'],
                self::REQUIRED => false,
                self::QUERY_BUILDER => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->select('c')
                        ->orderBy('c.name', 'ASC');
                }])
            ->add('dir1', TextType::class, [
                self::REQUIRED => false
            ])
            ->add('dir2', TextType::class, [
                self::REQUIRED => false
            ])
            ->add('dir3', TextType::class, [
                self::REQUIRED => false
            ])
            ->add('dir4', TextType::class, [
                self::REQUIRED => false
            ])
            ->add('dir5', TextType::class, [
                self::REQUIRED => false
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Backpack::class,
        ]);
    }
}
