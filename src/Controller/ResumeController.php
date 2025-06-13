<?php
declare(strict_types=1);

namespace App\Controller;

use App\Pdf\PdfFactoryInterface;
use App\Repository\EmploymentRepository;
use App\Repository\TestimonialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/resume.pdf')]
final class ResumeController extends AbstractController
{
    public function __construct(
        private readonly PdfFactoryInterface $pdfFactory
    )
    {
    }

    public function __invoke(
        EmploymentRepository $employmentRepository,
        TestimonialRepository $testimonialRepository,
    ): Response {
        $pdf = $this->pdfFactory->createFromHtml(
            $this->renderView(
                'resume/index.html.twig',
                [
                    'employments' => $employmentRepository->findAll(),
                    'testimonials' => $testimonialRepository->findAll(),
                ]
            )
        );

        return new Response(
            content: (string) $pdf,
            status: Response::HTTP_OK,
            headers: [
                'Content-Disposition' => 'inline',
                'Content-Type' => 'application/pdf'
            ]
        );
    }
}
