<?php

declare(strict_types=1);

namespace App\Users\Student;

use App\Users\Interfaces\UserInterface;

/**
 * Student Class containing student information, only contains Student Id at the moment but there is an assumption that
 * this could get larger if greater context is required in the future
 */
class Student implements UserInterface
{
    /**
     * @param string $id
     * All Students require a DB GUID that cannot be modified so made a read only param for clarity
     */
    public function __construct(private string $id)
    {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
