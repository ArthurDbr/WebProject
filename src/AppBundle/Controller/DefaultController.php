<?php

namespace AppBundle\Controller;

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
            return $this->redirectToRoute('/admin/{_locale}/accueil');
        } else if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->redirectToRoute('/user/{_locale}/accueil');
        } else {
            return $this->render('default/index.html.twig', [
            ]);
        }
    }
    

    /**
    * @Route("/user/{_locale}/accueil", name="accueil")
    */

    public function accueil(Request $request){
        return $this->render('Accueil/Accueil.html.twig', ['ajoutEvent' => '']);

    }

    /**
     * @Route("/admin/{_locale}/accueil", name="accueilAdmin")
     */
    public function accueiladmin()
    {
       return $this->render('Accueil/AccueilAdmin.html.twig', ['ajoutEvent' => '']);
    }
}
