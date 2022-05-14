<?php
// src/Form/Type/TaskType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer_name', TextType::class, [
                'label' => 'customer_name', 
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ])
                
            ->add('type_id', IntegerType::class, [
                'label' => 'type_id', 
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ])
     
        ;
    }
}