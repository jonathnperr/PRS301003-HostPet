<?php
// =============================================
// Arquivo: editar-fotosambiente.php
// Função: Permite ao cuidador editar as fotos do ambiente
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

// ------------------------------
// 5. Processamento da exclusão de fotos
// ------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_excluir_foto"])) {
    $foto_id_excluir = $_POST["foto_id_excluir"];

    // Verifica se o cuidador realmente possui essa foto antes de excluir
    $sql_verificar_foto = "SELECT * FROM fotos_ambiente WHERE id_foto=$foto_id_excluir AND id_host=$id";
    $result_verificar_foto = $conexao->query($sql_verificar_foto);

    if ($result_verificar_foto->num_rows > 0) {
        $row_verificar_foto = $result_verificar_foto->fetch_assoc();
        $caminho_foto_excluir = $row_verificar_foto['caminho_foto'];

        // Exclui a entrada no banco de dados
        $sql_excluir_foto = "DELETE FROM fotos_ambiente WHERE id_foto=$foto_id_excluir AND id_host=$id";
        $conexao->query($sql_excluir_foto);

        // Exclui o arquivo fisicamente
        unlink("../fotos-local/$caminho_foto_excluir");
    } else {
        echo "Erro: Foto não encontrada ou você não tem permissão para excluí-la.";
    }
}

// ------------------------------
// 6. Processamento do upload de novas fotos
// ------------------------------
if(isset($_POST['submit'])) {
    // Obtém o ID do cuidador
    $cuidador_id = $id;
    
    // Adiciona novas fotos do ambiente se arquivos forem fornecidos
    if (!empty($_FILES["fotos_ambiente"]["name"][0])) {
        foreach ($_FILES["fotos_ambiente"]["tmp_name"] as $key => $tmp_name) {
            $nome_arquivo_ambiente = $_FILES["fotos_ambiente"]["name"][$key];
            move_uploaded_file($tmp_name, '../uploads/fotos-local/' . $nome_arquivo_ambiente);

            $sql_fotos_ambiente = "INSERT INTO fotos_ambiente (id_host, caminho_foto) VALUES ('$cuidador_id', '$nome_arquivo_ambiente')";
            $conexao->query($sql_fotos_ambiente);
        }
    }
    
    header("Location: dashboard.php");
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
        <!-- ===================== EDIÇÃO DE FOTOS DO AMBIENTE ===================== -->
        <div class="titulo-editar-foto-ambiente"></div>
        <br><br>

        <div class="div-formata-ft-ambiente">
            <!-- Exibe as fotos atuais do ambiente -->
            <?php
            $sql_fotos_ambiente = "SELECT * FROM fotos_ambiente WHERE id_host = $id";
            $result_fotos_ambiente = $conexao->query($sql_fotos_ambiente);
            
            if ($result_fotos_ambiente->num_rows > 0) {
                while ($row_fotos_ambiente = $result_fotos_ambiente->fetch_assoc()) {
                    $nome_arquivo_ambiente = $row_fotos_ambiente['caminho_foto'];
                    echo "<img class='fotoambiente' src='../fotos-local/$nome_arquivo_ambiente' alt='Foto do Ambiente'>";
            
                    // Formulário para exclusão de foto
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='foto_id_excluir' value='" . $row_fotos_ambiente['id_foto'] . "'>";
                    echo "<input type='submit' name='submit_excluir_foto' value='Excluir Foto'> <br><br><br>";
                    echo "</form>";
                }
            } else {
                echo "<p>Nenhuma foto do ambiente encontrada.</p>";
            }
            ?>
            
            <!-- Formulário para adicionar novas fotos -->
            <form method="post" action="" enctype="multipart/form-data">
                <label for="fotos_ambiente">Novas Fotos do Ambiente:</label> <br>
                <input type="file" id="fotos_ambiente" name="fotos_ambiente[]" accept="image/*" multiple><br>
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
</body>
</html>