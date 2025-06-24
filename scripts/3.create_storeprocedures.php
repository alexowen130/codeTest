<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$containerBuilder = new ContainerBuilder();
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);
$container = $containerBuilder->build();

/** @var PDO $pdo */
$pdo = $container->get(PDO::class);

// First drop procedure if exists
$pdo->exec("DROP PROCEDURE IF EXISTS insert_new_message");

// Now create procedure without using DELIMITER
$sql = "
CREATE PROCEDURE insert_new_message(
    IN p_uniqueId VARCHAR(100),
    IN p_webhook VARCHAR(256),
    IN p_recipient VARCHAR(100),
    IN p_senderId INT,
    IN p_subject VARCHAR(256),
    IN p_message VARCHAR(256),
    IN p_studentReference VARCHAR(100),
    IN p_providerName VARCHAR(100),
    IN p_status VARCHAR(20),
    OUT dbId INT,
    OUT errorMsg VARCHAR(255)
)
main_block: BEGIN
    DECLARE v_provider_id INT DEFAULT NULL;
    DECLARE v_sender_id INT DEFAULT NULL;
    DECLARE v_student_id INT DEFAULT NULL;
    DECLARE v_webhook_id INT DEFAULT NULL;
    DECLARE v_status_id INT DEFAULT NULL;

    IF EXISTS (SELECT 1 FROM message WHERE uniqueId = p_uniqueId) THEN
        SET errorMsg = 'Duplicate message';
        SET dbId = NULL;
        LEAVE main_block;
    END IF;

    -- Provider
    SELECT id INTO v_provider_id FROM provider WHERE name = p_providerName LIMIT 1;
    IF ROW_COUNT() = 0 THEN
        INSERT INTO provider (name) VALUES (p_providerName);
        SET v_provider_id = LAST_INSERT_ID();
    END IF;

    -- Sender
    SELECT id INTO v_sender_id FROM sender WHERE senderId = p_senderId LIMIT 1;
    IF ROW_COUNT() = 0 THEN
        INSERT INTO sender (senderId) VALUES (p_senderId);
        SET v_sender_id = LAST_INSERT_ID();
    END IF;

    -- Student
    SELECT id INTO v_student_id FROM student WHERE studentReference = p_studentReference LIMIT 1;
    IF ROW_COUNT() = 0 THEN
        INSERT INTO student (studentReference) VALUES (p_studentReference);
        SET v_student_id = LAST_INSERT_ID();
    END IF;

    -- Webhook
    SELECT id INTO v_webhook_id FROM webhook WHERE webhook = p_webhook LIMIT 1;
    IF ROW_COUNT() = 0 THEN
        INSERT INTO webhook (webhook) VALUES (p_webhook);
        SET v_webhook_id = LAST_INSERT_ID();
    END IF;

    -- Status
    SELECT id INTO v_status_id FROM status WHERE status = p_status LIMIT 1;
    IF ROW_COUNT() = 0 THEN
        INSERT INTO status (status) VALUES (p_status);
        SET v_status_id = LAST_INSERT_ID();
    END IF;

    -- Insert message
    INSERT INTO message (
        uniqueId, webhook, recipient, sender, subject, message, studentId, provider, status
    ) VALUES (
        p_uniqueId, v_webhook_id, p_recipient, v_sender_id, p_subject, p_message, v_student_id, v_provider_id, v_status_id
    );

    SET dbId = LAST_INSERT_ID();
    SET errorMsg = NULL;
END
";

// Now prepare statement and execute
try {
    $pdo->exec($sql);
    echo "Stored procedure created successfully!\n";
} catch (PDOException $e) {
    echo "Error creating stored procedure: " . $e->getMessage() . "\n";
}
