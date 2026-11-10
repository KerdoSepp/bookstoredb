<?php

$isSuccess = $_GET['add'] ?? null;

?>


<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<button onclick="window.location.href='index.php'">Back</button>

<h1>Create author</h1>

<?php if ($isSuccess === 'success') { ?>
    <p role="status" style="color:green;">Author created successfully.</p>
<?php } ?>

<form method="post" action="add_author.php">
  <label for="first_name">First Name:</label>
  <input type="text" id="first_name" name="first_name" maxlength="45" required><br><br>
  <label for="last_name">Last Name:</label>
  <input type="text" id="last_name" name="last_name" maxlength="45" required><br><br>
  <button type="submit">Create author</button>
</form>

</body>
</html>
