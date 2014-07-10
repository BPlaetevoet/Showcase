<?php
namespace Bplaetevoet\HomeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AfbeeldingType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
                ->add('file', 'file')
                
               ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bplaetevoet\HomeBundle\Entity\Afbeelding',
            'cascade_validation' => true,
        ));
    }
 
    public function getName()
    {
        return 'afbeelding';
    }
}

