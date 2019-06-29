<?php

if(!isset($_GET['id'])) { die(); }
if(!(is_numeric($_GET['id']))) { die(); }
// do some validation here to ensure id is safe

$id = intval($_GET['id']);

$pdo = new PDO("mysql:host=localhost;dbname=MyDrugs", 'read', '');
$statement = $pdo->prepare("SELECT `image` FROM `articles` WHERE `id` = :id");
$statement->bindParam(":id", $id);
if($statement->execute()) {
    $result = $statement->fetch()[0];
} else {
    die();
}

header("Content-type: image/jpeg");
echo $result;
