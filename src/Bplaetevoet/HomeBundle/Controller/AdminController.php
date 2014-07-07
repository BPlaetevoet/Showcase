<?php
// src/Bplaetevoet/HomeBundle/Controller/AdminController.php
namespace Bplaetevoet\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bplaetevoet\HomeBundle\Entity\Project;
use Bplaetevoet\HomeBundle\Entity\Skill;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller{
    public function addskillAction(Request $request){
        $skill = new Skill();
        
        $form = $this->createFormBuilder($skill)
                ->add('naam', 'text')
                ->add('omschrijving', 'textarea')
                ->add('url', 'url')
                ->add('Toevoegen', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($skill);
            $em->flush();
            
            return $this->redirect($this->generateUrl('bplaetevoet_admin_addskill'));
        }
        $em = $this->getDoctrine()->getManager();
        $skills = $em->getRepository('BplaetevoetHomeBundle:Skill')->findAll();
        
        return $this->render('BplaetevoetHomeBundle:Home:adminskillsform.html.twig', array('form'=>$form->createview(),'skills'=> $skills));
    }
    public function editskillAction(Request $request, $skillnaam){
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository('BplaetevoetHomeBundle:Skill')->findOneByNaam($skillnaam);
        if($skill){
            
            $skill->setNaam($skill->getNaam());
            $skill->getUrl();
            $skill->getOmschrijving();
            
            $form = $this->createFormBuilder($skill)
                    ->add('naam', 'text')
                    ->add('omschrijving', 'textarea')
                    ->add('url', 'url')
                    ->add('Wijzig', 'submit')
                    ->getForm();
            
            $form->handleRequest($request);
            
            if ($form->isValid()){
                $em->persist($skill);
                $em->flush();
                
                return $this->redirect($this->generateUrl('bplaetevoet_admin_addskill'));
            }
            $skills = $em->getRepository('BplaetevoetHomeBundle:Skill')->findAll();
            
            return $this->render('BplaetevoetHomeBundle:Home:adminskillsform.html.twig', 
                    array('form'=>$form->createView(), 'skills'=> $skills) );
        }
    }
    public function addprojectAction(Request $request){
        $project = new Project();
        
        
        $form = $this->createFormBuilder($project)
                ->add('naam', 'text')
                ->add('url', 'text')
                ->add('omschrijving', 'textarea')
                ->add('file', 'file')
                ->add('Toevoegen', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()){
            
            return $this->redirect($this->generateUrl('task_succes'));
        }
        $em = $this->getDoctrine()->getManager();
        $projecten = $em->getRepository('BplaetevoetHomeBundle:Project')->findAll();
        return $this->render('BplaetevoetHomeBundle:Home:adminprojects.html.twig', 
                array('form'=>$form->createView(), 'projecten'=> $projecten));
                
    }
}