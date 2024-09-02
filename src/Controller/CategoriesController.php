<?php
namespace App\Controller;

use App\DTO\CategoryDTO;
use App\DTO\EditCategoryDTO;
use App\DTO\TagDTO;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController 
{
    #[Route(path: "api/categories", name: "get_categories", methods: ["GET"])]
    public function categories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->json($categories, Response::HTTP_OK);
    }

    #[Route(path:"api/category", name:"add_category", methods: ["POST"])]
    public function addTag(#[MapRequestPayload]CategoryDTO $categoryDTO, EntityManagerInterface $em) : Response
    {
        $category = new Category();
        $category->setName($categoryDTO->name);

        $em->persist($category);
        $em->flush();

        return $this->json($category, Response::HTTP_CREATED);
    }

    #[Route(path:"api/category", name:"edit_category", methods: ["PUT"])]
    public function editTag(#[MapRequestPayload]EditCategoryDTO $editCategoryDTO, EntityManagerInterface $em, CategoryRepository $categoryRepository) : Response
    {
        $category = $categoryRepository->find($editCategoryDTO->id);

        if (!$category) 
            return $this->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
               
        $category->setName($categoryRepository->name);

        $em->persist($category);
        $em->flush();

        return $this->json($category, Response::HTTP_OK);
    }
}