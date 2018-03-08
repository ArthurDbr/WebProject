<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\evenement;
    
/**
* @Route("/user/{_locale}/accueil")
*/
class AccueilController extends Controller{
	/**
    * @Route("/", name="accueil_index")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */

    public function indexAction(Request $request){
    	return $this->render('Accueil/Accueil.html.twig', ['ajoutEvent' => '']);
    }

    /**
    * @Route("/createEvent", name="event")
    */

    public function CreerEvent(Request $request){
        return $this->render('Evenement/CreerEvenement.html.twig', ['erreur' => '']);
    }

}
?>