<?php

namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class EditCategoryDTO
{
    #[Assert\NotBlank]
    public int $id;
}