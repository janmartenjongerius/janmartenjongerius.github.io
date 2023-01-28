<?php

namespace App\Controller;

use App\Repository\EmploymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(EmploymentRepository $employmentRepository): Response
    {
        return $this->render(
            'index/index.html.twig',
            ['employments' => $employmentRepository->findAll()]
        );
    }
}
