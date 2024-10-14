<?php

namespace App\Form;

use App\Entity\Response;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pdfFilename', FileType::class, [
                'label' => 'Archivo PDF',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Ingresa el número de factura',
                    'maxlength' => 10,
                ],
            ])
            ->add('xmlFilename', FileType::class, [
                'label' => 'Archivo XML',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Ingresa el número de factura',
                    'maxlength' => 10,
                ],
            ])
            ->add('uuid', TextType::class, [ // Cambiado a 'uuid'
                'label' => 'UUID',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Ingresa el número de factura',
                    'maxlength' => 10,
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Guardar',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Response::class,
        ]);
    }
}
