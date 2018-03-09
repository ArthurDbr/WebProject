<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Evenement;
use AppBundle\Form\EvenementType;

/**
* @Route("/{_locale}/Event")
*/
class EvenementController extends Controller{
	/**
    * @Route("/MyEvent", name="MyEvent")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function indexAction(Request $request){
        $repository = $this->getDoctrine()->getRepository(Evenement::class);
        $evenement = $repository->findAll();
        return $this->render('Evenement/MyEvenement.html.twig', ['evenement' => $evenement]);
    }

    /**
    * @Route("/show/{id}", requirements={"id":"\d+"}, name="showEvenement")
    */
    public function showEvent(Request $request, Evenement $event){

        return $this->render('Evenement/ShowEvenement.html.twig', ['event' => $event]);
    }

    /**
    * @Route("/modify/{id}", requirements={"id":"\d+"}, name="modifyEvenement")
    */
    public function modifyEvent(Request $request, Evenement $event){



        if( isset($_POST["Categorie"])){
            if ($_POST["modifier"] == "Annuler") {
                return $this->render('Evenement/ShowEvenement.html.twig', ['event' => $event]);
            }else{
                $em = $this->getDoctrine()->getManager();
                $evenement = new Evenement();
                $userId = $this->getUser()->getId();

                $lieu = addcslashes($_POST['Lieu'], '\'%_');
                $descri = addcslashes($_POST['Description'], '\'%_"/');
                $categ = (int)$_POST['Categorie'];
                $date = $_POST['date'];
                $heure = $_POST['heure'];

                $event->setLieu($lieu);
                $event->setDescription($descri);
                $event->setIdPersonne($userId);
                $event->setIdTypeEvenement($categ);
                $event->setDateEvenement($date);
                $event->setHeureEvenement($heure);
                $em = $this->getDoctrine()->getManager();

                // Étape 1 : On « persiste » l'entité
                $em->persist($event);

                // Étape 2 : On « flush » 
                $em->flush();

                return $this->render('Accueil/Accueil.html.twig', ['ajoutEvent' => 'Event modify !']);
            }
            
        }
        return $this->render('Evenement/ModifyEvenement.html.twig', ['event' => $event, 'erreur' => '']);
    }

    /**
    * @Route("/delete/{id}", requirements={"id":"\d+"}, name="deleteEvenement")
    */
    public function deleteEvent(Request $request, Evenement $event){
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('showEvent');
    }

    /**
    * @Route("/createEvent", name="createEvent")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function createEvent(Request $request){
        return $this->render('Evenement/CreerEvenement.html.twig', ['erreur' => '']);
    }

    /**
    * @Route("/ajoutEvent", name="ajoutEvent")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function ajoutEvent(Request $request ){
        $em = $this->getDoctrine()->getManager();
        $evenement = new Evenement();
        $userId = $this->getUser()->getId();

        if( $_POST['Categorie'] == '0' || !isset($_POST['Lieu']) || !isset($_POST['Description'])){
            return $this->render('Evenement/CreerEvenement.html.twig', ['erreur' => 'You need to provide all the fields']);   
        }else{
            $lieu = addcslashes($_POST['Lieu'], '\'%_');
            $descri = addcslashes($_POST['Description'], '\'%_"/');
            $categ = (int)$_POST['Categorie'];
            $date = $_POST['date'];
            $heure = $_POST['heure'];

            $evenement->setLieu($lieu);
            $evenement->setDescription($descri);
            $evenement->setIdPersonne($userId);
            $evenement->setIdTypeEvenement($categ);
            $evenement->setDateEvenement($date);
            $evenement->setHeureEvenement($heure);
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