<?php
namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends AbstractController
{
    #[Route(path:"api/tags", name:"get_tags", methods: ["GET"])]
    public function getAll(TagRepository $tagRepository) : Response
    {
        $tags = $tagRepository->findAll();

        return $this->json($tags);
    }
}