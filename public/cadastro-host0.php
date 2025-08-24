<?php
// =============================================
// Arquivo: cadastro-host0.php
// Função: Página inicial de cadastro antes de redirecionar
//         para o formulário de cadastro do host.
// =============================================

include('../includes/conexao.php');
?>

<!DOCTYPE html> 
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="assets/css/cadastro-host.css">
</head>

<body>

    <!-- ===================== CABEÇALHO ===================== -->
    <header>
        <h1> 
            <div class="cabeçalho"> 
                <!-- Logo que redireciona para a página inicial -->
                <a href="index.html">
                    <img src="assets/img/logo.png" class="logo">
                </a>

                <!-- Links de navegação -->
                <a href="#" class="menu"> Como Funciona </a> 
                <a href="#" class="menu"> Quem Somos </a>
            </div>
        </h1>
    </header> 

    <!-- ===================== CONTEÚDO PRINCIPAL ===================== -->
    <main class="main-cadastro0">
        <div class="cadastro0">
            <!-- Imagem ilustrativa -->
            <img src="assets/img/cadastro0.png" alt="">
            
            <!-- Botão que redireciona para a página de cadastro -->
            <a href="cadastro-host.php">
                <button class="botao-voltar">Continuar</button>
            </a>
        </div>
    </main>

    <!-- ===================== RODAPÉ ===================== -->
    <footer>
        <img src="assets/img/logo-ifsc.png" class="logo-ifsc">
        <p>Instituto Federal de Educação, Ciência e Tecnologia de Santa Catarina IFSC</p>
        <p>&copy; 2023 HostPet</p>
    </footer>

</body>
</html>
