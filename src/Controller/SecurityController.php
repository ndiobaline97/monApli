<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class SecurityController extends AbstractController
{

    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
            $user = new User();
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setRoles(['ROLE_SUPPER_ADMIN']);
            $entityManager->persist($user);
            $entityManager->flush();

            $info = [
                'status' => 201,
                'message' => 'L\'utilisateur a été créé'
            ];

            return new JsonResponse($info, 201);
        }
        $info = [
            'status' => 500,
            'message' => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($info, 500);
    }

     /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getPassword(),
            'password' => $user->getRoles()

        ]);
    }

      /**
     * @Route("/showcompte", name="depot_new", methods={"GET"})
     */
    public function showCompte(Request $request,EntityManagerInterface $entityManager, SerializerInterface $serializer){
        $values = json_decode($request->getContent());
        $compte = new Compte();
        $compte->setNumCompte($values->numCompte);
        $repository = $this->getDoctrine()->getRepository(Compte::class);
        $compte = $repository->findBynumCompte($values->numCompte);
        $data = $serializer->serialize($compte, 'json',[
            'groups'=>['show']]
        );

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
