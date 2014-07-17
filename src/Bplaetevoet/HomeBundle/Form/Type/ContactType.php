<?php
namespace Bplaetevoet\HomeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder->add('naam', 'text')
            ->add('email', 'email')
            ->add('boodschap', 'textarea')
            ;
    }
    

    public function getName()
    {
        return 'contact';
    }
}
