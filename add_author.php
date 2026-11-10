<?php

require_once "connection.php";

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];

$stmt = $pdo->prepare('
    INSERT INTO authors (first_name, last_name)
    VALUES (:first_name, :last_name)
');

$stmt->execute([
    'first_name' => $first_name,
    'last_name' => $last_name,
]);

header('Location: author.php?add=success');
exit;
