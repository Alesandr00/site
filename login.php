<?php
require 'includes/conexao.php';
session_start();

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario["senha"])) {
        $_SESSION["usuario"] = $usuario["nome"];
        $_SESSION["usuario_id"] = $usuario["id"];
        header("Location: index.php");
        exit;
    } else {
        $erro = "E-mail ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<h1>Login</h1>

<form method="POST">
  <input type="email" name="email" placeholder="E-mail" required><br>
  <input type="password" name="senha" placeholder="Senha" required><br>
  <button type="submit">Entrar</button>
</form>

<?php if ($erro): ?>
  <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
<?php endif; ?>

</body>
</html>
