<?php 

namespace App\Controller\Ride;

use App\Form\PostRideType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class PostRideController extends AbstractController
{

    #[Route('/trajet/post', name:'postRide_search')]
    public function postRide(Request $request, Security $security, EntityManagerInterface $em){

        $user = $security->getUser();

        $form = $this->createForm(PostRideType::class);

        $form->handleRequest($request);
        if($user){
            if($form->isSubmitted() && $form->isValid()){
                /** @var RoadTrip */
                $roadtrip = $form->getData();
                $roadtrip->setPostDate(new DateTime('now'));
                // set ending time
                $date = $roadtrip->getStartingTime();
                $duration = $roadtrip->getTripDuration();
                $date->modify("+$duration seconde");
                $roadtrip->setEndingTime($date);
                $roadtrip->setUser($user);
    
                $em->persist($roadtrip);
                $em->flush();

                $this->addFlash('success', "Votre trajet à bien été posté");
                return $this->redirectToRoute('ride_search');
            }
        }else if($form->isSubmitted()){
            $this->addFlash('error',"Vous devez être connecté pour poster un message");
        }

        $formView = $form->createView();

        return $this->render('ride/search.html.twig', [
            'formView' => $formView
        ]);

    }
}