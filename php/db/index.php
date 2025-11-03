<?php
$pdo = new PDO('sqlite:db/database.sqlite');
$stmt = $pdo->query("SELECT title, url FROM links");
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Links</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Meus Links</h1>
        <ul>
            <?php foreach ($links as $l): ?>
                <li><a href="<?php echo $l['url']; ?>" target="_blank"><?php echo $l['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <a href="login.php">Admin</a>
    </div>
</body>
</html>
