<?php
    if(isset($_GET['query'])) {
        $query = $_GET['query'];
    } else {
        $query = '';
    }

    $pdo = new PDO("mysql:host=localhost;dbname=MyDrugs", 'read', '');
    $query = "%$query%";

    $statement = $pdo->prepare("SELECT `id` FROM `articles` WHERE LOWER(`name`) LIKE LOWER(:query) ORDER BY `name` ASC");
    $statement->bindParam(':query', $query, PDO::PARAM_STR);

    if ($statement->execute()) {
        $results = $statement->fetchAll();
    } else {
        echo "Error";
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="search.css"/>
</head>
<body>
<header>
    <h1 id="title">Search</h1>
</header>
<form action="search.php">
    <label for="query">
        <input type="search" placeholder="Search" name="query" id="query">
    </label>
    <input type="submit" value="Search"/>
</form>
<div id="results">
    <?php
        if(0 < count($results)) {
            echo "<ul>";
            foreach($results as $result) {
                $id = intval($result['id']);

                $statement = $pdo->prepare("SELECT `name` FROM `articles` WHERE `id` = :id");
                $statement->bindParam(":id", $id, PDO::PARAM_INT);
                if($statement->execute()) {
                    $name = $statement->fetch()[0];
                } else {
                    die();
                }

                $statement = $pdo->prepare("SELECT `short_description` FROM `articles` WHERE `id` = :id");
                $statement->bindParam(":id", $id, PDO::PARAM_INT);
                if($statement->execute()) {
                    $short_description = $statement->fetch()[0];
                } else {
                    die();
                }

                echo "<li><div class=\"entry\">
    <img alt=\"Photo of $name\" src=\"/getPreviewImage.php?id=$id\" class=\"article_img\"/>
    <span class=\"article_name=\">$name</span>
    <p class=\"short_description\">$short_description</p>
</div>";
            }
            echo "</ul>";
        } else {
            echo "<h2>No results for your query</h2>";
        }
    ?>
</div>
</body>
</html>