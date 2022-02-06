<?php

namespace App\Controller\Ride;

use App\Entity\Message;
use App\Form\MessageType;
use App\Entity\Reservation;
use App\Repository\RoadTripRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowRideController extends AbstractController
{
    private $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    #[Route('/trajet/show/{id}', name:'show_ride')]
    public function show($id, RoadTripRepository $roadTripRepository, Request $request, EntityManagerInterface $em, Security $security){
        $message = new Message;
        $user = $security->getUser();
        //Verification du trajet
        $roadTrip = $roadTripRepository->find($id);
        if(!$roadTrip){
            $this->addFlash('error', "Le trajet que vous cherchez n'existe pas");
        }
        //creation du formulaire de message
        $form = $this->createForm(MessageType::class);
        //Gerer les information formulaire
        $form->handleRequest($request);
        if($user){
            if($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();
                $message
                    ->setMessageContent($data->getMessageContent())
                    ->setMessageDate(new DateTime('now'))
                    ->setMessageRecieverDelete(0)
                    ->setMessageReport(0)
                    ->setMessageSenderDelete(0)
                    ->setUserReciever($roadTrip->getUser())
                    ->setUserSender($user);
    
                $em->persist($message);
                $em->flush();
    
                $this->addFlash('success', "Votre message viens d'être envoyé!");
            }
        }
        $reservation = $this->countNbReservation($id);

        $formView = $form->createView();

        return $this->render('ride/showRide.html.twig', [
            'roadTrip' => $roadTrip,
            'reservation' => $reservation,
            'formView' => $formView
        ]);
    }

    #[Route('/trajet/reservation/{id}', name:'book_ride')]
    public function book($id, RoadTripRepository $roadTripRepository, Security $security, EntityManagerInterface $em){
        $roadTrip = $roadTripRepository->find($id);
        $reservations = $this->countNbReservation($id);
        $user = $security->getUser();
        //Compte le nombre de reservation déja faite
        if($reservations){
            $reservationCount = count($reservations);
        }else{
            $reservationCount = 0;
        }
        //Verifie si le nombre de place est suppérieur au nombre de réservation
        $nbSeat = $roadTrip->getNumberSeat();
        if($user){
            if($reservationCount < $nbSeat){
                $newReservation = new Reservation;
                $newReservation
                    ->setPassenger($user)
                    ->setRoadTrip($roadTrip);
                $em->persist($newReservation);
                $em->flush();
                
                $this->addFlash('success', "Votre réservation à bien été prise en compte!");
            }else{
                $this->addFlash('error', "Il n'y à plus assez de place pour ce trajet.");
            }
        }else{
            $this->addFlash('error', "Vous devez être connecté pour faire une réservation.");
        }

        return $this->redirectToRoute('show_ride', [
            'id' => $id
        ]);
    }

    public function countNbReservation($id){
        $reservation = $this->reservationRepository->findBy(['roadTrip' => $id]);
        return $reservation;
    }
}