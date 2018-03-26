<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Users;
use AppBundle\Form\EvenementType;
use AppBundle\Repository\evenementRepository;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Query\Expr;

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
        $message="";

        $typeEvent = [ 1 => "Party", 
                    2 => "Study", 
                    3 => "Theatre", 
                    4 => "Cinema",
                    5 => "Restaurant",
                    6 => "Sport"];

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("accueil_index"));
        $breadcrumbs->addItem("MyEvent");

        
        return $this->render('Evenement/MyEvenement.html.twig', ['evenement' => $evenement, 
                                                                'profils'=> $profils,
                                                                'messageEvent' => $message,
                                                                'typeEvent' => $typeEvent,
                                                                'user' => $user,
                                                                'participantEvenement'=> $participantEvenement,]);
    }

    /**
    * @Route("/{id}", requirements={"id":"\d+"}, name="addParticipantEvent")
    */
    public function addParticipantEvent(Request $request, Evenement $e){
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("accueil_index"));
        $breadcrumbs->addItem("addParticipantEvent");

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Evenement::class);
        $repository2 = $this->getDoctrine()->getRepository(Users::class);
        $evenement = $repository->findAll();
        $profils = $repository2->findAll();
        $profil = $this->getUser();
        $participantEvenement = new Users();
        $typeEvent = [ 1 => "Party", 
            2 => "Study", 
            3 => "Theatre", 
            4 => "Cinema",
            5 => "Restaurant",
            6 => "Sport"];


        $profil->addDemande($e);
        foreach ($profils as $profilEvent) {
            $evenment = $profilEvent->getListeEvenement();
            foreach ($evenment as $event) {
                if($event->getId() == $e->getId()){
                    $profilEvent->setNotification(true);
                    $em->persist($profilEvent);
                    $em->flush();
                }
            }

        }
        $em->persist($profil);
        $em->flush();
            
        $message = "Demande envoyé à l'utilisateur !";

        return $this->render('Evenement/MyEvenement.html.twig', ['evenement' => $evenement, 
                                                                'profils'=> $profils,
                                                                'messageEvent' => $message,
                                                                'typeEvent' => $typeEvent,
                                                                'user' => $profil,
                                                                'participantEvenement'=> $participantEvenement,]);
    }

    /**
     * @Route("/show", name="showAllEvenement")
     */
    public function showAllEvent(Request $request){
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("accueil_index"));
        $breadcrumbs->addItem("showAllEvenement");

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
    public function showEvent(Request $request, Evenement $e){
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("accueil_index"));
        $breadcrumbs->addItem("MyEvent", $this->get("router")->generate("MyEvent"));
        $breadcrumbs->addItem("showEvenement");

        $repository2 = $this->getDoctrine()->getRepository(Users::class);
        $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
        $users = $repository2->findAll();
        $participantEvenement = new ArrayCollection();
        foreach ($users as $user) {
            $events = $user->getListeEvenement();
            $ajoute = true;
            foreach ($events as $event) {
                if($event->getId() == $e->getId()){
                     $participantEvenement->add($user); 
                   
                }
            }
        }
        
        $typeEvent = [ 1 => "Party", 
            2 => "Study", 
            3 => "Theatre", 
            4 => "Cinema",
            5 => "Restaurant",
            6 => "Sport"];

        $profil = $this->getUser();
        $demandes = $profil->getDemande();
        

        //$evenement = $repository1->findAll();
        $users = $repository2->findAll();
        $profilDemande = new ArrayCollection();


        $evenement = $profil->getListeEvenement();
        foreach ($evenement as $event) {
            foreach ($users as $user) {
                $demandes = $user->getDemande();
                foreach ($demandes as $demande) {           
                    if($demande->getId() == $event->getId() ){
                        $profilDemande->add($user);
                    }
                }
            }
        }

        return $this->render('Evenement/ShowEvenement.html.twig', ['event' => $e,
                                                                'participantEvenement' => $participantEvenement,
                                                                'profilDemande' => $profilDemande,
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
    * @Route("/ajoutEvent", name="ajoutEvent")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function ajoutEvent(Request $request ){
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("accueil_index"));
        $breadcrumbs->addItem("addEvent");

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

        if(isset($_POST['ajouter'])){
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
        }else{
            return $this->render('Evenement/CreerEvenement.html.twig', ['erreur' => '',
                                                                        'types' => array( 'Select a categorie',
                                                                        'Party', 
                                                                        'Study', 
                                                                        'Théatre', 
                                                                        'Cinema', 
                                                                        'Restaurant', 
                                                                        'Sport'),
                                                                     'categorie' => 0,
            ]);
        }
    }
    


}
?>