<?php

namespace App\Form;

use App\Entity\Subscriber;
use App\Service\CategoryService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriberType extends AbstractType
{

    /**
     * @var CategoryService
     */
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add(
                'categories',
                ChoiceType::class,
                [
                    'multiple' => true,
                    'choices' => $this->categoryService->getAvailableCategories(),
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Subscriber::class,
            ]
        );
    }
}
