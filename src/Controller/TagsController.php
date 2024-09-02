<?php
namespace App\Controller;

use App\DTO\EditTagDTO;
use App\DTO\TagDTO;
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

    #[Route(path:"api/tag", name:"add_tag", methods: ["POST"])]
    public function addTag(#[MapRequestPayload]TagDTO $tagDTO, EntityManagerInterface $em) : Response
    {
        $tag = new Tag();
        $tag->setName($tagDTO->name);

        $em->persist($tag);
        $em->flush();

        return $this->json($tag, Response::HTTP_CREATED);
    }

    #[Route(path:"api/tag", name:"edit_tag", methods: ["PUT"])]
    public function editTag(#[MapRequestPayload]EditTagDTO $editTagDTO, EntityManagerInterface $em, TagRepository $tagRepository) : Response
    {
        $tag = $tagRepository->find($editTagDTO->id);

        if (!$tag) 
            return $this->json(['message' => 'Tag not found'], Response::HTTP_NOT_FOUND);
               
        $tag->setName($editTagDTO->name);

        $em->persist($tag);
        $em->flush();

        return $this->json($tag, Response::HTTP_OK);
    }
}