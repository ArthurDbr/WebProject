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
    * @Route("/template", name="ModifTemplate")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function changerTheme(Request $request){
        $profil = $this->getUser();
        $profil->setTemplate($_POST['template']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($profil);
        $em->flush();
        
        return $this->render('Profil/ShowProfil.html.twig', ['profil' => $profil,
                                                            'Modifprofil' => 'Template Modify']);
        
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

            if( isset($_POST['UserName'])){
                $userName = addcslashes($_POST['UserName'], '\'%_');
            }else{
                $userName= null;
            }
            if( isset($_POST['Nom'])){
                $nom = addcslashes($_POST['Nom'], '\'%_');
            }else{
                $nom = null;
            }
            if( isset($_POST['Prenom'])){
                $prenom = addcslashes($_POST['Prenom'], '\'%_"/');
            }else{
                $prenom= null;
            }
            if( isset($_POST['Mail'])){
                $email = $_POST['Mail'];
            }else{
                $email = null;
            }
            if( isset($_POST['Age'])){
                $age = (int)$_POST['Age'];
            }else{
                $age = null;
            }
            
            $profil->setUsername($userName);
            $profil->setNom($nom);
            $profil->setPrenom($prenom);
            $profil->setEmail($email);
            $profil->setAge($age);
            $em = $this->getDoctrine()->getManager();

            $em->persist($profil);

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