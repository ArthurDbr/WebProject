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
        $typeEvent = [ 1 => "Party", 
            2 => "Study", 
            3 => "Theatre", 
            4 => "Cinema",
            5 => "Restaurant",
            6 => "Sport"];
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
            $repository2 = $this->getDoctrine()->getRepository(Users::class);
            $evenement = $repository1->findAll();
            $profil = $repository2->findAll();
            return $this->render('Accueil/AccueilAdmin.html.twig', ['messageEvent' => '',
                'evenement' => $evenement,
                'profils'=> $profil ]);

        } else if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
            $repository2 = $this->getDoctrine()->getRepository(Users::class);
            $evenement = $repository1->findAll();
            $profil = $repository2->findAll();
            
            return $this->render('Accueil/Accueil.html.twig', ['messageEvent' => '',
                'typeEvent' => $typeEvent,
                'evenement' => $evenement,
                'profils'=> $profil,
                ]);

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
    * @Route("/about", name="About")
    */
    public function about(Request $request){
        $message = "Ce site web a été réalisé avec Symfony 3.4 et Bootstrap dans le cadre 
        d'un projet de developpement Web.";
        $auteur = "Auteurs : BOIRO Mamadou, DEBAR Arthur, VALENZA Pierre";
        return $this->render('About/About.html.twig', ['message' => $message, 'auteur' => $auteur]);
    }

    /**
     * @Route("/search", name="RechercherEvenement")
     */
    public function searchAction(Request $request)
    {

        $typeEvent = [ 1 => "Party", 
            2 => "Study", 
            3 => "Theatre", 
            4 => "Cinema",
            5 => "Restaurant",
            6 => "Sport"];
        $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
        $repository2 = $this->getDoctrine()->getRepository(Users::class);
        $profil = $repository2->findAll();

        $event = $repository1->findAll();;


        if( isset($_POST["search"])){
            $em = $this->getDoctrine()->getManager();
            $mot = addcslashes($_POST['description'], '\'%_"/');
            if($mot == ''){
                return $this->redirectToRoute("accueil_index");
            }else{
                
                switch ($mot) {
                    case 'Party':
                        $mot = 1;
                        break;
                    case 'Study':
                        $mot = 2;
                        break;
                    case 'Theatre':
                        $mot = 3;
                        break;
                    case 'Cinema':
                        $mot = 4;
                        break;
                    case 'Restaurant':
                        $mot = 5;
                        break;
                    case 'Sport':
                        $mot = 6;
                        break;
                    
                    default:
                        # code...
                        break;
                }
                $evenements = $em->getRepository('AppBundle:Evenement')
                            ->research($mot);

                if (!$evenements) {
                    return $this->render('Accueil/Accueil.html.twig', ['messageEvent' => 'OOPS, no event found',
                    'typeEvent' => $typeEvent,
                    'evenement' => $evenements,
                    'profils'=> $profil,
                    ]);
                }

                return $this->render('Accueil/Accueil.html.twig', ['messageEvent' => '',
                'typeEvent' => $typeEvent,
                'evenement' => $evenements,
                'profils'=> $profil,
                ]);
            }

        }
            
            return $this->redirectToRoute('accueil_index');
            
    }

    


}
?>