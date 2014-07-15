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
    public function overAction(){
        return $this->render('BplaetevoetHomeBundle:Home:cv.html.twig');
    }
    public function projectlistAction(){
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository("BplaetevoetHomeBundle:Project")->findAll();
        return $this->render('BplaetevoetHomeBundle:Home:projecten.html.twig', array('projects'=>$projects));
    }
    public function contactAction(Request $request){
        $mymail = 'bart.plaetevoet@telenet.be';
        $subject = 'Contactaanvraag via bplaetevoet.be';
        $data = array();
        $form = $this->createFormBuilder($data)
                ->add('naam', 'text')
                ->add('email', 'email')
                ->add('boodschap', 'textarea')
                ->add('verzenden', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()){
            $data = $form->getData();
            $email = $data['email'];
            $message = $data['naam']." liet volgend bericht na via het contactformulier : \n".$data['boodschap'];
            if(mail($mymail, $subject, $message, "from: $email" )){
                return $this->render('BplaetevoetHomeBundle:Home:contact.html.twig', array('flashmessage'=> 'Bedankt voor uw feedback'));
            }
        }
        return $this->render('BplaetevoetHomeBundle:Home:contact.html.twig', array('form'=>$form->createView(),));
        
    }

}


