<?php

// src/DTO/BookDTO.php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class EditBookDTO extends BookDTO
{
    #[Assert\NotBlank]
    public int $id;
}
