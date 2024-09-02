<?php

namespace App\DTO;
use App\DTO\TagDTO;
use Symfony\Component\Validator\Constraints as Assert;

class EditTagDTO extends TagDTO
{
    #[Assert\NotBlank]
    public int $id;
}