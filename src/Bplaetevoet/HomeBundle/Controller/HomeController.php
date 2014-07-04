<?php
// src/Bplaetevoet/HomeBundle/Controller/HomeController.php
namespace Bplaetevoet\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bplaetevoet\HomeBundle\Entity\Project;
use Bplaetevoet\HomeBundle\Entity\Skill;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository("BplaetevoetHomeBundle:Project")->findAll();
        
        return $this->render('BplaetevoetHomeBundle:Home:index.html.twig', array('projects'=>$projects));
    }
}


