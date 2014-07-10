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
    Doctrine\Common\Collections\ArrayCollection;
    Doctrine\Common\Util\Debug;
;

class AdminController extends Controller{
    public function indexAction(){
        return $this->render('BplaetevoetHomeBundle:Admin:index.html.twig');
    }
    public function addskillAction(Request $request){
        $skill = new Skill();
        
        $form = $this->createFormBuilder($skill)
                ->add('naam', 'text')
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
        
        return $this->render('BplaetevoetHomeBundle:Admin:adminskillsform.html.twig', array('form'=>$form->createview(),'skills'=> $skills));
    }
    public function editskillAction(Request $request, $skillnaam){
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository('BplaetevoetHomeBundle:Skill')->findOneByNaam($skillnaam);
        if($skill){
            
            $skill->setNaam($skill->getNaam());
                        
            $form = $this->createFormBuilder($skill)
                    ->add('naam', 'text')
                    ->add('Wijzig', 'submit')
                    ->getForm();
            
            $form->handleRequest($request);
            
            if ($form->isValid()){
                $em->persist($skill);
                $em->flush();
                
                return $this->redirect($this->generateUrl('bplaetevoet_admin_addskill'));
            }
            $skills = $em->getRepository('BplaetevoetHomeBundle:Skill')->findAll();
            
            return $this->render('BplaetevoetHomeBundle:Admin:adminskillsform.html.twig', 
                    array('form'=>$form->createView(), 'skills'=> $skills) );
        }
    }
    
    public function editprojectAction(Request $request, $projectnaam){
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('BplaetevoetHomeBundle:Project')->findOneByNaam($projectnaam);
        if(!$project){
            throw $this->createNotFoundException('Geen project gevonden met naam : '.$projectnaam);
        }
        $originalSkills = new ArrayCollection();
        foreach($project->getSkills() as $skill){
            $originalSkills->add($skill);
        }
        $form = $this->createFormBuilder($project)
            ->add('naam', 'text')
            ->add('url', 'text')
            ->add('omschrijving', 'textarea')
            ->add('afbeeldingen', 'collection', array(
                  'type'=>new AfbeeldingType(), 
                  'allow_add'=>true,
                ))
            ->add('skills', 'entity', array(
                  'label'=>'Selecteer de gebruikte skills',
                  'class'=>'BplaetevoetHomeBundle:Skill',
                  'choices'=> $em->getRepository('BplaetevoetHomeBundle:Skill')->findAll(),
                  'property'=>'naam',
                  'multiple'=>true,
                  'expanded'=>true))
            ->add('Opslaan', 'submit')
            ->getForm();
        
        $form->handleRequest($request);
        if($form->isValid()){
            $em->persist($project);
            $em->flush();
            $projecten = $em->getRepository('BplaetevoetHomeBundle:Project')->findAll();
            return $this->render('BplaetevoetHomeBundle:Admin:adminprojects.html.twig', array('form'=> $form->createView(),'projecten'=>$projecten));
        }
        $projecten = $em->getRepository('BplaetevoetHomeBundle:Project')->findAll();
        return $this->render('BplaetevoetHomeBundle:Admin:adminprojects.html.twig', array('form'=>$form->createView(),'projecten'=>$projecten));
    
    }
    public function addafbeeldingAction(Request $request){
        $afbeelding = new Afbeelding();
        $form = $this->createFormBuilder($afbeelding)
                ->add('file')
                ->add('project', 'entity', array('label'=> 'Kies project',
                    'class'=>'BplaetevoetHomeBundle:Project',
                    'query_builder'=>function(\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                            ->orderBy('p.naam', 'ASC');
                    },
                            'property'=>'naam'))
                ->add('Uploaden', 'submit')
                ->getForm();
        $form->handleRequest($request);
        
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($afbeelding);
            $em->flush();
            
            return $this->render('BplaetevoetHomeBundle:Admin:adminafbeeldingsform.html.twig', array('afbeelding'=>$afbeelding, 'form'=>$form->createView(),));
        }
        
        return $this->render('BplaetevoetHomeBundle:Admin:adminafbeeldingsform.html.twig', array('form'=>$form->createView(),));
        
    }
    public function addprojectAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $projecten = $em->getRepository('BplaetevoetHomeBundle:Project')->findAll();
        $project = new Project();
        $afbeelding = new Afbeelding();
        $form = $this->createForm(new ProjectType(), $project);
        $form->add('Toevoegen', 'submit');
        
        $form->handleRequest($request);
        
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
            return $this->redirect($this->generateUrl('bplaetevoet_admin_addproject'));
        }
        $projecten = $em->getRepository('BplaetevoetHomeBundle:Project')->findAll();
        return $this->render('BplaetevoetHomeBundle:Admin:adminprojects.html.twig', array('form'=>$form->createView(), 'projecten'=>$projecten));

    }
    
    
}