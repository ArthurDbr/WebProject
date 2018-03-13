<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Users;
use AppBundle\Form\EvenementType;

/**
* @Route("/user/{_locale}/Profil")
*/
class ProfilController extends Controller{
	/**
    * @Route("/", name="MyProfil")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function indexAction(Request $request){
        $profil = $this->getUser();

        return $this->render('Profil/ShowProfil.html.twig', ['profil' => $profil,
                                                            'Modifprofil' => '']);
    }

    /**
    * @Route("/", name="modifTemplate")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function changerTheme(Request $request){
        $template = 'United';
        
        return $this->render('Profil/ShowProfil.html.twig', ['profil' => $profil,
                                                            'Modifprofil' => '']);
        
    }

    /**
    * @Route("/ModifiProfil", name="ModifProfil")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function ModifProfil(Request $request){
        $profil = $this->getUser();

        if( isset($_POST['modifer'])){
            $em = $this->getDoctrine()->getManager();

            $userName = addcslashes($_POST['UserName'], '\'%_');
            $nom = addcslashes($_POST['Nom'], '\'%_');
            $prenom = addcslashes($_POST['Prenom'], '\'%_"/');
            $email = $_POST['Mail'];
            $age = $_POST['Age'];


            $profil->setUsername($userName);
            $profil->setNom($nom);
            $profil->setPrenom($prenom);
            $profil->setEmail($email);
            $profil->setAge($age);
            $em = $this->getDoctrine()->getManager();

            // Étape 1 : On « persiste » l'entité
            $em->persist($profil);

            // Étape 2 : On « flush » 
            $em->flush();

            return $this->render('Profil/ShowProfil.html.twig', ['profil' => $profil,
                                                            'Modifprofil' => 'Profil Modify !']);
        }
        return $this->render('Profil/ModifProfil.html.twig', ['profil' => $profil]);
    }

    /**
     * @Route("/delete/{id}", requirements={"id":"\d+"}, name="deleteUser")
     */
    public function deleteProfil(Request $request, Users $user){
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('accueil_index');
    }





}
?>