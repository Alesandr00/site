<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

require 'includes/conexao.php';

$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Minha Loja</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header>
  <h1>Bem-vindo, <?= htmlspecialchars($_SESSION["usuario"]) ?>!</h1>
  <nav>
    <a href="index.php">Início</a>
    <a href="carrinho.php">Carrinho 🛒</a>
    <a href="logout.php">Sair</a>
  </nav>
</header>

<main>
  <h2>Produtos</h2>
  <div class="produtos">
    <?php foreach ($produtos as $produto): ?>
      <div class="produto">
        <img src="imagens/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
        <p>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
        <form method="POST" action="adicionar_carrinho.php">
            <input type="hidden" name="id" value="<?= $produto['id'] ?>">
            <button type="submit">Adicionar ao Carrinho</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
</main>

</body>
</html>
