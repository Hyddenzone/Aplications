<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$pdo = new PDO('sqlite:db/database.sqlite');


if ($_POST['action'] == 'add') {
    $title = $_POST['title'];
    $url = $_POST['url'];
    
   
    if (!empty($title) && !empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
        $stmt = $pdo->prepare("INSERT INTO links (title, url) VALUES (?, ?)");
        $stmt->execute([$title, $url]);
    }
}


if ($_POST['action'] == 'delete') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM links WHERE id = ?");
    $stmt->execute([$id]);
}


header("Location: admin.php");
exit;
