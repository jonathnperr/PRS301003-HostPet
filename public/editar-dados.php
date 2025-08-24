<?php
// =============================================
// Arquivo: editar-dados.php
// Função: Permite ao host editar seus dados
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
// 5. Processamento do formulário de edição
// ------------------------------
if(isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $descricao = $_POST['descricao'];
    $preco_por_dia = $_POST["preco_por_dia"];
    $pets_que_aceita = implode(",", $_POST["pets_que_aceita"]);
    $telefone = $_POST['telefone'];

    // Atualiza os dados no banco de dados
    $update_sql = "UPDATE hosts SET nome='$nome', email='$email', estado='$estado', cidade='$cidade', bairro='$bairro', descricao='$descricao', preco_cobrado_por_dia='$preco_por_dia', pets_que_aceita='$pets_que_aceita', telefone='$telefone' WHERE id=$id";

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
        <!-- ===================== FORMULÁRIO DE EDIÇÃO ===================== -->
        <div class="titulo-editar-perfil"></div>
        <br><br><br>

        <div class="div-formata-dados">
            <!-- Foto de perfil -->
            <p><strong>Foto de Perfil:</strong> <br>
            <img src="../uploads/fotos-perfil/<?php echo $foto_perfil; ?>" alt="Foto de Perfil" class="fotoperfil"></p>

            <!-- Botão para editar foto de perfil -->
            <a href="editar-fotoperfil.php">
                <button>Editar foto de perfil</button>
            </a> <br><br><br>

            <!-- Formulário de edição de dados -->
            <form method="post" action="" enctype="multipart/form-data">
                <p><strong>Nome:</strong> </p><input type="text" name="nome" value="<?php echo $row['nome']; ?>" required><br>

                <p><strong>Email: </strong></p><input type="text" name="email" value="<?php echo $row['email']; ?>" required><br>

                <label for="estado"><p><strong>Estado:</strong></p></label>
                <select id="uf" name="estado" required>
                    <option><?php echo $row['estado']; ?></option>
                </select><br>

                <label for="cidade"><p><strong>Cidade:</strong></p></label>
                <select id="cidade" name="cidade" required>
                    <option><?php echo $row['cidade']; ?></option>
                </select><br>
                
                <p><strong>Bairro: </strong></p><input type="text" name="bairro" value="<?php echo $row['bairro']; ?>" required><br>

                <p><strong>Telefone: </strong></p><input type="text" name="telefone" value="<?php echo $row['telefone']; ?>"><br>

                <label for="preco_por_dia"><p><strong>Novo Preço por Dia:</strong></p></label>
                <input type="number" id="preco_por_dia" name="preco_por_dia" min="0" step="0.01" value="<?php echo $row['preco_cobrado_por_dia']; ?>" required><br>

                <label><p><strong>Pets que aceita:</strong></p></label>
                <input type="checkbox" id="gato" name="pets_que_aceita[]" value="gato" <?php if (in_array('gato', explode(',', $row['pets_que_aceita']))) echo 'checked'; ?>>
                <label for="gato"> Gato </label> <br>

                <input type="checkbox" id="cachorro" name="pets_que_aceita[]" value="cachorro" <?php if (in_array('cachorro', explode(',', $row['pets_que_aceita']))) echo 'checked'; ?>>
                <label for="cachorro">Cachorro</label><br>

                <input type="checkbox" id="coelho" name="pets_que_aceita[]" value="coelho" <?php if (in_array('coelho', explode(',', $row['pets_que_aceita']))) echo 'checked'; ?>>
                <label for="coelho">Coelho</label><br>

                <input type="checkbox" id="hamster" name="pets_que_aceita[]" value="hamster" <?php if (in_array('hamster', explode(',', $row['pets_que_aceita']))) echo 'checked'; ?>>
                <label for="hamster">Hamster</label><br>

                <input type="checkbox" id="porquinho_da_india" name="pets_que_aceita[]" value="porquinho_da_india" <?php if (in_array('porquinho_da_india', explode(',', $row['pets_que_aceita']))) echo 'checked'; ?>>
                <label for="porquinho_da_india">Porquinho da índia</label><br>

                <input type="checkbox" id="chinchila" name="pets_que_aceita[]" value="chinchila" <?php if (in_array('chinchila', explode(',', $row['pets_que_aceita']))) echo 'checked'; ?>>
                <label for="chinchila">Chinchila</label><br>

                <input type="checkbox" id="passaros" name="pets_que_aceita[]" value="passaros" <?php if (in_array('passaros', explode(',', $row['pets_que_aceita']))) echo 'checked'; ?>>
                <label for="passaros">Pássaros</label> <br><br>

                <strong>Descrição: </strong><br><textarea name="descricao"><?php echo $row['descricao']; ?></textarea required><br><br>

                <button name="submit"> Atualizar </button>
            </form>

            <!-- Botão para editar fotos do ambiente -->
            <form action="editar-fotosambiente.php" method="post">
                <input type="submit" value="Editar fotos do ambiente">
            </form>
        </div>

        <!-- Botão para voltar para o dashboard -->
        <a href="dashboard.php">
            <button class="botao-voltar">Voltar</button>
        </a>
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