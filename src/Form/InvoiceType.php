<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType; // Importa NumberType

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ninvoice', TextType::class, [
                'label' => 'ninvoice'
            ])
            ->add('rfc', TextType::class, [
                'label' => 'rfc'
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'comment'
            ])
            ->add('priority', ChoiceType::class, [
                'label' => 'status',
                'choices'=> [
                    'Alta' => 'high',
                    'Medio' => 'medium',
                    'Baja' => 'low',
                ]
            ])
            ->add('mount', NumberType::class, [ // Agregando el campo mount
                'label' => 'Monto',
                'scale' => 2, // Número de decimales
                'html5' => true, // Habilita el input de tipo number
                'required' => false, // Si deseas que sea opcional
            ])
            ->add('dateInvoice', DateTimeType::class, [
                'label' => 'Fecha de Factura',
                'widget' => 'single_text', // Usar un solo campo de texto
                'html5' => true, // Habilitar el input de tipo datetime-local
                'input' => 'datetime', // Tipo de entrada esperado
                // Eliminar la opción 'format'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Guardar'
            ]);
    }
}
