<?php

namespace App\Controller\Ride;

use App\Form\SearchRideType;
use App\Repository\RoadTripRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FindRideController extends AbstractController
{
    protected $roadTripRepository;

    public function __construct(RoadTripRepository $roadTripRepository)
    {
        $this->roadTripRepository = $roadTripRepository;
    }

    #[Route('/trajet/search', name:'findRide_search')]
    public function searchRide(Request $request){
        // array pour stocker tout les trajet trouver
        $rides = [];

        $form = $this->createForm(SearchRideType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            $data = $form->getData();
            $rides = $this->findRide($data);

            return $this->render('ride/showSearch.html.twig', [
                'rides' => $rides
            ]);
        }

        $formView = $form->createView();

        return $this->render('ride/search.html.twig', [
            'formView' => $formView,
        ]);
    }

    public function findRide($data){

        $ride = $this->roadTripRepository->findBy( 
            ['startingPlace' => $data->getStartingPlace(), 'endingPlace' => $data->getEndingPlace()]
        );
        foreach($ride as $r):
        $r->getUser()->getSurname();
        endforeach;
        
        return $ride;
    }
}