<?php

namespace App\Service;

use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessageService extends AbstractController
{
    private $messageRepository;
    private $em;

    public function __construct(MessageRepository $messageRepository, EntityManagerInterface $em){
        $this->messageRepository = $messageRepository;
        $this->em = $em;
    }

    public function messageSent($id): array
    {
        $messageSent = $this->messageRepository->findBy(['userSender' => $id]);
        return $messageSent;
    }

    public function messageRecieve($id): array
    {
        $messageRecieve = $this->messageRepository->findBy(['userReciever' => $id]);
        return $messageRecieve;
    }


    public function deleteMessageAsSender($id){
        $message = $this->messageRepository->find($id);
        if($message){
            $message->setMessageSenderDelete(1);
            $this->em->flush();
            $this->addFlash('success','Le message à bien été suprimé!');
        }
        else{
            $this->addFlash('error','Un problème est survenue, veuillez reassayer plus tard.');
        }
    }

    public function deleteMessageAsReciever($id){
        $message = $this->messageRepository->find($id);
        if($message){
            $message->setMessageRecieverDelete(1);
            $this->em->flush();
            $this->addFlash('success','Le message à bien été suprimé!');
        }
        else{
            $this->addFlash('error','Un problème est survenue, veuillez reassayer plus tard.');
        }

    }

    public function reportMessage($id){
        $message = $this->messageRepository->find($id);
        if($message){
            $message->setMessageReport(1);
            $this->em->flush();
            $this->addFlash('success','Le message à bien été reporté!');
        }
        else{
            $this->addFlash('error','Un problème est survenue, veuillez reassayer plus tard.');
        }
    }

    public function messageReported(){
        $message = $this->messageRepository->findBy(['messageReport' => 1]);
        if($message){
            return $message;
        }
    }

    public function unReportMessage($id){
        $message = $this->messageRepository->find($id);
        if($message){
            $message->setMessageReport(0);
            $this->em->flush();
            $this->addFlash('success',"Le message n'est plus signalé!");
        }
        else{
            $this->addFlash('error','Un problème est survenue, veuillez reassayer plus tard.');
        }
    }
}