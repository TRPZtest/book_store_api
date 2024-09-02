<?php
namespace App\Controller;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends AbstractController
{
    #[Route(path:"api/tags", name:"get_tags", methods: ["GET"])]
    public function getAll(TagRepository $tagRepository) : Response
    {
        $tags = $tagRepository->findAll();

        return $this->json($tags);
    }

    public function addTag(#[MapRequestPayload]Tag $tag, EntityManagerInterface $em) : Response
    {
        
    }
}