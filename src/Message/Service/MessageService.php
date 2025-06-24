<?php

declare(strict_types=1);

namespace App\Message\Service;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use App\Message\Content\Classes\Content;
use Psr\Container\ContainerInterface;
use App\Message\SMS\Classes\SMSGroup;
use App\Message\Enums\MsgStatusEnum;
use App\Users\Staff\Classes\Staff;
use DateMalformedStringException;
use App\Message\SMS\Classes\SMS;
use App\Users\Student\Student;
use Monolog\Logger;
use JsonException;
use Exception;
use DateTime;
use PDO;

/**
 * Service to contain inserts and Updates for SMS to the DB
 */
class MessageService
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $json
     * @return true
     * @throws JsonException
     * @throws DateMalformedStringException
     */
    public function insertSMSJSON(string $json): true
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $smsGroup = [];

        // Loop through each item in JSON and validate the data is in the format expected
        //TODO Provide a feedback system for applications that fail this check
        foreach ($data as $datum) {
            $smsGroup[] =  new SMS(
                $datum['id'],
                $datum['webhook'],
                $datum['recipient'],
                new Staff($datum['sender']),
                new Content($datum['subject'], $datum['message']),
                new Student($datum['extra']['student_id']),
                new DateTime($datum['timestamp']),
                MsgStatusEnum::from($datum['status']),
                $datum['extra']['provider']
            );
        }

        $group = new SMSGroup($smsGroup);
        try {
            return $this->insertSMSMessages($smsGroup);
        } catch (Exception $e) {
            (new Logger)->error($e->getMessage());
        }
    }

    /**
     * @param SMSGroup $group
     * @return true
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     *
     * Actual DB implementation hidden away as a private function as this doesn't need to be visable to anything
     * outside of the class
     */
    private function insertSMSMessages(SMSGroup $group): true
    {
        $pdo = $this->container->get(PDO::class);

        foreach ($group->getGroup() as $sms) {
            if ($sms instanceof SMS) {
                $sql = 'CALL insert_new_message(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

                $errorMsg = '';
                $dbId = 0;

                $stmnt = $pdo->prepare($sql);
                $stmnt->bindValue(1, $sms->getId(), PDO::PARAM_STR);
                $stmnt->bindValue(2, $sms->getWebhookUrl(), PDO::PARAM_STR);
                $stmnt->bindValue(3, $sms->getRecipient(), PDO::PARAM_STR);
                $stmnt->bindValue(4, $sms->getSender()->getId(), PDO::PARAM_INT);
                $stmnt->bindValue(5, $sms->getMessage()->getSubject(), PDO::PARAM_STR);
                $stmnt->bindValue(6, $sms->getMessage()->getMessage(), PDO::PARAM_STR);
                $stmnt->bindValue(7, $sms->getStudent()->getId(), PDO::PARAM_STR);
                $stmnt->bindValue(8, $sms->getProvider(), PDO::PARAM_STR);
                $stmnt->bindValue(9, $sms->getStatus()->getValue(), PDO::PARAM_STR);
                $stmnt->bindValue(10, $dbId, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
                $stmnt->bindValue(11, $errorMsg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);

                $stmnt->execute();
            }
        }
    }
}
