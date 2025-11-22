<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin/artist', name: 'admin_artist_')]
class AdminArtistController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ArtistRepository $artistRepository): Response
    {
        return $this->render('admin/artist/index.html.twig', [
            'artists' => $artistRepository->findAllOrdered(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $profileImageFile = $form->get('profileImageFile')->getData();
            if ($profileImageFile) {
                $originalFilename = pathinfo($profileImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$profileImageFile->guessExtension();

                try {
                    $profileImageFile->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads/artists',
                        $newFilename
                    );
                    $artist->setProfileImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
                }
            }

            $entityManager->persist($artist);
            $entityManager->flush();

            $this->addFlash('success', 'L\'artiste a été créé avec succès.');

            return $this->redirectToRoute('admin_artist_index');
        }

        return $this->render('admin/artist/new.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Artist $artist): Response
    {
        return $this->render('admin/artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Artist $artist, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $profileImageFile = $form->get('profileImageFile')->getData();
            if ($profileImageFile) {
                $originalFilename = pathinfo($profileImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$profileImageFile->guessExtension();

                try {
                    $profileImageFile->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads/artists',
                        $newFilename
                    );

                    // Delete old file if exists
                    if ($artist->getProfileImage()) {
                        $oldFile = $this->getParameter('kernel.project_dir').'/public/uploads/artists/'.$artist->getProfileImage();
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }

                    $artist->setProfileImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'L\'artiste a été modifié avec succès.');

            return $this->redirectToRoute('admin_artist_index');
        }

        return $this->render('admin/artist/edit.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Artist $artist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            // Delete profile image if exists
            if ($artist->getProfileImage()) {
                $imageFile = $this->getParameter('kernel.project_dir').'/public/uploads/artists/'.$artist->getProfileImage();
                if (file_exists($imageFile)) {
                    unlink($imageFile);
                }
            }

            $entityManager->remove($artist);
            $entityManager->flush();

            $this->addFlash('success', 'L\'artiste a été supprimé avec succès.');
        }

        return $this->redirectToRoute('admin_artist_index');
    }
}
