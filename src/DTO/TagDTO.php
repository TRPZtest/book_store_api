<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class TagDTO 
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $name;
}