<?php

namespace App\Controller\Authentication;

use App\Entity\Authentication\User;
use App\Form\Type\Authentication\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(
        public EntityManagerInterface $entityManager,
        public UserPasswordHasherInterface $hasher
    ){}

    #[Route('/login', 'app_authentication_login')]
    public function login(): Response
    {
        return $this->render('Page/Authentication/login.html.twig');
    }

    #[Route('/register', 'app_authentication_register')]
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $hashedPassword = $this->hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('Page/Authentication/register.html.twig', [
            'form' => $form
        ]);
    }
}