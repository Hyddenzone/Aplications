<?php
session_start(); 

$pdo = new PDO('sqlite:db/database.sqlite');
$login_error = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['username'];
        header("Location: admin.php"); 
        exit;
    } else {
        $login_error = "Usuário ou senha inválidos!";
    }
}


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  
    echo "<h1>Login</h1>";
    if ($login_error) echo "<p style='color:red;'>$login_error</p>";
    echo "<form method='post'><input name='username' placeholder='Usuário'><input type='password' name='password' placeholder='Senha'><button type='submit'>Entrar</button></form>";
    exit; 
}


$stmt = $pdo->query("SELECT * FROM links");
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h1>Painel de Administração</h1>
<p>Olá, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="logout.php">Sair</a></p>

<h2>Adicionar Novo Link</h2>
<form action="processar_link.php" method="post">
    <input type="hidden" name="action" value="add">
    <input type="text" name="title" placeholder="Título do Link" required>
    <input type="url" name="url" placeholder="URL completa" required>
    <button type="submit">Adicionar</button>
</form>

<h2>Gerenciar Links</h2>
<table>
    <?php foreach ($links as $link): ?>
    <tr>
        <td><?php echo htmlspecialchars($link['title']); ?></td>
        <td>
            <form action="processar_link.php" method="post" style="display:inline;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo $link['id']; ?>">
                <button type="submit">Deletar</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
