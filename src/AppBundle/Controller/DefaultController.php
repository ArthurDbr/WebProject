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
        return $this->render('default/index.html.twig', [   
        ]);
    }

    /**
    * @Route("/user/{_locale}/accueil", name="accueil")
    */

    public function accueil(Request $request){
        return $this->render('Accueil/Accueil.html.twig', ['ajoutEvent' => '']);
    }

    /**
     * @Route("/admin/{_locale}/accueil")
     */
    public function admin()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }
}
