<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/resume.pdf')]
final class ResumeController
{
    public function __invoke(): Response
    {

    }
}