<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModeratorAccount extends AbstractController
{
    #[Route('/moderator/show', name:'moderator_show')]
    #[Security("is_granted('ROLE_ADMIN') and is_granted('ROLE_MODERATOR')")]
    public function show(MessageService $messageService, UserRepository $userRepository){
        // Recupération des messages signalé
        $messageReported = $messageService->messageReported();
        //Recupération des utilisateurs bannis
        $users = $userRepository->findAll();
        $usersBan = [];
        foreach($users as $u):
            if(in_array("ROLE_BAN",$u->getRoles())){
                $usersBan[] = $u;
            }
        endforeach;   

        return $this->render('moderator/moderatorAccount.html.twig', [
            'messageReported' => $messageReported,
            'usersBan' => $usersBan
        ]);
    }

    #[Route('/moderator/unReport/{id}', name:'moderator_unReport')]
    #[Security("is_granted('ROLE_ADMIN') and is_granted('ROLE_MODERATOR')")]
    public function unReport($id, MessageService $messageService)
    {
        $messageService->unReportMessage($id);
        return $this->redirectToRoute('moderator_show');
    }

    #[Route('/moderator/banUser/{id}', name:'moderator_banUser')]
    #[Security("is_granted('ROLE_ADMIN') and is_granted('ROLE_MODERATOR')")]
    public function banUser($id, UserRepository $userRepository, EntityManagerInterface $em){
        /** @var User */
        $user = $userRepository->find($id);
        if($user && in_array('ROLE_USER', $user->getRoles())){
            $user->setRoles(["ROLE_BAN"]);
            $em->flush();
            $name = $user->getName();
            $this->addFlash('success', "L'utilisateur $name à bien été bannis!");
        }
        else{
            $this->addFlash('error', "L'utilisateur demandé est introuvable");
        }

        return $this->redirectToRoute('moderator_show');
    }

    #[Route('/moderator/unBanUser/{id}', name:'moderator_unBanUser')]
    #[Security("is_granted('ROLE_ADMIN') and is_granted('ROLE_MODERATOR')")]
    public function unBanUser($id, UserRepository $userRepository, EntityManagerInterface $em){
        $user = $userRepository->find($id);
        if($user && in_array('ROLE_BAN', $user->getRoles())){
            $user->setRoles(["ROLE_USER"]);
            $em->flush();
            $name = $user->getName();
            $this->addFlash('success', "Le bannissement de $name à bien été retiré!");
        }
        else{
            $this->addFlash('error', "L'utilisateur demandé est introuvable");
        }
        return $this->redirectToRoute('moderator_show');

    }
}