<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    die("Usuário não autenticado.");
}

include 'conexao.php'; // conecta ao banco

$id_usuario = $_SESSION['id']; // id do clube logado

$sql = "SELECT * FROM clubes WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $id_usuario]);

if ($stmt->rowCount() > 0) {
    // Perfil já existe: redireciona para visualização
    header("Location: visualizar_perfil.php");
} else {
    // Perfil ainda não existe: redireciona para criar
    header("Location: criar_perfil.php");
}
exit;
?>