<?php
declare(strict_types=1);

namespace App\Controller;

use App\Pdf\PdfFactoryInterface;
use App\Repository\EmploymentRepository;
use App\Repository\TestimonialRepository;
use App\Twig\Asset;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ResumeController extends AbstractController
{
    public function __construct(
        private readonly EmploymentRepository $employmentRepository,
        private readonly TestimonialRepository $testimonialRepository,
        private readonly Asset $avatar = new Asset(
            __DIR__ . '/../../assets/img/avatar.jpeg'
        )
    ) {
    }

    private function renderHtml(): string
    {
        return $this->renderView(
            'resume/index.html.twig',
            [
                'employments' => $this->employmentRepository->findAll(),
                'testimonials' => $this->testimonialRepository->findAll(),
                'educations' => [],
                'certifications' => [],
                'avatar' => $this->avatar,
            ]
        );
    }

    #[Route('/resume.html', env: 'dev')]
    public function html(): Response
    {
        return new Response(
            content: $this->renderHtml(),
            headers: [
                'Content-Type' => 'text/html',
            ]
        );
    }


    #[Route('/resume.pdf')]
    public function pdf(PdfFactoryInterface $pdfFactory): Response
    {
        return new Response(
            content: (string) $pdfFactory->createFromHtml(
                $this->renderHtml()
            ),
            headers: [
                'Content-Disposition' => 'inline',
                'Content-Type' => 'application/pdf'
            ]
        );
    }
}
