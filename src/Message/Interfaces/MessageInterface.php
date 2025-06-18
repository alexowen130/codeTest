<?php

declare(strict_types=1);

namespace App\Message\Interfaces;

use App\Message\Content\Classes\Content;
use App\Message\Enums\MsgStatusEnum;
use App\Users\Staff\Classes\Staff;
use App\Users\Student\Student;
use App\Users\Student\StudentGroup;
use DateTime;

/**
 * Interface all Message Class' must adhere to
 */
interface MessageInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getRecipient(): string;

    /**
     * @return Staff
     */
    public function getSender(): Staff;

    /**
     * @return Content
     */
    public function getMessage(): Content;

    /**
     * @return DateTime
     */
    public function getTimestamp(): DateTime;

    /**
     * @return Student|StudentGroup
     */
    public function getStudent(): Student|StudentGroup;

    /**
     * @return MsgStatusEnum
     */
    public function getStatus(): MsgStatusEnum;
}
