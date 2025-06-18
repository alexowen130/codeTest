<?php

declare(strict_types=1);

namespace App\Users\Student;

/**
 * Class Defining and Object that Contains a group of Students
 */
class StudentGroup
{
    private array $group;

    /**
     * @param array $group
     */
    public function __construct(array $group)
    {
        $this->group = $group;
    }

    /**
     * @param Student $student
     * @return void
     *
     * Allows for adding a Student to Group of Students involved in a message
     */
    public function addToGroup(Student $student): void
    {
        $this->group[] = $student;
    }

    /**
     * @param int $key
     * @return void
     *
     * Allows for removing a student from a Group of Students involved in a message
     */
    public function removeFromGroup(int $key): void
    {
        unset($this->group[$key]);
    }

    /**
     * @return array
     */
    public function getGroup(): array
    {
        return $this->group;
    }
}
