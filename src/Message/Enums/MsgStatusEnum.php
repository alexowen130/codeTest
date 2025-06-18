<?php

declare(strict_types=1);

namespace App\Message\Enums;

/**
 * Enum Defining all the Status' Allowed for Messages
 */
enum MsgStatusEnum
{
    case SENT;
    case DELIVERED;
    case FAILED;
    case REJECTED;
}
