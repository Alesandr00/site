<?php
session_start();
require 'includes/conexao.php';

if (!isset($_SESSION['usuario']) || !isset($_SESSION['carrinho'])) {
    header("Location: index.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$carrinho = $_SESSION['carrinho'];
$total = 0;

// Calcula total
foreach ($carrinho as $produto) {
    $total += $produto['preco'];
}

try {
    // Inicia a transação
    $pdo->beginTransaction();

    // Insere o pedido
    $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, total) VALUES (?, ?)");
    $stmt->execute([$usuario_id, $total]);
    $pedido_id = $pdo->lastInsertId(); // pega o ID do pedido

    // Insere cada item do carrinho
    $stmtItem = $pdo->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, preco) VALUES (?, ?, ?)");
    foreach ($carrinho as $produto) {
        $stmtItem->execute([$pedido_id, $produto['id'], $produto['preco']]);
    }

    // Confirma tudo
    $pdo->commit();

    // Limpa o carrinho
    unset($_SESSION['carrinho']);

    $mensagem = "Pedido finalizado com sucesso!";
} catch (Exception $e) {
    $pdo->rollBack();
    $mensagem = "Erro ao finalizar pedido: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Pedido Finalizado</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<h1><?= htmlspecialchars($mensagem) ?></h1>
<a href="index.php">Voltar para a loja</a>
</body>
</html>
