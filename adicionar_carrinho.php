<?php
session_start();
require 'includes/conexao.php';

if (!isset($_POST['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_POST['id'];

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header("Location: index.php");
    exit;
}

// Adiciona ao carrinho
$_SESSION['carrinho'][$id] = $produto;

header("Location: carrinho.php");
exit;
