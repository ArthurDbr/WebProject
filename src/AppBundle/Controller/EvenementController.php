<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Evenement;
use AppBundle\Form\EvenementType;

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
/*        $em = $this->getDoctrine()->getManager();*/
        $evenement = new Evenement();

        $lieu = addcslashes($_POST['Lieu'], '\'%_');
        $descri = addcslashes($_POST['Description'], '\'%_"/');
        $categ = (int)$_POST['Categorie'];

        if( $_POST['Categorie'] == '0'){
            return $this->render('Evenement/CreerEvenement.html.twig', ['erreur' => 'You need to add an event']);   
        }else{

            $evenement->setLieu($lieu);
            $evenement->setDescription($descri);
            $evenement->setIdPersonne(1);
            $evenement->setIdTypeEvenement($categ);
            $em = $this->getDoctrine()->getManager();

            // Étape 1 : On « persiste » l'entité
            $em->persist($evenement);

            // Étape 2 : On « flush » 
            $em->flush();

            /*$form = $this->createForm(EvenementType::class, $evenement);
            $form->handleRequest($request);*/

            return $this->render('Accueil/Accueil.html.twig', ['ajoutEvent' => 'Event created !']);
        }
    }



}
?>