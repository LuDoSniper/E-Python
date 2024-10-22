<?php

namespace App\Controller\Exercise;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseController extends AbstractController
{
    public function __construct(
        public EntityManagerInterface $entityManager
    ){}

    #[Route('/admin/exercise/create', 'app_admin_exercise_create')]
    public function create(): Response
    {
        return $this->render('Page/Exercise/create.html.twig');
    }
}