<?php

require "connection.php";

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare('SELECT id, title, release_date, cover_path, language, summary, price, stock_saldo, pages, type FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

//book authors
$stmt = $pdo->prepare('
    SELECT authors.id, authors.first_name, authors.last_name
    FROM authors
    JOIN book_authors ON authors.id = book_authors.author_id
    WHERE book_authors.book_id = :id
');

$stmt->execute(['id' => $id]);
$bookAuthors = $stmt->fetchAll();

// all authors
$stmt = $pdo->query('
    SELECT id, first_name, last_name
    FROM authors
    ORDER BY first_name, last_name
');
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
  <h2>Authors:</h2>
    <h3>Add author:</h3>
        <a for="authors">All authors:</a>
        <form method="post" action="add_author_to_book.php">
          <input type="hidden" name="id" value="<?= $book['id'] ?>">
<select id="authors" name="author">
    <?php foreach ($authors as $author) { ?>
        <option value="<?= $author['id'] ?>"><?= $author['first_name'] . ' ' . $author['last_name'] ?></option>
    <?php } ?>
</select>
        <button type="submit">Add</button>
    </form>
      <h3>Change author:</h3>

    <?php foreach ($bookAuthors as $author) { ?>
    <form method="post" action="delete_author_from_book.php">
        <input type="hidden" name="id" value="<?= $book['id'] ?>">
        <input type="hidden" name="author" value="<?= $author['id'] ?>">

        <?=$author['first_name'] . ' ' . $author['last_name'] ?>

        <button type="submit">Remove</button>
    </form>
<?php } ?>

<form method="post" action="update_book.php">
  <input type="hidden", name="id", value="<?= $book['id'] ?>">
  <h2>Book:</h2>
  <a for="title">Title:</a>
  <input type="text" id="title" name="title" value="<?= $book['title'] ?>"><br><br>
  <a for="release_date">Release date:</a>
  <input type="text" id="release_date" name="release_date" value="<?= $book['release_date'] ?>"><br><br>
    <a for="cover_path">Cover path:</a>
  <input type="text" id="cover_path" name="cover_path" value="<?= $book['cover_path'] ?>"><br><br>
    <a for="language">Language:</a>
  <input type="text" id="language" name="language" value="<?= $book['language'] ?>"><br><br>
    <a for="summary">Summary:</a>
  <input type="text" id="summary" name="summary" value="<?= $book['summary'] ?>"><br><br>
    <a for="price">Price:</a>
  <input type="text" id="price" name="price" value="<?= $book['price'] ?>"><br><br>
    <a for="stock_saldo">Stock saldo:</a>
  <input type="text" id="stock_saldo" name="stock_saldo" value="<?= $book['stock_saldo'] ?>"><br><br>
    <a for="pages">Pages:</a>
  <input type="text" id="pages" name="pages" value="<?= $book['pages'] ?>"><br><br>
  <button type="submit" value="Submit">Submit</button>
</form>

</body>
</html>
