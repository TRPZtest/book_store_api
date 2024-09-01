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
    public function books(/* #[MapQueryParameter]int $pageNumber, #[MapQueryParameter]int $pageSize, */ BookRepository $BookRepository,  SerializerInterface $serializer)  : Response
    {
        $books = $BookRepository->findAll();
        $jsonBooks = $serializer->serialize($books, 'json', ['json_decode_recursion_depth' => 0]);
                
        return new JsonResponse(["books"=> $jsonBooks]);
    }
}