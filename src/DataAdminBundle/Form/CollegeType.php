<?php

namespace DataAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollegeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('collegeName')->add('tneaCode')->add('pageUrl')->add('addressTa')->add('addressEn')->add('pincode')->add('phoneNo')->add('faxNo')->add('email_id')->add('websiteName')->add('hqDistance')->add('railwayNear')->add('railwayDistance')->add('lat')->add('lng')->add('isActive')->add('isBlocked')->add('modifiedon')->add('createdon')->add('viewed')->add('districtId');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DataAdminBundle\Entity\College'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dataadminbundle_college';
    }


}
