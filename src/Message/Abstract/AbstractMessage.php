<?php

declare(strict_types=1);

namespace App\Message\Abstract;

use App\Message\Enums\MsgStatusEnum;

/**
 * Abstract Message Class to group common class calls among all messages
 */
class AbstractMessage
{
    /**
     * @param string $id
     * @param string $webhookUrl
     * @param MsgStatusEnum $status
     */
    public function __construct(
        private readonly string $id,
        private readonly string $webhookUrl,
        private MsgStatusEnum $status,
    ) {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getWebhookUrl(): string
    {
        return $this->webhookUrl;
    }

    /**
     * @return MsgStatusEnum
     */
    public function getStatus(): MsgStatusEnum
    {
        return $this->status;
    }
}
