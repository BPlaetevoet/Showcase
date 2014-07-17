<?php
// src/Bplaetevoet/HomeBundle/Form/Type/ProjectType.php
namespace Bplaetevoet\HomeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Bplaetevoet\HomeBundle\Form\EventListener\AddAfbeeldingFieldSubscriber;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('naam', 'text')
                ->add('omschrijving', 'textarea')
                ->add('url', 'url');
        $builder->addEventSubscriber(new AddAfbeeldingFieldSubscriber());
                //->add('file', 'file', array('label'=>'Afbeelding:'))
        $builder->add('skills', 'entity', array(
                    'label'=>'Selecteer de gebruikte skills',
                    'class'=>'BplaetevoetHomeBundle:Skill',
                    'query_builder'=> function(\Doctrine\ORM\EntityRepository $er){
                    return $er->createQueryBuilder('s')->orderBy('s.naam', 'ASC');
                    },
                    'property'=>'naam',
                    'multiple'=>true,
                    'expanded'=>true))
                    ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bplaetevoet\HomeBundle\Entity\Project',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'project';
    }
}
