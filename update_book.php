<?php

require "connection.php";

 $id = $_POST['id'] ?? null;

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
        'id'           =>  $id,
]);

header("Location: book.php?id=$id&update=success");