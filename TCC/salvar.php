<?php  
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "OLESCSUB16"; // sua senha do MySQL
$dbname = "sporthub";

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
$tipo = $_POST['gender']; // 'atleta' ou 'clube'

// Validação de senha
if ($senha !== $confirmarSenha) {
    echo "<script>alert('Senhas não coincidem!'); window.history.back();</script>";
    exit();
}

// Insere os dados no banco
$sql = "INSERT INTO usuarios (nome, cpf_cnpj, nascimento, email, senha, tipo)
        VALUES ('$nome', '$cpf', '$nascimento', '$email', '$senha', '$tipo')";

if ($conn->query($sql) === TRUE) {
    // Redireciona para a mesma página para todos os tipos
    echo "<script>
            alert('Cadastro realizado com sucesso!');
            window.location.href = 'sportHub.html';
          </script>";
    exit();
} else {
    echo "<script>alert('Erro ao cadastrar: " . $conn->error . "'); window.history.back();</script>";
}

$conn->close();
?>