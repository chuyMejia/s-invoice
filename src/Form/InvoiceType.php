<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType; // Agrega esta línea
use Symfony\Component\Form\Extension\Core\Type\NumberType; // Importa NumberType

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ninvoice', TextType::class, [
                'label' => 'Número de Factura',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Ingresa el número de factura',
                    'maxlength' => 10,
                ],
            ])
            ->add('rfc', TextType::class, [
                'label' => 'RFC',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Ingresa el RFC',
                    'maxlength' => 13, // Ajusta según sea necesario
                ],
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Comentario',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Escribe un comentario',
                ],
            ])
            // ->add('priority', ChoiceType::class, [
            //     'label' => 'Status',
            //     'attr' => [
            //         'class' => 'form-control mb-3',
            //     ],
            //     'choices' => [
            //         '0' => 0,
                    
            //     ],
            // ])
            ->add('mount', TextType::class, [
                'label' => 'Monto',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Ingresa el monto',
                ],
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Regex([
                        'pattern' => '/^\d+(\.\d{1,2})?$/', // Acepta solo números y hasta dos decimales
                        'message' => 'Por favor, ingresa un monto válido (ejemplo: 20.20).',
                    ]),
                ],
            ])            
            ->add('dateInvoice', DateType::class, [
                'label' => 'Fecha de Factura',
                'widget' => 'single_text', // Usar un solo campo de texto
                'html5' => true, // Habilitar el input de tipo date
                'attr' => [
                    'class' => 'form-control mb-3', // Clases de Bootstrap para estilo
                    'placeholder' => 'Selecciona la fecha', // Texto de ayuda
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Guardar',
                'attr' => ['class' => 'btn btn-primary w-100'], // Clase para que ocupe el 100%
            ]);
            
    }
}
