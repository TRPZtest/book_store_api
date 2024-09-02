<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class BookDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Length(max: 1000)]
    public string $description;

    #[Assert\NotBlank]
    public int $categoryId; // Expecting category ID

    #[Assert\All([
        new Assert\Type('integer'),
    ])]
    public array $tags; // Expecting an array of tag IDs
}
