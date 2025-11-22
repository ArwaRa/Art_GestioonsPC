<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Repository\ArtistRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/artists', name: 'artist_')]
class ArtistController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ArtistRepository $artistRepository): Response
    {
        return $this->render('artist/index.html.twig', [
            'artists' => $artistRepository->findAllOrdered(),
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(Artist $artist, ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findByArtist($artist->getId());

        return $this->render('artist/show.html.twig', [
            'artist' => $artist,
            'projects' => $projects,
        ]);
    }
}
