<?php
namespace App\Controller;

use App\DTO\BookDTO;
use App\DTO\EditBookDTO;
use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class BooksController extends AbstractController 
{
    #[Route(path:"api/books", name:"get_books", methods: ["GET"])]
    public function books( #[Assert\NotBlank]int $pageNumber,  #[Assert\NotBlank]#[MapQueryParameter]int $pageSize, BookRepository $bookRepository)  : Response
    {
        $books = $bookRepository->findAll();
                     
        return $this->json($books, Response::HTTP_OK);
    }

    #[Route(path:"api/book", name:"get_book_by_id", methods: ["GET"])]
    public function book(#[MapQueryParameter]int $id,   BookRepository $bookRepository) : Response
    {
        $book = $bookRepository->find($id);

        if (!$book) 
            return $this->json(null, Response::HTTP_NOT_FOUND);
        else
            return $this->json($book, Response::HTTP_OK);
    }

    #[Route(path: "api/book", name: "add_book", methods: ["POST"])]
    public function addBook(#[MapRequestPayload]BookDTO $bookDTO, EntityManagerInterface $em, CategoryRepository $categoryRepository, TagRepository $tagRepository,   ValidatorInterface $validator): Response
    { 
        $errors = $validator->validate($bookDTO);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }
    
        $category = $categoryRepository->find($bookDTO->categoryId);
        if (!$category) {
            return $this->json(['message' => 'Category not found'], Response::HTTP_BAD_REQUEST);
        }
        
        $tags = $tagRepository->findBy(['id' => $bookDTO->tags]);
        if (count($tags) !== count($bookDTO->tags)) {
            return $this->json(['message' => 'One or more tags not found'], Response::HTTP_BAD_REQUEST);
        }

        $book = new Book();
        $book->setName($bookDTO->name);
        $book->setDescription($bookDTO->description);
        $book->setCategory($category);

    
        foreach ($tags as $tag) {
            $book->addTag($tag);
        }

        $em->persist($book);
        $em->flush();

        return $this->json($book, Response::HTTP_CREATED);
    }

    #[Route(path: "api/book", name: "edit_book", methods: ["PUT"])]
    public function editBook(
        #[MapRequestPayload] EditBookDTO $editBookDTO,
        BookRepository $bookRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        EntityManagerInterface $em
    ): Response {
      
        $book = $bookRepository->find($editBookDTO->id);

        if (!$book) {
            return $this->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }
      
        $category = $categoryRepository->find($editBookDTO->categoryId);
        if (!$category) {
            return $this->json(['message' => 'Category not found'], Response::HTTP_BAD_REQUEST);
        }
     
        $tags = $tagRepository->findBy(['id' => $editBookDTO->tags]);
       
        $book->setName($editBookDTO->name);
        $book->setDescription($editBookDTO->description);
        $book->setCategory($category);
        
        foreach ($book->getTags() as $tag) {
            $book->removeTag($tag);
        }
        foreach ($tags as $tag) {
            $book->addTag($tag);
        }
     
        $em->persist($book);
        $em->flush();

        return $this->json($book, Response::HTTP_OK);
    }

    public function deleteBook(#[MapQueryParameter]int $id, BookRepository $bookRepository,   EntityManagerInterface $em): Response{
        $book = $this->$bookRepository->find($id);

        if (!$book) {
            return $this->json(['message' => 'Book not found'], Response::HTTP_BAD_REQUEST);
        }

        $em->remove($book);
        $em->flush();
        
        return $this->json(null, Response::HTTP_OK);
    }
}