<?php 

namespace App\Controller;

use App\Form\UpdateUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class User extends AbstractController
{

    #[Route('/user', name:'user_show')]
    public function show_account(){
        
        $form = $this->createForm(UpdateUserType::class);
        $formView = $form->createView();

        return $this->render('user/userAccount.html.twig', [
            'formView' => $formView
        ]);
    }
}