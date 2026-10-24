<?php

function createNotification(
    $pdo,
    $userId,
    $title,
    $message
)
{
    // تجهيز أمر الإدخال
    $stmt = $pdo->prepare("
    INSERT INTO notifications
    (
        user_id,
        title,
        message
    )
    VALUES
    (
        ?,
        ?,
        ?
    )
    ");

    // تنفيذ الإدخال
    $stmt->execute([

        $userId,
        $title,
        $message

    ]);
}