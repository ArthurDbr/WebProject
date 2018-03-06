<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Evenement;

/**
* @Route("/{_locale}/createEvent")
*/
class EvenementController extends Controller{
	/**
    * @Route("/", name="evenement_index")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */

    public function indexAction(Request $request){
        $repository = $this->getDoctrine()->getRepository(Evenement::class);
        $evenement = $repository->findAll();
        return $this->render('Evenement/CreerEvenement.html.twig');
    }

    /**
    * @Route("/createEvent", name="createEvent")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function creerEvent(Request $request ){
        $em = $this->getDoctrine()->getManager();
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        var_dump($form);
        

    }



}
?>