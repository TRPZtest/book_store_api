<?php
namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class BooksController extends AbstractController 
{
    #[Route(path:"api/books", name:"get_books", methods: ["GET"])]
    public function books(/* #[MapQueryParameter]int $pageNumber, #[MapQueryParameter]int $pageSize, */ BookRepository $BookRepository)  : Response
    {
        $books = $BookRepository->findAll();
                     
        return $this->json($books, Response::HTTP_OK);
    }

    #[Route(path:"api/book", name:"get_book_by_id", methods: ["GET"])]
    public function book(#[MapQueryParameter]int $id,   BookRepository $BookRepository) : Response
    {
        $book = $BookRepository->find($id);

        if (!$book) 
            return $this->json(null, Response::HTTP_NOT_FOUND);
        else
            return $this->json($book, Response::HTTP_OK);
    }
}