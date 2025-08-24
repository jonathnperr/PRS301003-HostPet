<?php
// =============================================
// Arquivo: editar-agenda.php
// Função: Página que permite que host edite os horários da sua agenda
// =============================================
include('../includes/conexao.php');
session_start();

/* 
-------------------------------------------------------
  VERIFICAÇÃO DE LOGIN
-------------------------------------------------------
Se o usuário não estiver logado (sem 'usuario_id' na sessão), redireciona para a página de login.
*/
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

// ID do usuário logado (host/cuidador)
$id_host = $_SESSION['usuario_id'];

/* 
-------------------------------------------------------
  RECUPERA DADOS DO HOST
-------------------------------------------------------
*/
$sql = "SELECT * FROM hosts WHERE id = $id_host";
$result = $conexao->query($sql);
$row = $result->fetch_assoc();

/* 
-------------------------------------------------------
  FUNÇÃO DE FORMATAÇÃO DE DATA
-------------------------------------------------------
Converte a data no formato MySQL (YYYY-MM-DD) 
para o formato brasileiro (DD/MM/YYYY).
*/
function formatarData($data) {
    return date("d/m/Y", strtotime($data));
}

/* 
-------------------------------------------------------
  INSERÇÃO DE AGENDAMENTO
-------------------------------------------------------
Se o formulário de inserção de agenda foi enviado, 
captura os dados e insere na tabela 'agendamentos'.
*/
if (isset($_POST['submit-agenda'])) {
    $data_inicio = $_POST["data_inicio"];
    $data_fim = $_POST["data_fim"];
    $informacoes = $_POST["informacoes"];

    $sql_inserir = "INSERT INTO agendamentos (id_host, data_inicio, data_fim, informacoes) 
                    VALUES ($id_host, '$data_inicio', '$data_fim', '$informacoes')";
    $conexao->query($sql_inserir);
}

/* 
-------------------------------------------------------
  ALTERAÇÃO DE AGENDAMENTO
-------------------------------------------------------
Se o formulário de edição foi enviado, 
atualiza os dados do agendamento específico.
*/
if (isset($_POST['submit-editar'])) {
    $id_agendamento_editar = $_POST["id_agendamento_editar"];
    $data_inicio_editar = $_POST["data_inicio_editar"];
    $data_fim_editar = $_POST["data_fim_editar"];
    $informacoes_editar = $_POST["informacoes_editar"];

    $sql_atualizar = "UPDATE agendamentos 
                      SET data_inicio='$data_inicio_editar', 
                          data_fim='$data_fim_editar', 
                          informacoes='$informacoes_editar' 
                      WHERE id_agendamento=$id_agendamento_editar 
                      AND id_host=$id_host";
    $conexao->query($sql_atualizar);
}

/* 
-------------------------------------------------------
  EXCLUSÃO DE AGENDAMENTO
-------------------------------------------------------
Se o formulário de exclusão foi enviado, 
remove o agendamento do banco.
*/
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_excluir"])) {
    $id_agendamento_excluir = $_POST["id_agendamento_excluir"];

    $sql_excluir = "DELETE FROM agendamentos 
                    WHERE id_agendamento=$id_agendamento_excluir 
                    AND id_host=$id_host";
    $conexao->query($sql_excluir);
}

/* 
-------------------------------------------------------
  CONSULTA DE AGENDAMENTOS DO HOST
-------------------------------------------------------
Recupera todos os agendamentos cadastrados 
para o host logado.
*/
$sql_agendamentos = "SELECT * FROM agendamentos WHERE id_host=$id_host";
$result_agendamentos = $conexao->query($sql_agendamentos);
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

    <!-- ================= CABEÇALHO ================= -->
    <header>
        <h1> 
            <div class="cabeçalho"> 
                <a href="index.html">
                    <img src="assets/img/logo.png" class="logo">
                </a>
                <a href="#" class="menu"> Como Funciona </a> 
                <a href="#" class="menu"> Quem Somos </a>

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

    <!-- ================= CONTEÚDO PRINCIPAL ================= -->
    <main>
        <div class="titulo-editar-agenda"></div>
        <br><br><br>

        <div class="div-formata-agenda">

            <!-- Formulário de Inserção de Agendamento -->
            <h2>Inserir Agendamento</h2>
            <form method="post" action="">
                <label for="data_inicio">De:</label>
                <input type="date" id="data_inicio" name="data_inicio" required> <br>

                <label for="data_fim">Até:</label>
                <input type="date" id="data_fim" name="data_fim" required> <br>

                <input type="text" id="informacoes" name="informacoes" placeholder="Insira informações">
                <button name="submit-agenda"> Inserir agendamento </button>
            </form>
            <br><br>

            <!-- Lista de Agendamentos -->
            <h2>Meus Agendamentos</h2>
            <?php
            if ($result_agendamentos->num_rows > 0) {
                while ($row = $result_agendamentos->fetch_assoc()) {
                    echo "<div class='cada-agendamento-editar'>";

                    // Formulário de exclusão
                    echo "<br><form method='post' action=''>";
                    echo "<input type='hidden' name='id_agendamento_excluir' value='" . $row['id_agendamento'] . "'>";
                    echo "<p>ID do Agendamento: " . $row['id_agendamento'] . "</p>";
                    echo "<p>Data de Início: " . formatarData($row['data_inicio']) . "</p>";
                    echo "<p>Data de Término: " . formatarData($row['data_fim']) . "</p>";
                    echo "<p>Informações: " . $row['informacoes'] . "</p>";
                    echo "<input type='submit' name='submit_excluir' value='Excluir' class='botao-excluir-agenda'> <br>";
                    echo "</form>";

                    // Formulário de edição
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='id_agendamento_editar' value='" . $row['id_agendamento'] . "'>";
                    echo "<label for='data_inicio_editar'>Nova Data de Início:</label> <br>";
                    echo "<input type='date' id='data_inicio_editar' name='data_inicio_editar' required> <br>";

                    echo "<label for='data_fim_editar'>Nova Data de Término:</label> <br>";
                    echo "<input type='date' id='data_fim_editar' name='data_fim_editar' required> <br>";

                    echo "<input type='text' id='informacoes_editar' name='informacoes_editar' placeholder='Insira novas informações'> <br>";
                    echo "<input type='submit' name='submit-editar' value='Editar'>";
                    echo "</form> <br>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nenhum agendamento encontrado.</p>";
            }
            ?>
        </div>

        <!-- Botão para voltar ao dashboard -->
        <a href="dashboard.php">
            <button class="botao-voltar">Voltar</button>
        </a>
    </main>

    <!-- ================= RODAPÉ ================= -->
    <footer>
        <img src="assets/img/logo-ifsc-preta.png" class="logo-ifsc">
        <p>Instituto Federal de Educação, Ciência e Tecnologia de Santa Catarina IFSC</p>
        <p>&copy; 2023 HostPet</p>
    </footer>

</body>
</html>
