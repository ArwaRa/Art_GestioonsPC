<?php

namespace App\Controller\Admin;

use App\Repository\ArtistRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'admin_')]
class AdminDashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(
        ProjectRepository $projectRepository,
        ArtistRepository $artistRepository,
        CategoryRepository $categoryRepository,
        UserRepository $userRepository
    ): Response {
        return $this->render('admin/dashboard/index.html.twig', [
            'total_projects' => count($projectRepository->findAll()),
            'total_artists' => count($artistRepository->findAll()),
            'total_categories' => count($categoryRepository->findAll()),
            'total_users' => count($userRepository->findAll()),
            'recent_projects' => $projectRepository->findRecent(5),
        ]);
    }
}
