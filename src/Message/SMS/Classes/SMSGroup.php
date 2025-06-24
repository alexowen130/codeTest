<?php

declare(strict_types=1);

namespace App\Message\SMS\Classes;

/**
 * Group of SMS Messages
 */
readonly class SMSGroup
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
     * @return array
     */
    public function getGroup(): array
    {
        return $this->group;
    }
}
