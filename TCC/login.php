<?php
session_start();

// Conexão com o banco
$servername = "localhost";
$username = "root";
$password = "OLESCSUB16"; // sua senha do MySQL
$dbname = "sporthub";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Coleta os dados do formulário
$email = $_POST['email'];
$senha = $_POST['password'];

// Consulta ao banco
$sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    
    // Salva dados na sessão
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['usuario_tipo'] = $usuario['tipo']; // atleta ou clube

    // Redireciona com base no tipo
    if ($usuario['tipo'] === 'clube') {
        header("Location: perfil.html");
    } else {
        header("Location: ClubesPeneiras.html");
    }
    exit();
} else {
    echo "<script>alert('Email ou senha inválidos!'); window.history.back();</script>";
    exit();
}

$conn->close();
?>