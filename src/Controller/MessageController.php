<?php

namespace App\Controller;

use App\Service\MessageService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    #[Route('/message/deleteasSender/{$id}', name:'message_delete_asSender')]
    public function deleteMessageSender(Request $request, MessageService $messageService){
        $id = $request->query->get('id');
        $messageService->deleteMessageAsSender($id);

        return $this->redirectToRoute('user_show');
    }

    #[Route('/message/deleteasReciever/{$id}', name:'message_delete_asReciever')]
    public function deleteMessageReciever(Request $request, MessageService $messageService){
        $id = $request->query->get('id');
        $messageService->deleteMessageAsReciever($id);

        return $this->redirectToRoute('user_show');
    }

    #[Route('/message/report/{$id}', name:'message_report')]
    public function reportMessage(Request $request,  MessageService $messageService){
        $id = $request->query->get('id');
        $messageService->reportMessage($id);

        return $this->redirectToRoute('user_show');
    }
}