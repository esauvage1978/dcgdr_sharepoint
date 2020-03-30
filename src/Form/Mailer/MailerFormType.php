<?php

namespace App\Form\Mailer;

use App\Form\AppTypeAbstract;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MailerFormType extends AppTypeAbstract
{
    public function buildFormSubjectContent(FormBuilderInterface $builder): FormBuilderInterface
    {
        return $builder
            ->add('subject', TextType::class, [
                self::LABEL => ' ',
                self::ATTR => ['placeholder' => 'Objet du mail : '],
                self::REQUIRED => true
            ])
            ->add('content', TextareaType::class, [
                self::LABEL => ' ',
                self::REQUIRED => true,
                self::ATTR => [self::ROWS => 8, self::CSS_CLASS => 'textarea'],
            ]);
    }
}
