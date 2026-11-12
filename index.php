<?php

require "connection.php";

$isDeleted = $_GET['delete'] ?? null;

$search = $_GET["search"] ?? "";

if ($search === "") {
    $stmt = $pdo->query(
        "SELECT id, title FROM books WHERE is_deleted = 0"
    );
} else {
    $stmt = $pdo->prepare(
        "SELECT id, title FROM books
         WHERE is_deleted = 0 AND title LIKE :search"
    );

    $stmt->execute(["search" => "%" . $search . "%"]);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<button onclick="window.location.href='author.php'">Authors</button>

<?php if ($isDeleted == "success") { ?>

<b style="color:red;">Book deleted</b><br><br>

<?php } ?>

<form method="get" action="index.php">
    <label for="search">Search book by name:</label>

    <input
        type="search"
        id="search"
        name="search"
        value="<?= $search ?>"
    >

    <button type="submit">Search</button>
</form>


    <ul>
<?php
$found = false;

 while ($book = $stmt->fetch() ) { ?>
    <li>
    <a href="book.php?id=<?= $book['id'] ?>"><?= $book['title'] ?></a>
    </li>
<?php $found = true; } ?>

<?php 
if ($found === false) { ?>
    <p>No books found.</p>
<?php } ?>

    </ul>
</body>
</html>
