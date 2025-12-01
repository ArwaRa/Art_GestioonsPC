<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'admin_')]
class AdminDashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(
        ProjectRepository $projectRepository,
        CategoryRepository $categoryRepository
    ): Response {
        return $this->render('admin/dashboard/index.html.twig', [
            'total_projects' => count($projectRepository->findAll()),
            'total_categories' => count($categoryRepository->findAll()),
            'recent_projects' => $projectRepository->findRecent(5),
        ]);
    }
}
