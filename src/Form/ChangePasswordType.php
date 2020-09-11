<?php
/**
 * ChangePassword type.
 */

namespace App\Form;

use App\Entity\User;
use App\Entity\Article;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ChangePasswordType.
 */
class ChangePasswordType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array $options The options
     * @see FormTypeExtensionInterface::buildForm()
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'password',
                PasswordType::class)
            ->add('plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'label_password'],
                    'second_options' => ['label' => 'label_repeat_password'],
                    'required' => true,
                    'attr' => ['max_length' => 180],

                ]
            );
//
//            'type' => 'password',
//            'invalid_message' => 'The password fields must match.',
//            'required' => true,
//            'first_options'  => array('label' => 'Password'),
//            'second_options' => array('label' => 'Repeat Password'),
//        ));


//        $builder->add(
//            'plainPassword',
//            RepeatedType::class,
//            [
//                'type' => PasswordType::class,
//                'first_options'  => ['label' => 'label_password'],
//                'second_options' => ['label' => 'label_repeat_password'],
//                'required' => true,
//                'attr' => ['max_length' => 180],
//
//            ]
//        );
    }

    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'user';
    }
}