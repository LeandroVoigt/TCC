<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION['id'];

    $nome = $_POST['nome_clube'];
    $escudo = $_POST['escudo_url'];
    $bio = $_POST['biografia'];
    $competicoes = $_POST['competicoes'];
    $peneiras = $_POST['peneiras'];
    $estadios = $_POST['estadios'];
    $fotos = $_POST['fotos'];
    $email = $_POST['email_contato'];
    $site = $_POST['site_contato'];
    $instagram = $_POST['instagram_contato'];

    $sql = "INSERT INTO perfil_clube 
            (id_usuario, nome_clube, escudo_url, biografia, competicoes, peneiras, estadios, fotos, email_contato, site_contato, instagram_contato)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_usuario, $nome, $escudo, $bio, $competicoes, $peneiras, $estadios, $fotos, $email, $site, $instagram]);

    header("Location: visualizar_perfil.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Perfil do Clube</title>
    <link rel="stylesheet" href="SantaHub.css">
</head>
<body>
    <h2>Criar Perfil do Clube</h2>
    <form method="POST" action="criar_perfil.php">
        <input type="text" name="nome_clube" placeholder="Nome do Clube" required><br>
        <input type="text" name="escudo_url" placeholder="URL do Escudo"><br>
        <textarea name="biografia" placeholder="Biografia / Frase de efeito" required></textarea><br>
        <textarea name="competicoes" placeholder="Competições (separadas por vírgula)"></textarea><br>
        <textarea name="peneiras" placeholder="Peneiras (formato livre)"></textarea><br>
        <textarea name="estadios" placeholder="Estádios"></textarea><br>
        <textarea name="fotos" placeholder="URLs das fotos separadas por vírgula"></textarea><br>
        <input type="email" name="email_contato" placeholder="Email"><br>
        <input type="text" name="site_contato" placeholder="Site"><br>
        <input type="text" name="instagram_contato" placeholder="Instagram"><br>
        <button type="submit">Salvar Perfil</button>
    </form>
</body>
</html>