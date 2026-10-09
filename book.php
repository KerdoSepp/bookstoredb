<?php

require "connection.php";

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare('SELECT id, title, cover_path, price FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('
    SELECT authors.first_name, authors.last_name
    FROM authors
    JOIN book_authors ON authors.id = book_authors.author_id
    WHERE book_authors.book_id = :id
');
$stmt->execute(['id' => $id]);
$authors = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<button onclick="window.location.href='index.php'">Back</button>
<h1><?= $book['title'] ?></h1>
<h2>Authors:</h2>
<ul>
    <?php foreach ($authors as $author) { ?>
        <li><?= $author['first_name'] ?> <?= $author['last_name'] ?></li>
    <?php } ?>
</ul>
<img src="<?= $book['cover_path'] ?>">
<p><?= round($book['price'], 2)."€" ?></p>
<button>Change</button>
<button>Delete</button>
</body>
</html>