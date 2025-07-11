<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$carrinho = $_SESSION['carrinho'] ?? [];

$total = 0;
foreach ($carrinho as $produto) {
    $total += $produto['preco'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Seu Carrinho</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<h1>Seu Carrinho</h1>
<a href="index.php">Voltar para a loja</a>

<?php if (count($carrinho) === 0): ?>
  <p>Seu carrinho está vazio.</p>
<?php else: ?>
  <ul>
    <?php foreach ($carrinho as $id => $produto): ?>
      <li>
        <?= htmlspecialchars($produto['nome']) ?> - R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
        <a href="remover_carrinho.php?id=<?= $id ?>">Remover</a>
      </li>
    <?php endforeach; ?>
  </ul>

  <hr>
  <p><strong>Total: R$ <?= number_format($total, 2, ',', '.') ?></strong></p>

  <form action="finalizar.php" method="POST">
    <button type="submit">Finalizar Pedido</button>
  </form>
<?php endif; ?>

</body>
</html>
