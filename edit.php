<?php

require "connection.php";

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare('SELECT id, title, release_date, cover_path, language, summary, price, stock_saldo, pages, type FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('
        UPDATE books
        SET title = :title,
            release_date = :release_date,
            cover_path = :cover_path,
            language = :language,
            summary = :summary,
            price = :price,
            stock_saldo = :stock_saldo,
            pages = :pages
        WHERE id = :id
    ');

    $stmt->execute([
        'title'        => $_POST['title'],
        'release_date' => $_POST['release_date'],
        'cover_path'   => $_POST['cover_path'],
        'language'     => $_POST['language'],
        'summary'      => $_POST['summary'],
        'price'        => $_POST['price'],
        'stock_saldo'  => $_POST['stock_saldo'],
        'pages'        => $_POST['pages'],
        'id'           => $book['id'],
    ]);

header("Refresh:0");

echo "<script type='text/javascript'>alert('Database updated');</script>";
}

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
<button onclick="window.location.href='book.php?id=<?= $book['id'] ?>'">Back</button>
<h1>Id: <?= $book['id'] ?></h1>
<form method="post" action="edit.php?id=<?=$book['id'] ?>">
  <label for="title">Title:</label>
  <input type="text" id="title" name="title" value="<?= $book['title'] ?>"><br><br>
  <label for="release_date">Release date:</label>
  <input type="text" id="release_date" name="release_date" value="<?= $book['release_date'] ?>"><br><br>
    <label for="cover_path">Cover path:</label>
  <input type="text" id="cover_path" name="cover_path" value="<?= $book['cover_path'] ?>"><br><br>
    <label for="language">Language:</label>
  <input type="text" id="language" name="language" value="<?= $book['language'] ?>"><br><br>
    <label for="summary">Summary:</label>
  <input type="text" id="summary" name="summary" value="<?= $book['summary'] ?>"><br><br>
    <label for="price">Price:</label>
  <input type="text" id="price" name="price" value="<?= $book['price'] ?>"><br><br>
    <label for="stock_saldo">Stock saldo:</label>
  <input type="text" id="stock_saldo" name="stock_saldo" value="<?= $book['stock_saldo'] ?>"><br><br>
    <label for="pages">Pages:</label>
  <input type="text" id="pages" name="pages" value="<?= $book['pages'] ?>"><br><br>
  <input type="submit" value="Submit">
</form>
</body>
</html>