<?php
    if(isset($_GET['article_id'])) {
        if(is_numeric($_GET['article_id'])) {
            $article_id = intval($_GET['article_id']);
        } else {
            echo "<script> document.location = '/'</script>";
            die();
        }
        $pdo = new PDO("mysql:host=localhost;dbname=MyDrugs", 'read', '');
        $statement = $pdo->prepare("SELECT name FROM articles WHERE id = :id");
        $statement->bindParam(':id', $article_id, PDO::PARAM_INT);
        $statement->execute();
        $article_name = $statement->fetch()[0];

        $statement = $pdo->prepare("SELECT description FROM articles WHERE id = :id");
        $statement->bindParam(':id', $article_id, PDO::PARAM_INT);
        $statement->execute();
        $description = $statement->fetch()[0];

    } else {
        echo "<script> document.location = '/'</script>";
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo $article_name ?> - item page</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="article.css"/>
</head>
<body>
    <h1 id="title"><?php echo $article_name ?></h1>
    <?php
    echo "<img alt=\"Photo of $article_name\" src=\"/getImage.php?id=$article_id\" class=\"article_img\"/>";
    echo $description;
    ?>
</body>
</html>