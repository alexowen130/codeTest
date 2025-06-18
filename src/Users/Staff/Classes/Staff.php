<?php

declare(strict_types=1);

namespace App\Users\Staff\Classes;

use App\Users\Interfaces\UserInterface;

/**
 * Class Defining Staff infomation, conly contains staff Id but may grow as more context could be needed
 */
class Staff implements UserInterface
{
    /**
     * It appears that staff Ids are Ints not GUIDs so storing as INT
     * All Staff users require a DB Id that cannot be modified so made a read only param for clarity
     * @param int $id
     */
    public function __construct(private readonly int $id)
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
