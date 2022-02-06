<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\LoginType;
use App\Entity\Preference;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    protected $encoder;

    public function __construct(UserPasswordHasherInterface $encoder){
        $this->encoder = $encoder;
    }

    #[Route('/login', name:'security_login')]
    public function login(AuthenticationUtils $authenticationUtils){
        $error = $authenticationUtils->getLastAuthenticationError();
        if($error){
            $this->addFlash('error', 'Les informations remplit ne sont pas valide.');
        }
        $form = $this->createForm(LoginType::class);
        $formView = $form->createView();

        return $this->render('security/login.html.twig', [
            'formView' => $formView
        ]);
    }

    #[Route('/inscription', name:'security_inscription')]
    public function inscription(Request $request, EntityManagerInterface $em){

        $user = new User;
        $preference = new Preference;

        $form = $this->createForm(InscriptionType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // remplit user avec les info du formulaire
            $user = $form->getData();
            // remplit user avec la date du jour
            $user->setDate(new DateTime('now'));
            $user->setRoles('ROLE_USER');
            // encrypte password
            $password = $user->getPassword();
            $user->setPassword($this->encoder->hashPassword($user, $password));
            $this->setDefaultPreference($preference, $user);
            // enregistrer les changement
            $em->persist($user);
            $em->persist($preference);
            $em->flush();

            return $this->render('home.html.twig');
        }

        $formView = $form->createView();

        return $this->render('security/inscription.html.twig', [
            'formView' => $formView
        ]);
    }

    #[Route('/logout', name:'security_logout')]
    public function logout(){

    }

    public function setDefaultPreference($preference, $user){
        $preference->setUser($user);
        $preference->setAvatar('default_avatar.png');
        $preference->setPetAllowed(0);
        $preference->setSmokingAllowed(0);
        $preference->setMusic(2);
        $preference->setTalking(2);
        $preference->setTheme(0);
    }
}