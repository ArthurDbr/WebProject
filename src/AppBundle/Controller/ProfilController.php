<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Users;
use AppBundle\Entity\Evenement;
use AppBundle\Form\EvenementType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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

        $typeEvent = [ 1 => "Party", 
                    2 => "Study", 
                    3 => "Theatre", 
                    4 => "Cinema",
                    5 => "Restaurant",
                    6 => "Sport"];

        $profil = $this->getUser();
        

        return $this->render('Profil/ShowProfil.html.twig', ['profil' => $profil,
                                                            'Modifprofil' => '']);
    }


        /**
    * @Route("/addParticipant/{id1}/{id2}", requirements={"id1":"\d+","id2":"\d+"}, name="addParticipant")
    * @ParamConverter("e",      options={"mapping": {"id1" : "id"}})
    * @ParamConverter("p",      options={"mapping": {"id2"   : "id"}})
    */
    public function addParticipant(Request $request, Evenement $e, Users $p){
        $em = $this->getDoctrine()->getManager();
        $repository1 = $this->getDoctrine()->getRepository(Evenement::class);
        $repository2 = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository2->findAll();

        $p->addListeEvenement($e);
        $em->persist($p);
        $em->flush();

        $notif = false;
        $profil = $this->getUser();
        $evenement = $profil->getListeEvenement();

        $p->removeDemande($e);
        $em->persist($p);
        $em->flush();

        foreach ($evenement as $event) {
            foreach ($users as $user) {
                $demandes = $user->getDemande();
                foreach ($demandes as $demande) {           
                    if($demande->getId() == $event->getId() ){
                        $notif = true;
                    }
                }
            }
        }
        if( !$notif ){
            $profil->setNotification(false);
            $em->persist($profil);
            $em->flush();
        }

        return $this->redirectToRoute('MyEvent');
    }


    /**
    * @Route("/refuseParticipant/{id1}/{id2}", requirements={"id1":"\d+","id2":"\d+"}, name="refuseParticipant")
    * @ParamConverter("e",      options={"mapping": {"id1" : "id"}})
    * @ParamConverter("p",      options={"mapping": {"id2"   : "id"}})
    */
    public function refuseParticipant(Request $request, Evenement $e, Users $p){
        $em = $this->getDoctrine()->getManager();

        $p->removeDemande($e);
        $em->persist($p);
        $em->flush();

        foreach ($evenement as $event) {
            foreach ($users as $user) {
                $demandes = $user->getDemande();
                foreach ($demandes as $demande) {           
                    if($demande->getId() == $event->getId() ){
                        $notif = true;
                    }
                }
            }
        }
        if( !$notif ){
            $profil->setNotification(false);
            $em->persist($profil);
            $em->flush();
        }

        return $this->redirectToRoute('MyEvent');
    }

    /**
    * @Route("/templateChange", name="ModifTemplate")
    * @return \Symfony\Component\httpFoundation\Response
    * @throws \LogicException
    */
    public function changerTheme(Request $request){
        $profil = $this->getUser();
        $profil->setTemplate($_POST['template']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($profil);
        $em->flush();
        
        return $this->redirectToRoute('MyProfil');
        
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