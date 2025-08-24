<?php
// =============================================
// Arquivo: editar-fotoperfil.php
// Função: Permite ao cuidador editar sua foto de perfil
// =============================================

include('../includes/conexao.php');

// ------------------------------
// 1. Verifica se o usuário está logado
// ------------------------------
session_start();
if (!isset($_SESSION["usuario_id"])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: login.php");
    exit();
}

// ------------------------------
// 2. Logout
// ------------------------------
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// ------------------------------
// 3. Pega o ID do usuário logado
// ------------------------------
$id = $_SESSION['usuario_id'];

// ------------------------------
// 4. Consulta dados do cuidador
// ------------------------------
$sql = "SELECT * FROM hosts WHERE id = $id";
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$foto_perfil = $row["foto_perfil"];

// ------------------------------
// 5. Processamento do upload da nova foto
// ------------------------------
if(isset($_POST['submit'])) {
    // Verifica se o upload de foto de perfil foi bem-sucedido
    if ($_FILES["foto_perfil"]["error"] == UPLOAD_ERR_OK) {
        $nome_arquivo_perfil = $_FILES["foto_perfil"]["name"];
        move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], '../uploads/fotos-perfil/' . $nome_arquivo_perfil);
    } else {
        $nome_arquivo_perfil = null;
    }

    // Atualiza a foto de perfil no banco de dados
    $update_sql = "UPDATE hosts SET foto_perfil='$nome_arquivo_perfil' WHERE id=$id";

    if ($conexao->query($update_sql) === TRUE) {
        header("Location: dashboard.php");
    } else {
        echo "Erro ao atualizar dados: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>
    <!-- ===================== CABEÇALHO ===================== -->
    <header>
        <h1> 
            <div class="cabeçalho"> 
                <!-- Logo -->
                <a href="index.html">
                    <img src="assets/img/logo.png" class="logo">
                </a>

                <!-- Menu -->
                <a href="#" class="menu"> Como Funciona </a> 
                <a href="#" class="menu"> Quem Somos </a>

                <!-- Botões -->
                <div class="botoes-cabecalho">
                    <form action="editar-conta.php" method="post">
                        <input type="submit" value="Conta" class="botao-form">
                    </form>
                    <form method="post">
                        <input type="submit" name="logout" value="Sair" class="botao-form">
                    </form>
                </div>
            </div>
        </h1>
    </header> 

    <main>
        <!-- ===================== FORMULÁRIO DE EDIÇÃO DE FOTO ===================== -->
        <div class="titulo-editar-foto-perfil"></div>
        <br><br><br>

        <div class="div-formata-ft-perfil">
            <!-- Formulário para upload de nova foto -->
            <form method="post" action="" enctype="multipart/form-data">
                <!-- Exibe a foto atual -->
                <p><strong>Foto de perfil atual:</strong> <br>
                <img src="../uploads/fotos-perfil/<?php echo $foto_perfil; ?>" alt="Foto de Perfil" class="fotoperfil"></p>

                <!-- Campo para selecionar nova foto -->
                <label for="foto_perfil">Altere a foto de perfil inserindo um novo arquivo:</label> <br><br>
                <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*"><br>

                <!-- Botão de submit -->
                <button name="submit"> Atualizar </button>
            </form>
        </div>

        <br>
        <!-- Botão para voltar ao dashboard -->
        <a href="dashboard.php">
            <button class="botao-voltar">Voltar</button>
        </a> <br>
    </main>

    <!-- ===================== RODAPÉ ===================== -->
    <footer>
        <img src="assets/img/logo-ifsc-preta.png" class="logo-ifsc">
        <p>Instituto Federal de Educação, Ciência e Tecnologia de Santa Catarina IFSC</p>
        <p>&copy; 2023 HostPet</p>
    </footer>

    <script type="text/javascript" src="assets/js/ufcidade.js"></script>
</body>
</html>