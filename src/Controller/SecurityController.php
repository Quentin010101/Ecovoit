<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use App\Form\LoginType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    protected $encoder;

    public function __construct(UserPasswordHasherInterface $encoder){
        $this->encoder = $encoder;
    }

    #[Route('/login', name:'security_login')]
    public function login(AuthenticationUtils $authenticationUtils){
        $error = $authenticationUtils->getLastAuthenticationError();

        $form = $this->createForm(LoginType::class);
        $formView = $form->createView();

        return $this->render('security/login.html.twig', [
            'formView' => $formView
        ]);
    }

    #[Route('/inscription', name:'security_inscription')]
    public function inscription(Request $request, EntityManagerInterface $em){

        $user = new User;

        $form = $this->createForm(InscriptionType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // remplit user avec les info du formulaire
            $user = $form->getData();
            // remplit user avec la date du jour
            $user->setDate(new DateTime('now'));
            // encrypte password
            $password = $user->getPassword();
            $user->setPassword($this->encoder->hashPassword($user, $password));
            // enregistrer les changement
            $em->persist($user);
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
}