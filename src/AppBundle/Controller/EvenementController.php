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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Users;
use AppBundle\Form\EvenementType;
use AppBunde\Form\SearchType;
use AppBundle\Entity\ParticipantEvenement;

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
        $repository2 = $this->getDoctrine()->getRepository(ParticipantEvenement::class);
        $evenement = $repository1->findAll();
        $ParticipantEvenement = $repository2->findAll();
        return $this->render('Evenement/MyEvenement.html.twig', ['evenement' => $evenement,
                                                                'participantEvenement'=> $ParticipantEvenement,]);
    }

    /**
     * @Route("/show", name="showAllEvenement")
     */
    public function showAllEvent(Request $request){
        $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
        $evenement = $repository1->findAll();
        return $this->render('Evenement/ShowAllEventAdmin.html.twig', ['evenement' => $evenement]);
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
        $em = $this->getDoctrine()->getManager();
        $evenement = new Evenement();
        $userId = $this->getUser()->getId();

        if( ($_POST['Categorie'] == '0') || empty($_POST['Lieu']) || empty($_POST['Description'])|| empty($_POST['date']) || empty($_POST['heure'])){
            return $this->render('Evenement/CreerEvenement.html.twig', ['erreur' => 'You need to provide all the fields',
                                                                        'categorie' => $_POST['Categorie'],
                                                                        'description' => $_POST['Description'],
                                                                        'lieu' => $_POST['Lieu'],
                                                                        'date' => $_POST['date'],
                                                                        'heure' => $_POST['heure'],
                                                                        'types' => array( 'Select a categorie','Party', 'Study', 'Théatre', 'Cinema', 'Restaurant', 'Sport'),

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

            return $this->redirectToRoute('MyEvent');
        }
    }

    /**
     * @Route("/search", name="RechercherEvenement")
     */
    public function searchAction(Request $request)
    {
        $event = new Evenement();
        $form = $this->createFormBuilder($event)
            ->add('description', TextType::class)
            ->getForm();

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findBy(
                ['description' => '$event->getDescription()']
              );

              if (!$evenements) {
                throw $this->createNotFoundException(
                  'No event found for this description'
                );
              }
              return $this->render('Evenement/ShowAllEventAdmin.html.twig', ['evenement' => $evenements]);

            }
            return $this->render('base.html.twig', array(
              'form' => $form->createView()));
    }


}
?>
