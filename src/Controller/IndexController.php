<?php

namespace App\Controller;

use App\Repository\EmploymentRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(
        EmploymentRepository $employmentRepository,
        EventRepository $eventRepository
    ): Response {
        return $this->render(
            'index/index.html.twig',
            [
                'employments' => $employmentRepository->findAll(),
                'events' => $eventRepository->findAll()
            ]
        );
    }
}
