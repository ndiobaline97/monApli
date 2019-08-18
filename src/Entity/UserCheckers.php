<?php 
namespace App\Entity;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface ;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\User\UserCheckerInterface ;

class UserCheckers implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
       if(!$user instanceof User || $user->getStatut()=="-")
       {
            return;
       }

       if($user->getStatut()=="Bloque")
       {
            throw new HttpException(403,'Ce compte a été bloqué, veuillez contacter l\'admin');
       }
     
       if($user->getPartenaire()->getStatut()=="Bloque")
       {
        throw new HttpException(403,'Votre admin a été bloqué, veuillez le contacter '); 
       }
    }

    public function checkPostAuth(UserInterface $user)
    {
       
    }

    // Créer la class UserChecker, allez dans service.yaml pour définir le service suivant:
    // app.user_checker :
    //      class : App\Entity\UserCheckers
    // Puis sur security.yaml, faire appel a ce service sur notre firewalls de connexion
    //      user_checker: app.user_checker 
}
