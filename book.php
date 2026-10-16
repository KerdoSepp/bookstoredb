<?php

require "connection.php";

$id = $_GET['id'] ?? null;

$isSuccess = $_GET['update'] ?? null;

$stmt = $pdo->prepare('SELECT id, title, release_date, cover_path, language, summary, price, stock_saldo, pages, type FROM books WHERE id = :id');
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

<?php if ($isSuccess == "success") { ?>

<b style="color:green;">Muudatused salvestatud</b><br><br>

<?php } ?>

<button onclick="window.location.href='index.php'">Back</button>
<h1><?= $book['title'] ?></h1>
<h2>Authors:</h2>
<ul>
    <?php foreach ($authors as $author) { ?>
        <li><?= $author['first_name'] ?> <?= $author['last_name'] ?></li>
    <?php } ?>
</ul>
<img src="<?= $book['cover_path'] ?>">
<p>Release date: <?= $book['release_date'] ?></p>
<p>Language: <?= $book['language'] ?></p>
<p>Summary: <?= $book['summary'] ?></p>
<p>Price: <?= round($book['price'], 2)."€" ?></p>
<p>Stock: <?= $book['stock_saldo'] ?></p>
<p>Pages: <?= $book['pages'] ?></p>
<p>Type: <?= $book['type'] ?></p>
<button onclick="window.location.href='edit.php?id=<?= $book['id'] ?>'">Change</button>
<button>Delete</button>
</body>
</html>
