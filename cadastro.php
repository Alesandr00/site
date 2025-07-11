<?php
require 'includes/conexao.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha]);
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        $erro = "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Cadastro</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<h1>Cadastro</h1>

<form method="POST">
  <input type="text" name="nome" placeholder="Nome" required><br>
  <input type="email" name="email" placeholder="E-mail" required><br>
  <input type="password" name="senha" placeholder="Senha" required><br>
  <button type="submit">Cadastrar</button>
</form>

<?php if ($erro): ?>
  <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
<?php endif; ?>

</body>
</html>
