<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProjectRepository $projectRepository, ArtistRepository $artistRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'recent_projects' => $projectRepository->findRecent(12),
            'featured_artists' => $artistRepository->findFeaturedArtists(6),
        ]);
    }
}
