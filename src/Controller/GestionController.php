<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Profile;
use App\Form\UserType;
use App\Form\DepotType;
use App\Form\CompteType;
use App\Entity\Partenaire;
use App\Form\PartenaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



/**
     * @Route("/api", name="gestion_projet")
     */
class GestionController extends AbstractController
{
    /** 
     * @Route("/newadmin", name="admin_utilisateur_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $data = $request->request->all();
        $form->submit($data);
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
        $num = rand(100, 999);
        $number=$num."";
        $compte->setNumCompte($number);
        $compte->setPartenaire($part);
        $entityManager = $this->getDoctrine()->getManager();
    
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $form->submit($data);
        $user->setRoles(["ROLE_ADMIN_PARTENAIRE"]);
        $user->setPartenaire($part);
        $user->setStatut("actif");
        $user->setPassword($encoder->encodePassword($user,
                             $form->get('plainPassword')->getData()
                            ));
        $file=$request->files->all()['imageName'];

        $user->setImageFile($file);                    
        //$user->setPassword($hash);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($compte);
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response('Admin Partenaire ajoute', Response::HTTP_CREATED);
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
     * @Route("/newprofile", name="admin", methods={"POST"})
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
}