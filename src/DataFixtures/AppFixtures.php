<?php

namespace App\DataFixtures;

use App\Entity\Message;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Preference;
use App\Entity\Reservation;
use App\Entity\RoadTrip;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        //moderator
        for($m = 0; $m<10; $m++){
            $moderator = new User();
            $hash = $this->userPasswordHasher->hashPassword($moderator,'123aze');
            $moderator
                ->setDate($faker->dateTimeBetween('-6 months', 'now'))
                ->setEmail("moderator$m@gmail.com")
                ->setName($faker->name())
                ->setPassword($hash)
                ->setPhoneNumber($faker->phoneNumber())
                ->setSurname($faker->name())
                ->setRoles(["ROLE_MODERATOR"]);

            $manager->persist($moderator);    

        }
        $usersId=[];
        //user
        for($u = 0; $u<60; $u++){
            $user = new User();
            $hash = $this->userPasswordHasher->hashPassword($user,'123aze');
            $user
                ->setDate($faker->dateTimeBetween('-6 months', 'now'))
                ->setEmail("user$u@gmail.com")
                ->setName($faker->name())
                ->setPassword($hash)
                ->setPhoneNumber($faker->phoneNumber())
                ->setSurname($faker->name())
                ->setRoles(["ROLE_USER"]);

                $usersId[] = $user;
            $manager->persist($user);    

        }
        //preference
        $arrAvatar = ['avatar1.png', 'avatar2.png', 'avatar3.png', 'avatar4.png', 'default_avatar.png'];
        for($p = 0; $p<60; $p++){
            $preference = new Preference;
            $preference
                ->setAvatar($faker->randomElement($arrAvatar))
                ->setPetAllowed(rand(0,1))
                ->setSmokingAllowed(rand(0,1))
                ->setMusic(rand(0,2))
                ->setTalking(rand(0,2))
                ->setTheme(rand(0,1))
                ->setUser($usersId[$p])
                ;
            $manager->persist($preference);    
        }
        //roadTrip
        $roadTrips = [];
        for($r = 0; $r< 200; $r++){
            $roadTrip = new RoadTrip;
            $roadTrip
                ->setStartingPlace('Marseille')
                ->setEndingPlace('Paris')
                ->setNumberSeat(rand(1,4))
                ->setPostDate($faker->dateTimeBetween('-10 days', 'now'))
                ->setStartingTime($faker->dateTimeBetween('+1 days','+50 days'))
                ->setEndingTime($faker->dateTimeBetween('+1 days','+50 days'))
                ->setTripDistance(rand(2000, 60000))
                ->setTripDate($faker->dateTimeBetween('+1 days','+50 days'))
                ->setTripDuration(rand(200, 3000))
                ->setUser($faker->randomElement($usersId));

                $roadTrips[] = $roadTrip;

            $manager->persist($preference);    

        }
        //Reservation
        for($re = 0; $re< 80; $re++){
            $reservation = new Reservation;
            $reservation
                ->setPassenger($faker->randomElement($usersId))
                ->setRoadTrip($faker->randomElement($roadTrips));

            $manager->persist($reservation);
        }
        //message
        for($m = 0; $m< 450; $m++){
            $message = new Message;
            $message
                ->setMessageContent($faker->sentences(3, true))
                ->setMessageDate($faker->dateTimeBetween('-10 days', 'now'))
                ->setMessageRecieverDelete(0)
                ->setMessageReport(0)
                ->setMessageSenderDelete(0)
                ->setUserReciever($faker->randomElement($usersId))
                ->setUserSender($faker->randomElement($usersId));

                $manager->persist($message);

        }
        $manager->flush();
    }
}
