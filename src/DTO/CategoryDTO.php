<?php

namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public int $id;
}