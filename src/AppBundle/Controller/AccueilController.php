<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Users;
use AppBundle\Entity\ParticipantEvenement;
    
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
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
            $repository2 = $this->getDoctrine()->getRepository(Users::class);
            $evenement = $repository1->findAll();
            $profil = $repository2->findAll();
            return $this->render('Accueil/AccueilAdmin.html.twig', ['ajoutEvent' => '',
                'evenement' => $evenement,
                'profils'=> $profil ]);

        } else if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
            $repository2 = $this->getDoctrine()->getRepository(Users::class);
            $evenement = $repository1->findAll();
            $profil = $repository2->findAll();
            return $this->render('Accueil/Accueil.html.twig', ['ajoutEvent' => '',
                'evenement' => $evenement,
                'profils'=> $profil ]);

        } else {
            return $this->render('default/index.html.twig', [
            ]);
        }

    }


    /**
    * @Route("/createEvent", name="event")
    */
    public function CreerEvent(Request $request){
        return $this->render('Evenement/CreerEvenement.html.twig', ['erreur' => '']);
    }

    /**
    * @Route("/{id}", requirements={"id":"\d+"}, name="addParticipantEvent")
    */
    public function AddEvent(Request $request, Evenement $event){
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(ParticipantEvenement::class);
        $ajoute = false;
        $participant = $repository->findAll();
        foreach ($participant as $parti) {
            if($parti->getIdEvenement() == $event->getId()){
                $ajoute = true;
            }
        }

        if( $ajoute == false){
                    $participantEvenement = new ParticipantEvenement();

            $participantEvenement->setIdPersonne($this->getUser()->getId());
            $participantEvenement->setIdEvenement($event->getId());

            $em->persist($participantEvenement);

            $em->flush();


            return $this->render('Evenement/MyEvenement.html.twig', ['evenement' => $event, 
                                                                    'profils'=> $this->getUser()]);
        }else{
            $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
            $repository2 = $this->getDoctrine()->getRepository(Users::class);
            $evenement = $repository1->findAll();
            $profil = $repository2->findAll();
            return $this->render('Accueil/Accueil.html.twig', ['ajoutEvent' => 'event already add',
                                                            'evenement' => $evenement, 
                                                            'profils'=> $profil ]);
        }

    }

}
?>