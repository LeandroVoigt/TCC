<?php 
session_start();

// Conexão com o banco
$servername = "localhost";
$username = "root";
$password = "OLESCSUB16";
$dbname = "sporthub";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Coleta os dados do formulário
$email = $_POST['email'];
$senha = $_POST['password'];

// Consulta segura usando prepared statement
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    if (password_verify($senha, $usuario['senha'])) {
        // Correção aqui:
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo']; // atleta ou clube

        // Redireciona com base no tipo
        header("Location: ClubesPeneiras.html");
        exit();
    } else {
        echo "<script>alert('Senha incorreta!'); window.history.back();</script>";
        exit();
    }
} else {
    echo "<script>alert('Usuário não encontrado!'); window.history.back();</script>";
    exit();
}

$conn->close();
?>
