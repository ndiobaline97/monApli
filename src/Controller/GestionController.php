<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Tarif;
use App\Entity\Compte;
use App\Form\UserType;
use App\Entity\Profile;
use App\Form\DepotType;
use App\Form\CompteType;
use App\Form\RetraitType;
use App\Entity\Partenaire;
use App\Entity\Transaction;
use App\Form\PartenaireType;
use App\Form\TransactionType;
use App\Repository\UserRepository;
use App\Repository\CompteRepository;
use App\Repository\ProfileRepository;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;
use Proxies\__CG__\App\Entity\Compte as ProxiesCompte;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
     * @Route("/api", name="gestion_projet")
     */
class GestionController extends AbstractController
{
    /** 
     * @Route("/ajout", name="admin_utilisateur_compte", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $data = $request->request->all();
        $form->submit($data);
        $partenaire->setStatut("actif");
        $entityManager->persist($partenaire);
        $entityManager->flush();
        //recuperation de l'id du partenaire//
        $repository = $this->getDoctrine()->getRepository(Partenaire::class);
        $part = $repository->find($partenaire->getId());

        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
        $data = $request->request->all();
        $form->submit($data);
        $compte->setSolde(1);
        $num = rand(1111111111,9999999999);
        $number=$num."";
        $compte->setNumCompte($number);
        $compte->setPartenaire($part);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($compte);
        $entityManager->flush();
        $repository = $this->getDoctrine()->getRepository(Compte::class);
        $idcompte = $repository->find($compte->getId());
       
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $form->submit($data);
        $user->setRoles(["ROLE_ADMIN_PARTENAIRE"]);
        $user->setPartenaire($part);
        $user->setStatut("actif");
        $user->setCompte($idcompte);
        $user->setPassword($encoder->encodePassword($user,
                             $form->get('plainPassword')->getData()
                            ));
        $file=$request->files->all()['imageName'];

        $user->setImageFile($file);                    
        //$user->setPassword($hash);
        $entityManager = $this->getDoctrine()->getManager();
       // $entityManager->persist($compte);
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response('Ajout dun partenaire de son user   et dun compte pour ce dernier', Response::HTTP_CREATED);
    }

    /** 
     * @Route("/newuser", name="nouveau_user", methods={"POST"})
     */
    public function addUser(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder){
        

         $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $data = $request->request->all();
        $form->handleRequest($request);
        $form->submit($data);
        //$user->setRoles(["ROLE_ADMIN_PARTENAIRE"]);
        $repository = $this->getDoctrine()->getRepository(Profile::class);
        $a = $repository->findById($user->getProfile());
        foreach ($a as $id) {
        $num=$id->getId();
 
     }

     if ( $num==1) {
     
         $user->setRoles(["ROLE_SUPER_ADMIN"]);
     } else if ($num == 2) {
         $user->setRoles(["ROLE_ADMIN_PARTENAIRE"]);
     }
     else if($num == 3){
        $user->setRoles(["ROLE_USER"]);
    }
     else if($num == 4){
        $user->setRoles(["ROLE_CAISSIER"]);
     }
     $idpartenaire = $this->getUser()->getPartenaire();
     $user->setPartenaire($idpartenaire);
        //$user->setPartenaire($part);
        $user->setStatut("actif");
        //$user->setCompte($idcompte);
        $user->setPassword($encoder->encodePassword($user,
                             $form->get('plainPassword')->getData()
                            ));
        $file=$request->files->all()['imageName'];

        $user->setImageFile($file);                    
        //$user->setPassword($hash);
        $entityManager = $this->getDoctrine()->getManager();
       // $entityManager->persist($compte);
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response('Ajout Utilisateur effectué', Response::HTTP_CREATED);
    }

    /** 
     * @Route("/newcompte", name="admin", methods={"POST"})
     */
    public function newCompte(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $money = new Compte();
        $form = $this->createForm(CompteType::class, $money);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        $entityManager->persist($money);
        $entityManager->flush();

        return new Response('Compte ajouté', Response::HTTP_CREATED);
    }

    /** 
     * @Route("/newprofile", name="profile", methods={"POST"})
     */
    public function newProfile(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $profile = new Profile();
        $form = $this->createForm(UserType::class, $profile);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        $entityManager->persist($profile);
        $entityManager->flush();

        return new Response('Profile ajoute', Response::HTTP_CREATED);
    }
    /**
     *@Route("/liste/profile",name="listeprofil", methods ={"GET"})
     */

    public function listerprofile(ProfileRepository $profileRepository, SerializerInterface $serializer)
    {
        $profile = $profileRepository->findAll();
        $data = $serializer->serialize($profile, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
  


   /**
     * @Route("/depot", name="depot_new", methods={"GET","POST"})
     */
    public function depot(Request $request,EntityManagerInterface $entityManager ): Response
    {
        $depot = new Depot();
        $form = $this->createForm(DepotType::class,$depot);
        $data=$request->request->all();
        $user=$this->getUser();
        $depot->setCaissier($user);
        $depot->setDateDepot(new \Datetime());
        $depot->getMontant();
        $form->submit($data);
        if($form->isSubmitted()){  
             $depot->getMontant();
             var_dump($depot->getMontant()); 
            if ($depot->getMontant()>=75000){
                $compte= $depot->getCompte();
                $compte->setSolde($compte->getSolde()+$depot->getMontant());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($compte);
                $entityManager->persist($depot);
                $entityManager->flush();
            return new Response('Le dépôt a été effectue',Response::HTTP_CREATED);
            }
            return new Response('Le montant du depot doit etre superieur ou egal a 75 000',Response::HTTP_CREATED);
        }
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner le montant et le compte où doit être effectuer le dépot '
        ];
            return new Response($data, 500);

    }
    /**
     * @Route("/liste" , name="listeuser" , methods={"GET"})
     */

     publiC function lister(UserRepository $userRepository, SerializerInterface $serializer)
     {
        $user = $userRepository->findAll();
        
        $data = $serializer->serialize($user,'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
     }

    /**
     * @Route("/envoie", name="envoie", methods={"POST"}) 
     */
    public function envoie (TransactionRepository $transaction,Request $request,EntityManagerInterface $entityManager)
    {
        // AJOUT OPERATION
        $transaction= new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        //$form->handleRequest($request);
        $values=$request->request->all();
        $form->submit($values);
        $valeur=0;

       if ($form->isSubmitted()) {
        $transaction->setDateEnvoie(new \DateTime());
        //generation du code d'envoie
        $e="SN";
        $c=rand(10000000,99999999);
        $code=$e.$c;
        $transaction->setCodeEnvoie($code);
        //generation du numero de la transaction
        $m=rand(10000000,99999999);
        $transaction->setNumTransaction($m);
        
        // recuperer l'id du guichetier qui effectue l'envoie
        $user=$this->getUser();
        $transaction->setUser($user);

        // recuperer la valeur du frais
        $repository=$this->getDoctrine()->getRepository(Tarif::class);
        $commission=$repository->findAll();

        //recuperer le montant saisi
        $montant=$transaction->getMontant();

        //Verifier si le montant à envoyer est disponible
        $user=$this->getUser();
        $comptes=$user->getCompte();
            if($values['montant']>= $comptes->getSolde()){
                return $this->json([
                    'messagù.10e
                    18' => 'votre solde( '.$comptes->getSolde().' ) ne vous permez pas d\'effectuer cet envoie'
                ]);
               }
               else{
                     // trouver les frais qui correspondent au montant à envoyer
            foreach ($commission as $value ) {
               
        if($montant >= $value->getBorneInf() &&  $montant <= $value->getBorneSup()){
            $valeur=$value->getValeur();
            break;
                 
        }
        } 
           $transaction->setfraisEnvoie($value->getValeur());

           // repartition des commissions 
           $wari=($valeur*40)/100;
           $part=($valeur*20)/100;
           $etat=($valeur*30)/100;
           $retrait=($valeur*10)/100;
           // var_dump($comptes->getSolde()); die();
           // dimunition du monatnt envoyé au niveau du solde et ajout de la commission pour le partenaire
           $comptes->setSolde($comptes->getSolde()-$transaction->getMontant()+ $part);


           $transaction->setCommissionSysteme($wari);
           $transaction->setCommissionUser($part);
           $transaction->setCommissionEtat($etat);
           $transaction->setCommissionRetrait($retrait);

           $total= $transaction->getfraisEnvoie()+ $transaction->getMontant();
           $transaction->setTotal($total);
           $transaction->setetatCode('envoye');
           
           $entityManager->persist($transaction);
           $entityManager->flush();
           
            $data = [
               'status1' => 201,
               'message1' => 'L\'envoie  a été effectué'
           ];
           return new JsonResponse($data, 201);
        }
        $data = [
            'status1' => 500,
            'message1' => 'ERREUR, VERIFIER LES DONNÉES SAISIES'
        ];
        return new JsonResponse($data, 500);
       }
    }

    /**
     * @Route("/retrait", name="retrait" ) 
     */
    public function retrait (Request $request,TransactionRepository $trans, EntityManagerInterface $entityManager)
    {
       $transaction= new Transaction();
        $form = $this->createForm(RetraitType::class, $transaction);
        $values =$request->request->all();
        $form->handleRequest($request);
        $form->submit($values);
        $codeEnvoie=$transaction->getCodeEnvoie();
        $code=$trans->findOneBy(['codeEnvoie'=>$codeEnvoie]);
        

            if(!$code ){
                return new Response('Ce code est invalide ',Response::HTTP_CREATED);
            }
                $statut=$code->getetatCode();

                if($code->getCodeEnvoie()==$codeEnvoie && $statut=="retire" ){
                    return new Response('Le code est déja retiré',Response::HTTP_CREATED);
                }
                    $user=$this->getUser();
                    var_dump($user);die();
                    $code->setUseretrait($user);
                    //$beneficiaire->setNumPiece($values)
                    $code->setetatCode("retire");
                    $code->setDateRetrait(new \DateTime());
                    $code->setNumPieceB($values['numPieceB']);
                    $code->setTypePieceB($values['typePieceB']);

                    $retrait=$code->getCommissionRetrait();
                    $Solde=$this->getUser()->getCompte();
                    //dump($codeEnvoie);die();
                    $Solde->setSolde($Solde->getSolde()+$retrait);
                    $entityManager->persist($code);
                    $entityManager->flush();
                return new Response('Retrait efféctué avec succés',Response::HTTP_CREATED);   
     }
}