<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        //$builder->add('name');
        $builder->remove('username');
        $builder
                ->add('firstname', 'text', array('label' => 'form.firstname','translation_domain' => 'FOSUserBundle', 'required' => false))
                ->add('lastname', 'text', array('label' => 'form.lastname','translation_domain' => 'FOSUserBundle', 'required' => false))
        ;


//        $builder->remove('usernameCanonical');*/
    }

    public function getName()
    {
        return 'tracker_user_registration';
    }
}