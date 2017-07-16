<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder
                ->remove('username')
                ->remove('email')
                ->remove('current_password')
        ;
        $builder
                ->add('firstname', 'text', array('label' => 'form.firstname','translation_domain' => 'FOSUserBundle', 'required' => false))
                ->add('lastname', 'text', array('label' => 'form.lastname','translation_domain' => 'FOSUserBundle', 'required' => false))
        ;
        
    }

    public function getName() {
        return 'tracker_user_profile';
    }

}