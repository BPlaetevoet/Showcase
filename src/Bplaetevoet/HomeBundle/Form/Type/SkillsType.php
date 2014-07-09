<?php
// src/Bplaetevoet/HomeBundle/Form/Type/SkillsType.php
namespace Bplaetevoet\HomeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SkillsType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('skills', 'entity', array('label'=>'Selecteer de gebruikte skills',
                    'class'=>'BplaetevoetHomeBundle:Skill',
                    'choices'=> $em->getRepository('BplaetevoetHomeBundle:Skill')->findAll(),
                    'property'=>'naam',
                    'multiple'=>true,
                    'expanded'=>true));
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bplaetevoet\HomeBundle\Entity\Skill'
        ));
    }

    public function getName()
    {
        return 'skill';
    }
}

