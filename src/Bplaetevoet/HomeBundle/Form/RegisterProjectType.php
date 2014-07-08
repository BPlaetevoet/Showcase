<?php
namespace Bplaetevoet\HomeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterProjectType extends AbstractType{
    public function buildForm(FormTypeInterface $builder, array $options){
        
        $builder
                ->add('project', new ProjectType())
                ->add('afbeelding', new AfbeeldingType());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bplaetevoet\HomeBundle\Entity\RegisterProject',
        ));
    }
 
    public function getName()
    {
        return 'projectform';
    }
}
