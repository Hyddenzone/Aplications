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
        <h1>Meus Links Importantes</h1>
        <ul>
            <?php foreach ($links as $link): ?>
                <li>
                    <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank">
                        <?php echo htmlspecialchars($link['title']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="login.php" class="admin-link">Admin</a>
    </div>
</body>
</html>


