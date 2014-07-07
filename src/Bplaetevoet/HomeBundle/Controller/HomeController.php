<?php
// src/Bplaetevoet/HomeBundle/Controller/HomeController.php
namespace Bplaetevoet\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bplaetevoet\HomeBundle\Entity\Project;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository("BplaetevoetHomeBundle:Project")->findAll();
        
        return $this->render('BplaetevoetHomeBundle:Home:index.html.twig', array('projects'=>$projects));
    }
    public function projectlistAction(){
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository("BplaetevoetHomeBundle:Project")->findAll();
        return $this->render('BplaetevoetHomeBundle:Home:projecten.html.twig', array('projects'=>$projects));
    }
    public function contactAction(Request $request){
        $data = array();
        $form = $this->createFormBuilder($data)
                ->add('naam', 'text')
                ->add('email', 'email')
                ->add('boodschap', 'textarea')
                ->add('verzenden', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()){
            $message = $naam.' liet volgend bericht na via het contactformulier : \\n';
            $mail = mail('MY_EMAIL', 'FORM_SUBJECT', $message.' from '.$E-mail );
            if($mail){
                return $this->render('BplaetevoetHomeBundle:Home:contact.html.twig', array('flashmessage'=> 'Bedankt voor uw feedback'));
            }
        }
        return $this->render('BplaetevoetHomeBundle:Home:contact.html.twig', array('form'=>$form->createView(),));
        
    }

}


