<?php

namespace App\Controller;

use App\Form\PreferenceType;
use App\Form\UpdateUserType;
use App\Service\MessageController;
use App\Repository\RoadTripRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use App\Service\MessageService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserAccount extends AbstractController
{

    #[Route('/user', name: 'user_show')]
    public function show_account(Security $security, Request $request, EntityManagerInterface $em, RoadTripRepository $roadTripRepository, ReservationRepository $reservationRepository, MessageService $messageService)
    {

        /** @var User */
        $user = $security->getUser();

        //verification compte utilisateur
        if ($user === null) {
            return $this->redirectToRoute('homepage');
        }
        //-----------------------------

        // 1 - Recupération des trajets
        $rideAsDriver = $roadTripRepository->findBy(['user' => $user->getId()]);
        $reservation = $reservationRepository->findBy(['passenger' => $user->getId()]);
        $rideAsPassenger = [];
        foreach ($reservation as $r) :
            $rideAsPassenger[] = $roadTripRepository->findBy(['id' => $r->getRoadTrip()]);
        endforeach;
        //------------------------------- 

        // 2 - Recupération des preference de l'utilisateur
        $preference = $user->getPreference();
        //------------------------------- 

        // 3 - Recupération des messages
        $messagesRecieve = $messageService->messageRecieve($user->getId());
        $messagesSent = $messageService->messageSent($user->getId());
        //------------------------------- 

        //création du formulaire
        $form = $this->createForm(UpdateUserType::class, $user);
        $formPreference = $this->createForm(PreferenceType::class, $preference);

        // Gerer les informations soumis par l'utilisateur
        $this->edit($form, $request, $em);
        $this->editPreference($formPreference, $request, $em, $preference);

        $formView = $form->createView();
        $formPreferenceView = $formPreference->createView();
        return $this->render('user/userAccount.html.twig', [
            'formView' => $formView,
            'formPreferenceView' => $formPreferenceView,
            'rideAsDriver' => $rideAsDriver,
            'rideAsPassenger' => $rideAsPassenger,
            'messagesRecieve' => $messagesRecieve,
            'messagesSent' => $messagesSent,
        ]);
    }

    public function edit($form, $request, $em)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success', 'Vos information personnel ont été mise à jour.');
            } else {
                $this->addFlash('error', 'Une erreur est survenue.');
            }
        }
    }

    public function editPreference($form, $request, $em, $preference)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $file = $form['avatar']->getData();
                if ($file) {
                    $directory = $this->getParameter('avatar_directory');

                    $fileToUnlink = $directory . '/' . $preference->getAvatar();
                    if (file_exists($fileToUnlink) && $fileToUnlink !== $directory . '/' . 'default-avatar.png') {
                        unlink($fileToUnlink);
                    }
                    $newFileName = uniqid() . '.' . $file->guessExtension();
                    $file->move($directory, $newFileName);

                    $preference->setAvatar($newFileName);
                }
                $em->flush();
                $this->addFlash('success', 'Vos préférences ont été mise à jour.');
            } else {
                $this->addFlash('error', 'Une erreur est survenue.');
            }
        }
    }
}
