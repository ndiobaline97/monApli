<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Profile;
use App\Entity\Partenaire;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


    /**
     * @Route("/api", name="app_register")
     */
class UserController extends AbstractController
{
   /**
     * @Route("/image", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $data=$request->request->all();
        $form->submit($data);
        
        $file=$request->files->all()['imageName'];
        
            
                //var_dump($passwordEncoder);die();
            $user->setImageFile($file);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                ));
            $repos=$this->getDoctrine()->getRepository(Profile::class);
            $profils=$repos->find($data['profile']);
            $user->setProfile($profils);
            $recup=$this->getDoctrine()->getRepository(Partenaire::class);
            $partenaire=$recup->find($data['partenaire']);
            $user->setPartenaire($partenaire);
            

            $role=[];
            if($profils->getLibelle() == "admin"){
                $role=(["ROLE_ADMIN"]);
            }
            elseif($profils->getLibelle() == "user"){
                $role=(["ROLE_USER"]);
            }
            elseif($profils->getLibelle() == "caissier"){
                $role=(["ROLE_CAISSIER"]);
            }
            elseif( $profils->getLibelle() == "superadmin"){
                $role=(["ROLE_SUPER_ADMIN"]);
            }
            
            $user->setRoles($role);
            $user->setStatut("actif");
            $entityManager = $this->getDoctrine()->getManager();

            //$user->setImageName($file->getClientOriginalName());
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $info = [
                'status' => 201,
                'message' => 'ok'
            ];

            return new JsonResponse($info, 201);
       
    }
}
