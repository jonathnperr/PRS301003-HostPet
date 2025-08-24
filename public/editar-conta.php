<?php
// =============================================
// Arquivo: editar-conta.php
// Função: Página que permite que host configure a sua conta, com opçoes de alterar senha, 
// alterar email e deletar conta
// =============================================
include('../includes/conexao.php');
session_start();

/* 
-------------------------------------------------------
  VERIFICAÇÃO DE LOGIN
-------------------------------------------------------
*/
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

/* 
-------------------------------------------------------
  LOGOUT
-------------------------------------------------------
Se o botão logout for pressionado, destrói a sessão e redireciona para a página de login.
*/
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

/* 
-------------------------------------------------------
  RECUPERA DADOS DO HOST
-------------------------------------------------------
Busca as informações do host logado, inclusive foto de perfil.
*/
$id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM hosts WHERE id = $id";
$result = $conexao->query($sql);
$row = $result->fetch_assoc();

$foto_perfil = $row["foto_perfil"];

/* 
-------------------------------------------------------
  ATUALIZAÇÃO DO EMAIL
-------------------------------------------------------
Se o formulário de atualizar email for enviado, 
executa a atualização no banco.
*/
if (isset($_POST["atualizar_email"])) {
    // Alerta de confirmação (pode ser melhor implementado com JS)
    echo "<script>
            var confirmacao = confirm('Tem certeza de que deseja atualizar o e-mail?');
            if (!confirmacao) {
                window.location.href = 'http://localhost:8888/HostPet/dashboard/dashboard.php';
            }
          </script>";

    $novo_email = $_POST["novo_email"];
    $update_email_sql = "UPDATE hosts SET email = '$novo_email' WHERE id = $id";
    $conexao->query($update_email_sql);
    // Pode redirecionar após atualizar, se desejar
    // header("Location: http://localhost:8888/HostPet/dashboard/dashboard.php");
}

/* 
-------------------------------------------------------
  ATUALIZAÇÃO DE SENHA
-------------------------------------------------------
Se o formulário de atualizar senha for enviado, verifica confirmação e atualiza a senha no banco.
*/
if (isset($_POST["atualizar_senha"])) {
    $nova_senha = $_POST["nova_senha"];
    $confirma_nova_senha = $_POST["confirma_nova_senha"];

    if ($nova_senha != $confirma_nova_senha) {
        echo "<script>
                alert('A confirmação da senha não corresponde à nova senha. Por favor, tente novamente.');
                window.location.href = 'http://localhost:8888/HostPet/dashboard/dashboard.php';
             </script>";
    } else {
        $senha_criptografada = password_hash($nova_senha, PASSWORD_DEFAULT);
        $update_senha_sql = "UPDATE hosts SET senha = '$senha_criptografada' WHERE id = $id";
        $conexao->query($update_senha_sql);
    }
}

/* 
-------------------------------------------------------
  EXCLUSÃO DE CONTA
-------------------------------------------------------
Se o formulário de excluir conta for enviado, remove o host do banco e encerra a sessão.
*/
if (isset($_POST["excluir_conta"])) {
    // TODO: Adicionar confirmação e validações extras
    $delete_conta_sql = "DELETE FROM hosts WHERE id = $id";
    $conexao->query($delete_conta_sql);
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Conta - HostPet</title>
    <link rel="stylesheet" href="assets/css/dashboard.css" />
</head>
<body>

    <!-- ================= CABEÇALHO ================= -->
    <header>
        <h1>
            <div class="cabeçalho">
                <a href="index.html">
                    <img src="assets/img/logo.png" class="logo" />
                </a>
                <a href="#" class="menu"> Como Funciona </a>
                <a href="#" class="menu"> Quem Somos </a>

                <div class="botoes-cabecalho">
                    <form action="editar-conta.php" method="post">
                        <input type="submit" value="Conta" class="botao-form" />
                    </form>
                    <form method="post">
                        <input type="submit" name="logout" value="Sair" class="botao-form" />
                    </form>
                </div>
            </div>
        </h1>
    </header>

    <!-- ================= CONTEÚDO PRINCIPAL ================= -->
    <main>
        <div class="titulo-editar-conta"></div>

        <!-- Imagem de perfil (descomentado, se quiser usar) -->
        <!-- <p><strong>Foto de Perfil:</strong><br>
            <img src="../uploads/fotos-perfil/<?php //echo $foto_perfil; ?>" alt="Foto de Perfil" class="fotoperfil" />
        </p> -->

        <form method="post" action="" enctype="multipart/form-data">
            <div class="div-formata-conta">
                <br /><br />

                <!-- Atualizar Email -->
                <p><strong>Atualizar e-mail:</strong><br /><br />
                    <input type="email" id="novo_email" name="novo_email" placeholder="Digite seu novo email" />
                    <button name="atualizar_email">Atualizar Email</button>
                    <br /><br /><br />
                </p>

                <!-- Atualizar Senha -->
                <p><strong>Atualizar senha:</strong><br /><br />
                    <input type="password" id="nova_senha" name="nova_senha" placeholder="Digite sua nova senha" /><br />
                    <input type="password" id="confirma_nova_senha" name="confirma_nova_senha" placeholder="Confirme sua nova senha" />
                    <button name="atualizar_senha">Atualizar Senha</button>
                    <br /><br /><br />
                </p>

                <!-- Excluir Conta -->
                <p><strong>Excluir conta:</strong><br /><br />
                    <button name="excluir_conta" class="excluirconta" onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.');">
                        Excluir Conta
                    </button>
                </p>
            </div>
        </form>

        <!-- Botão para voltar para dashboard -->
        <a href="dashboard.php">
            <button class="botao-voltar">Voltar</button>
        </a>
    </main>

    <!-- ================= RODAPÉ ================= -->
    <footer>
        <img src="assets/img/logo-ifsc-preta.png" class="logo-ifsc" />
        <p>Instituto Federal de Educação, Ciência e Tecnologia de Santa Catarina IFSC</p>
        <p>&copy; 2023 HostPet</p>
    </footer>

    <script type="text/javascript" src="assets/js/ufcidade.js"></script>
</body>
</html>
