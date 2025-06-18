<?php

declare(strict_types=1);

namespace App\Message\SMS\Classes;

use App\Message\Abstract\AbstractMessage;
use App\Message\Content\Classes\Content;
use App\Message\Enums\MsgStatusEnum;
use App\Message\Interfaces\MessageInterface;
use App\Users\Staff\Classes\Staff;
use App\Users\Student\Student;
use App\Users\Student\StudentGroup;
use DateTime;

/**
 * Class Defining the Structure of an SMS Message
 */
class SMS extends AbstractMessage implements MessageInterface
{
    private string $recipient;
    private Staff $sender;
    private Content $message;
    private DateTime $timestamp;
    private StudentGroup|Student $student;
    private string $provider;

    /**
     * @param string $id
     * @param string $webhookUrl
     * @param string $recipient
     * @param Staff $sender
     * @param Content $message
     * @param Student|StudentGroup $student
     * @param DateTime $timestamp
     * @param MsgStatusEnum $status
     * @param string $provider
     */
    public function __construct(
        string $id,
        string $webhookUrl,
        string $recipient,
        Staff $sender,
        Content $message,
        Student|StudentGroup $student,
        DateTime $timestamp,
        MsgStatusEnum $status,
        string $provider
    ) {
        parent::__construct($id, $webhookUrl, $status);
        $this->recipient = $recipient;
        $this->sender = $sender;
        $this->message = $message;
        $this->student = $student;
        $this->timestamp = $timestamp;
        $this->provider = $provider;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @return Staff
     */
    public function getSender(): Staff
    {
        return $this->sender;
    }

    /**
     * @return Content
     */
    public function getMessage(): Content
    {
        return $this->message;
    }

    /**
     * @return DateTime
     */
    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return Student|StudentGroup
     */
    public function getStudent(): Student|StudentGroup
    {
        return $this->student;
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }
}
