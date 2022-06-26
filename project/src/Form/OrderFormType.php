<?php

namespace App\Form;

use App\Entity\ShopOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder
////            ->add('status')
//            ->add('status',HiddenType::class)
//            ->add('session_id',HiddenType::class)
//            ->add('user_name', TextType::class)
//            ->add('user_email', EmailType::class)
//            ->add('user_phone', TextType::class)
//        ;
        $builder
            ->add('status', HiddenType::class)
            ->add('session_id', HiddenType::class)
            ->add(
                'user_name',
                TextType::class,
                [
                    'label' => 'Имя',
                ]
            )
            ->add(
                'user_email',
                EmailType::class,
                [
                    'label' => 'email',
                ]
            )
            ->add(
                'user_phone',
                NumberType::class,
                [
                    'label' => 'Телефон',
                ]
            )
            ->add(
                'address',
                TextType::class,
                [
                    'label' => 'Адрес',
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Сохранить',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShopOrder::class,
        ]);
    }
}
