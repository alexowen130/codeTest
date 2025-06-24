<?php

declare(strict_types=1);

namespace App\Message\Enums;

/**
 * Enum Defining all the Status' Allowed for Messages
 */
enum MsgStatusEnum: string
{
    case SENT = 'SENT';
    case DELIVERED = 'DELIVERED';
    case FAILED = 'FAILED';
    case REJECTED = 'REJECTED';

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
