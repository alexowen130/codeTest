<?php

declare(strict_types=1);

namespace App\Users\Interfaces;

/**
 * Interface defining required calls for classes' using the interface
 */
interface UserInterface
{
    /**
     * Users will either have a DB id or a guid depending on the user type so allowed a union type to prevent erroneous
     * data
     * @return int|string
     */
    public function getId(): int|string;
}
