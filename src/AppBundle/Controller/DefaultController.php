<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evenement;
use AppBundle\Entity\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('sonata_admin_redirect');
        } else if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->redirectToRoute('accueil');
        } else {
            return $this->render('default/index.html.twig', [
            ]);
        }
    }
    

    /**
    * @Route("/user/{_locale}/accueil", name="accueil")
    */

    public function accueil(Request $request){
            $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
            $repository2 = $this->getDoctrine()->getRepository(Users::class);
            $evenement = $repository1->findAll();
            $profil = $repository2->findAll();
        return $this->render('Accueil/Accueil.html.twig', ['ajoutEvent' => '',
                'evenement' => $evenement,
                'profils'=> $profil,
                ]);

    }

    /**
     * @Route("/admin/{_locale}/accueil", name="accueilAdmin")
     */
    public function accueiladmin()
    {
        $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
        $repository2 = $this->getDoctrine()->getRepository(Users::class);
        $evenement = $repository1->findAll();
        $profil = $repository2->findAll();
        return $this->render('Accueil/AccueilAdmin.html.twig', ['ajoutEvent' => '',
            'evenement' => $evenement,
            'profils'=> $profil ]);
    }

}
