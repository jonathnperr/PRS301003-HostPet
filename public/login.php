<?php
// =============================================
// Arquivo: login.php
// Página de login para usuários
// =============================================

include('../includes/conexao.php');

// Inicia a sessão para manipulação de dados do usuário
session_start();

// Verifica se o usuário já está logado
// Caso esteja, redireciona para a dashboard
if (isset($_SESSION["usuario_id"])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HostPets</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>

    <!-- ===================== CONTAINER PRINCIPAL ===================== -->
    <div class="div-principal">

        <!-- Logo que redireciona para a página inicial -->
        <a href="index.html">
            <img src="assets/img/logo.png" class="logo" alt="Logo HostPets">
        </a>

        <!-- Título -->
        <h1 class="titulo">Login</h1> 
        <br>

        <!-- ===================== FORMULÁRIO DE LOGIN ===================== -->
        <div class="div-subprincipal">

            <!-- Formulário para autenticação de usuário -->
            <!-- Envia os dados para processar-login.php -->
            <form action="../controller/processar-login.php" method="post">

                <!-- Campo para email -->
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="Digite seu email" 
                    required
                >

                <!-- Campo para senha -->
                <input 
                    type="password" 
                    id="senha" 
                    name="senha" 
                    placeholder="Digite sua senha" 
                    required
                >

                <!-- Botão de envio -->
                <input type="submit" value="Entrar"> 
                <br>
            </form>

            <!-- Link para página de cadastro -->
            <label>Ainda não é cadastrado?</label> 
            <br>
            <a href="cadastro-host0.php">Cadastre-se</a>

        </div>
    </div>

</body>
</html>
