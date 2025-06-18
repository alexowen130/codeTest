<?php

declare(strict_types=1);

namespace App\Message\Content\Classes;

/**
 * Class Defining Message Content
 */
class Content
{
    /**
     * @param string $subject
     * @param string $message
     */
    public function __construct(private string $subject, private string $message)
    {
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
