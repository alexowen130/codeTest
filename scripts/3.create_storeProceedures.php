<?php
// scripts/create_db.php

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

$sql = <<<SQL
CREATE PROCEDURE insertNewMessage(
    IN mesageId VARCHAR(255),
    IN webhookUrl VARCHAR(255),
    IN recipient VARCHAR(255),
    IN sender VARCHAR(255),
    IN subject VARCHAR(255),
    IN message VARCHAR(255),
    IN timestamp TIMESTAMP
    IN studentId VARCHAR(255),
    IN providerId VARCHAR(255),
    IN status VARCHAR(255),
    OUT dbId INT,
    OUT errorMsg VARCHAR(255)
)
    BEGIN
      INSERT INTO message (
        uniqueId,
        webhook,
        recipient,
        sender,
        subject,
        message,
        studentId,
        provider,
        status
    ) VALUES (
        p_uniqueId,
        p_webhook,
        p_recipient,
        p_sender,
        p_subject,
        p_message,
        p_studentId,
        p_provider,
        p_status
    );

    SET p_id = LAST_INSERT_ID();
    END
SQL;;

$pdo->exec($sql);

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS sender (
    id INT AUTO_INCREMENT PRIMARY KEY,
    senderId INT
) ENGINE=InnoDB
SQL;

$pdo->exec($sql);

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    studentReference VARCHAR(100)
) ENGINE=InnoDB
SQL;

$pdo->exec($sql);

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS webhook (
    id INT AUTO_INCREMENT PRIMARY KEY,
    webhook VARCHAR(256)
) ENGINE=InnoDB
SQL;

$pdo->exec($sql);

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(20)
) ENGINE=InnoDB
SQL;

$pdo->exec($sql);

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uniqueId VARCHAR(100),
    webhook INT,
    recipient VARCHAR(100),
    sender INT,
    subject VARCHAR(256),
    message VARCHAR(256),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    studentId INT,
    provider INT,
    status INT,
    CONSTRAINT fk_provider FOREIGN KEY (provider) REFERENCES provider(id)
        ON UPDATE CASCADE,
    CONSTRAINT fk_sender FOREIGN KEY (sender) REFERENCES sender(id)
        ON UPDATE CASCADE,
    CONSTRAINT fk_student FOREIGN KEY (studentId) REFERENCES student(id)
        ON UPDATE CASCADE,
    CONSTRAINT fk_webhook FOREIGN KEY (webhook) REFERENCES webhook(id)
        ON UPDATE CASCADE,
    CONSTRAINT fk_status FOREIGN KEY (status) REFERENCES status(id)
        ON UPDATE CASCADE
) ENGINE=InnoDB
SQL;

$pdo->exec($sql);

echo "Database schema created!\n";

