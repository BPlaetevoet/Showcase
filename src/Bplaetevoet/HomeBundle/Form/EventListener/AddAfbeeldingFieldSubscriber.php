<?php
// src/Bplaetevoet/HomeBundle/Form/EventListener/AddAfbeeldingFieldSubscriber.php
namespace Bplaetevoet\HomeBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddAfbeeldingFieldSubscriber implements EventSubscriberInterface{
    public static function getSubscribedEvents() {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }
    
    public function preSetData(FormEvent $event){
        $project = $event->getData();
        $form = $event->getForm();
        
        if (!$project || null === $project->getAfbeelding()){
            $form->add('file', 'file', array('label'=>'Afbeelding:'));
        }
        if (null !== $project->getAfbeelding()){
            $form->add('file', 'file', array('label'=>'Afbeelding:', 'required'=>false));
        }
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

