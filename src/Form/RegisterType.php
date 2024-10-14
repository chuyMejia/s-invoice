<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Ingresa tu nombre'
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Apellido',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Ingresa tu apellido'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Ingresa tu email'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Ingresa tu contraseña'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Registrar',
                'attr' => [
                    'class' => 'btn btn-primary w-100' // Estilo para el botón
                ]
            ]);
    }
}
