<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Users;
use AppBundle\Form\EvenementType;


/**
* @Route("/user/{_locale}/Event")
*/
class EvenementController extends Controller{
	/**
    * @Route("/", name="MyEvent")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function indexAction(Request $request){
        $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
        $repository2 = $this->getDoctrine()->getRepository(Users::class);
        $evenement = $repository1->findAll();
        $profils = $repository2->findAll();
        $user = $this->getUser();
        $participantEvenement = $user->getListeEvenement();

        $typeEvent = [ 1 => "Party", 
                    2 => "Study", 
                    3 => "Theatre", 
                    4 => "Cinema",
                    5 => "Restaurant",
                    6 => "Sport"];

        
        return $this->render('Evenement/MyEvenement.html.twig', ['evenement' => $evenement, 
                                                                'profils'=> $profils,
                                                                'typeEvent' => $typeEvent,
                                                                'user' => $user,
                                                                'participantEvenement'=> $participantEvenement,]);
    }

    /**
    * @Route("/{id}", requirements={"id":"\d+"}, name="addParticipantEvent")
    */
    public function addParticipantEvent(Request $request, Evenement $e){
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Evenement::class);
        $evenement = $repository->findAll();
        $profil = $this->getUser();
        $participantEvenement = new Users();
            
        $profil->addListeEvenement($e);
        $em->persist($profil);
        $em->flush();
        return $this->redirectToRoute('MyEvent');
    }

    /**
     * @Route("/show", name="showAllEvenement")
     */
    public function showAllEvent(Request $request){
        $typeEvent = [ 1 => "Party", 
            2 => "Study", 
            3 => "Theatre", 
            4 => "Cinema",
            5 => "Restaurant",
            6 => "Sport"];
        $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
        $evenement = $repository1->findAll();
        return $this->render('Evenement/ShowAllEventAdmin.html.twig', ['evenement' => $evenement,
                                                                        'typeEvent' => $typeEvent]);
    }

    /**
    * @Route("/show/{id}", requirements={"id":"\d+"}, name="showEvenement")
    */
    public function showEvent(Request $request, Evenement $event){
        $typeEvent = [ 1 => "Party", 
            2 => "Study", 
            3 => "Theatre", 
            4 => "Cinema",
            5 => "Restaurant",
            6 => "Sport"];

            return $this->render('Evenement/ShowEvenement.html.twig', ['event' => $event,
                                                                        'typeEvent' => $typeEvent]);
    }

    /**
    * @Route("/unsubscribe/{id}",  requirements={"id":"\d+"}, name="unsubscribe")
    */
    public function unsubscribe(Request $request, Evenement $event){

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->removeListeEvenement($event);
        $em->persist($user);
        $em->flush();
/*        $event->removeListeUser($user);
        $em->persist($user);
        $em->flush();*/

        $typeEvent = [ 1 => "Party", 
            2 => "Study", 
            3 => "Theatre", 
            4 => "Cinema",
            5 => "Restaurant",
            6 => "Sport"];

        return $this->redirectToRoute('MyEvent');
    }

    /**
    * @Route("/modify/{id}", requirements={"id":"\d+"}, name="modifyEvenement")
    */
    public function modifyEvent(Request $request, Evenement $event){
        $typeEvent = [ 1 => "Party",
            2 => "Study", 
            3 => "Theatre", 
            4 => "Cinema",
            5 => "Restaurant",
            6 => "Sport"];
        $userId = $this->getUser()->getId();

        if( isset($_POST["Categorie"])){
                $em = $this->getDoctrine()->getManager();
                

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

                return $this->redirectToRoute('MyEvent');

            
        }

        return $this->render('Evenement/ModifyEvenement.html.twig', ['event' => $event, 'erreur' => '', 'typeEvent' => $typeEvent]);     }

    /**
     * @Route("/delete/{id}", requirements={"id":"\d+"}, name="deleteEvenement")
     */
    public function deleteEvent(Request $request, Evenement $event){
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('MyEvent');
    }


    /**
    * @Route("/delete/{id}", requirements={"id":"\d+"}, name="deleteAllEvenement")
    */
    public function deleteAllEvent(Request $request, Evenement $event){
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('MyEvent');
    }

    /**
    * @Route("/createEvent", name="createEvent")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function createEvent(Request $request){

        return $this->render('Evenement/CreerEvenement.html.twig', ['erreur' => '',
                                                                    'types' => array( 'Select a categorie','Party', 'Study', 'Théatre', 'Cinema', 'Restaurant', 'Sport'),
                                                                     'categorie' => 0,
        ]);
    }

    /**
    * @Route("/ajoutEvent", name="ajoutEvent")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function ajoutEvent(Request $request ){

        $typeEvent = [  1 => "Party", 
                        2 => "Study", 
                        3 => "Theatre", 
                        4 => "Cinema",
                        5 => "Restaurant",
                        6 => "Sport"];
        $em = $this->getDoctrine()->getManager();
        $evenement = new Evenement();
        $userId = $this->getUser()->getId();
        $profil = $this->getUser();

        if( ($_POST['Categorie'] == '0') || empty($_POST['Lieu']) || empty($_POST['Description'])|| empty($_POST['date']) || empty($_POST['heure'])){
            return $this->render('Evenement/CreerEvenement.html.twig', ['erreur' => 'You need to provide all the fields',
                                                                        'categorie' => $_POST['Categorie'],
                                                                        'description' => $_POST['Description'],
                                                                        'lieu' => $_POST['Lieu'],
                                                                        'date' => $_POST['date'],
                                                                        'heure' => $_POST['heure'],
                                                                        'types' => $typeEvent,

            ]);
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

            $em->persist($evenement);

            $em->flush();

            $profil->addListeEvenement($evenement);
            $em->persist($profil);
            $em->flush();



            return $this->redirectToRoute('MyEvent');
        }
    }



}
?>