<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\CategoryRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/projects', name: 'project_')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProjectRepository $projectRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $categoryId = $request->query->get('category');

        if ($categoryId) {
            $projects = $projectRepository->findByCategory((int)$categoryId);
            $category = $categoryRepository->find($categoryId);
        } else {
            $projects = $projectRepository->findAllOrdered();
            $category = null;
        }

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
            'categories' => $categoryRepository->findAllOrdered(),
            'selected_category' => $category,
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(Project $project, ProjectRepository $projectRepository): Response
    {
        // Get other projects from the same artist
        $relatedProjects = $projectRepository->findByArtist($project->getArtist()->getId());

        // Remove current project from related projects
        $relatedProjects = array_filter($relatedProjects, function($p) use ($project) {
            return $p->getId() !== $project->getId();
        });

        // Limit to 4 related projects
        $relatedProjects = array_slice($relatedProjects, 0, 4);

        return $this->render('project/show.html.twig', [
            'project' => $project,
            'related_projects' => $relatedProjects,
        ]);
    }
}
