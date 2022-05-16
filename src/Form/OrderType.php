<?php
// src/Form/Type/TaskType.php
namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                
            ->add('phone', IntegerType::class, [
                'label' => 'phone', 
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ])
            
            ->add('registration_number', TextType::class, [
                'label' => 'registration_number', 
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
            ->add('status', HiddenType::class, [
                'data' => 'pending',
            ]);
    
        ;
    }

    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}