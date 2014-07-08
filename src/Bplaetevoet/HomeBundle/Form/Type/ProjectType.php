<?php
// src/Bplaetevoet/HomeBundle/Form/Type/ProjectType.php
namespace Bplaetevoet\HomeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('naam', 'text')
                ->add('omschrijving', 'textarea')
                ->add('url', 'url');
            
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bplaetevoet\HomeBundle\Entity\Project',
        ));
    }

    public function getName()
    {
        return 'project';
    }
}
