<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "OLESCSUB16"; // se você definiu uma senha, coloque aqui
$dbname = "sporthub"; // substitua pelo nome do seu banco

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recebe os dados do formulário
$nome = $_POST['name'];
$cpf = $_POST['last_name'];
$nascimento = $_POST['birthdate'];
$email = $_POST['email'];
$senha = $_POST['password'];
$confirmarSenha = $_POST['confirm_password'];
$tipo = $_POST['gender'];

// Validação básica (opcional)
if ($senha !== $confirmarSenha) {
    die("Senhas não coincidem.");
}

// Insere no banco
$sql = "INSERT INTO usuarios (nome, cpf_cnpj, nascimento, email, senha, tipo)
        VALUES ('$nome', '$cpf', '$nascimento', '$email', '$senha', '$tipo')";

if ($conn->query($sql) === TRUE) {
    echo "Conta criada com sucesso!";
    // header('Location: ClubesPeneiras.html'); // opcional: redirecionar após salvar
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>