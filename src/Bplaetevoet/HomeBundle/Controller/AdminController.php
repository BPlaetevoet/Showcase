<?php
// src/Bplaetevoet/HomeBundle/Controller/AdminController.php
namespace Bplaetevoet\HomeBundle\Controller;

use 
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Bplaetevoet\HomeBundle\Entity\Project,
    Bplaetevoet\HomeBundle\Entity\Skill,
    Bplaetevoet\HomeBundle\Entity\Afbeelding,
    Bplaetevoet\HomeBundle\Form\Type\ProjectType,
    Bplaetevoet\HomeBundle\Form\Type\AfbeeldingType,
    Bplaetevoet\HomeBundle\Form\RegisterProjectType,
    Symfony\Component\HttpFoundation\Request,
    Doctrine\Common\Util\Debug;
;

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
    public function addafbeeldingAction(Request $request){
        $afbeelding = new Afbeelding();
        $form = $this->createFormBuilder($afbeelding)
                ->add('naam')
                ->add('file')
                ->add('Uploaden', 'submit')
                ->getForm();
        $form->handleRequest($request);
        
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($afbeelding);
            $em->flush();
            
            return $this->render('BplaetevoetHomeBundle:Home:adminafbeeldingsform.html.twig', array('afbeelding'=>$afbeelding, 'form'=>$form->createView(),));
        }
        
        return $this->render('BplaetevoetHomeBundle:Home:adminafbeeldingsform.html.twig', array('form'=>$form->createView(),));
        
    }
    public function addfullprojecttestAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $project = new Project();
        $afbeelding = new Afbeelding();
        $builder = $this->createFormBuilder($project);
        $builder->add('naam');
        $builder->add('omschrijving', 'textarea');
        $builder->add('url', 'url');
//        $builder->add('afbeeldingen', new AfbeeldingType());
        $builder->add('afbeeldingen', 'collection', array(
            'type' => new AfbeeldingType(),
            'allow_add'=>true,
            'allow_delete'=>true,
            'prototype'=>true,
            
            ));
        $builder->add('Toevoegen', 'submit');
        $form = $builder->getForm();
        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            print '<pre>';
            Debug::dump($project);
            print '</pre>';
//            $em->flush();
//            return $this->redirect($this->generateUrl('bplaetevoet_home_projectlist'));
        }
        $projecten = $em->getRepository('BplaetevoetHomeBundle:Project')->findAll();
        return $this->render('BplaetevoetHomeBundle:Home:adminprojects.html.twig', array('form'=>$form->createView(), 'projecten'=>$projecten));

    }
    public function addfullprojecttestAction3(Request $request){
        $project = new Project();
        $form = $this->createForm(new RegisterProjectType());
        $form->add('toevoegen', 'submit');
        $form->handleRequest($request);
        
        if ($form->isValid){
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            print '<pre>';
            Debug::dump($project);
            print '</pre>';
        }
        $projecten = $em->getRepository('BplaetevoetHomeBundle:Project')->findAll();
        return $this->render('BplaetevoetHomeBundle:Home:adminprojects.html.twig', array('form'=>$form->createView(), 'projecten'=>$projecten));

    }
    
}