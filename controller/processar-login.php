<?php
// =============================================
// Arquivo: processar-login.php
// Função: Processar o login do usuário
// =============================================

// Importa o arquivo de conexão com o banco de dados
include('../includes/conexao.php');

// Inicia a sessão para manipular dados de login
session_start();

// Verifica se o formulário foi enviado via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtém os dados enviados pelo formulário
    $email = $_POST["email"];
    $senha = $_POST["senha"]; 

    // Monta a consulta SQL para buscar o usuário pelo email
    $sql = "SELECT id, nome, email, senha FROM hosts WHERE email = '$email'";
    $resultado = $conexao->query($sql);

    // Verifica se encontrou o usuário
    if ($resultado->num_rows > 0) {
        // Obtém os dados do usuário encontrado
        $row = $resultado->fetch_assoc();

        // Verifica se a senha informada corresponde à senha armazenada no banco
        if (password_verify($senha, $row["senha"])) {
            // Se a senha for correta, armazena o ID do usuário na sessão
            $_SESSION["usuario_id"] = $row["id"];
            header("Location: ../public/dashboard.php");
            exit();
        } else {
            echo "Credenciais inválidas. Tente novamente.";
        }
    } else {
        echo "Credenciais inválidas. Tente novamente.";
    }
}
?>
