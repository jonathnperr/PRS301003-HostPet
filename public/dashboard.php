<?php
// =============================================
// Arquivo: dashboard.php
// Função: Exibir o painel do cuidador
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
$usuario_id = $_SESSION["usuario_id"];

// ------------------------------
// 4. Consulta dados do cuidador
// ------------------------------
$sql = "SELECT * FROM hosts WHERE id = $usuario_id";
$resultado = $conexao->query($sql);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();

    // Dados do cuidador
    $nome        = $row["nome"];
    $email       = $row["email"];
    $estado      = $row["estado"];
    $cidade      = $row["cidade"];
    $bairro      = $row["bairro"];
    $descricao   = $row["descricao"];
    $foto_perfil = $row["foto_perfil"];
    $telefone    = $row["telefone"];
    $preco       = $row["preco_cobrado_por_dia"];

    // ------------------------------
    // 5. Formata lista de pets aceitos que vai ser necessário depois pra deixar bonitinho
    // ------------------------------
    $pets_que_aceita_bruto = $row["pets_que_aceita"];
    $pets_que_aceita_sem_underline = str_replace('_', ' ', $pets_que_aceita_bruto);
    $pets_array = explode(',', $pets_que_aceita_sem_underline);
    $pets_formatados = array();

    foreach ($pets_array as $pet) {
        switch (strtolower(trim($pet))) {
            case 'gato':
                $pets_formatados[] = 'Gato';
                break;
            case 'porquinho da india':
                $pets_formatados[] = 'Porquinho da Índia';
                break;
            case 'passaros':
                $pets_formatados[] = 'Pássaros';
                break;
            case 'coelho':
                $pets_formatados[] = 'Coelho';
                break;
            case 'chinchila':
                $pets_formatados[] = 'Chinchila';
                break;
            case 'cachorro':
                $pets_formatados[] = 'Cachorro';
                break;
            case 'hamster':
                $pets_formatados[] = 'Hamster';
                break;            
            default:
                $pets_formatados[] = ucwords($pet);
                break;
        }
    }
} else {
    echo "Cuidador de pet não encontrado.";
    exit();
}

// ------------------------------
// 6. Função para formatar data
// ------------------------------
function formatarData($data) {
    return date("d/m/Y", strtotime($data));
}

// ------------------------------
// 7. Alteração de agendamento
// ------------------------------
if (isset($_POST['submit-editar'])) {
    $id_agendamento_editar = $_POST["id_agendamento_editar"];
    $data_inicio_editar    = $_POST["data_inicio_editar"];
    $data_fim_editar       = $_POST["data_fim_editar"];
    $informacoes_editar    = $_POST["informacoes_editar"];

    $sql_atualizar = "UPDATE agendamentos 
                      SET data_inicio='$data_inicio_editar', 
                          data_fim='$data_fim_editar', 
                          informacoes='$informacoes_editar' 
                      WHERE id_agendamento=$id_agendamento_editar 
                        AND id_host=$usuario_id";
    $conexao->query($sql_atualizar);
}

// ------------------------------
// 8. Exclusão de agendamento
// ------------------------------
if (isset($_POST['submit_excluir'])) {
    $id_agendamento_excluir = $_POST["id_agendamento_excluir"];

    $sql_excluir = "DELETE FROM agendamentos 
                    WHERE id_agendamento=$id_agendamento_excluir 
                      AND usuario_id=$usuario_id";
    $conexao->query($sql_excluir);
}

// ------------------------------
// 9. Consulta agendamentos do cuidador
// ------------------------------
$sql_agendamentos = "SELECT * FROM agendamentos WHERE id_host=$usuario_id";
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

<!-- ===================== CABEÇALHO ===================== -->
<header> 
    <h1> 
        <div class="cabeçalho"> 
            <!-- Logo -->
            <a href="index.html">
                <img src="assets/img/logo.png" class="logo">
            </a>

            <!-- Menu -->
            <a href="index.html" class="menu"> Como Funciona </a> 
            <a href="index.html" class="menu"> Quem Somos </a>

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
    <!-- ===================== CAPA COM FOTO E NOME ===================== -->
    <div class="div-ini">
        <div class="div-ini-esquerda">
            <div class="div-ini-esquerda-baixo">
                <label class="nome-capa"><?php echo $nome; ?>!</label>
            </div>
        </div>
        <div class="div-ini-direita">
            <img src="../uploads/fotos-perfil/<?php echo $foto_perfil; ?>" alt="Foto de Perfil" class="fotoperfil">
        </div>
    </div>

    <br><br>
    <h2>Sobre você</h2>
    <div class="sobre-vc">
        <p><strong>- Nome:</strong> <?php echo $nome; ?></p>
        <p><strong>- Email:</strong> <?php echo $email; ?></p>
        <p><strong>- Estado:</strong> <?php echo $estado; ?></p>
        <p><strong>- Cidade:</strong> <?php echo $cidade; ?></p>
        <p><strong>- Bairro:</strong> <?php echo $bairro; ?></p>
        <p><strong>- Telefone:</strong> <?php echo $telefone; ?></p>
        <p><strong>- Preço por dia:</strong> R$<?php echo $preco; ?></p>
        <p><strong>- Pets aceitos:</strong> <?php echo implode(', ', $pets_formatados); ?></p>
        <p><strong>- Sua descrição:</strong> <?php echo $descricao; ?></p>
    </div>

    <!-- ===================== FOTOS DO AMBIENTE ===================== -->
    <h2>Fotos do Ambiente</h2>
    <div class="slideshow-container">
        <?php
        $sql_fotos_ambiente = "SELECT * FROM fotos_ambiente WHERE id_host = $usuario_id";
        $result_fotos_ambiente = $conexao->query($sql_fotos_ambiente);

        if ($result_fotos_ambiente->num_rows > 0) {
            while ($row_fotos_ambiente = $result_fotos_ambiente->fetch_assoc()) {
                $nome_arquivo_ambiente = $row_fotos_ambiente['caminho_foto'];
                echo "<div class='mySlides'>";
                echo "<img class='fotoambiente' src='../uploads/fotos-local/$nome_arquivo_ambiente' alt='Foto do Ambiente'>";
                echo "</div>";
            }
        } else {
            echo "<p>Nenhuma foto do ambiente encontrada.</p>";
        }
        ?>
        <!-- Botões de navegação do slideshow -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <br><br><br>
    <h2>Meus Agendamentos</h2>
    <?php
    if ($result_agendamentos->num_rows > 0) {
        while ($row = $result_agendamentos->fetch_assoc()) {
            echo "<div class='cada-agendamento'>";
            echo "<br><form method='post' action=''>";
            echo "<input type='hidden' name='id_agendamento_excluir' value='" . $row['id_agendamento'] . "'>";
            echo "<p><strong>- ID do Agendamento: </strong>" . $row['id_agendamento'] . "</p>";
            echo "<p><strong>- Data de Início: </strong>" . formatarData($row['data_inicio']) . "</p>";
            echo "<p><strong>- Data de Término: </strong>" . formatarData($row['data_fim']) . "</p>";
            echo "<p><strong>- Informações: </strong>" . $row['informacoes'] . "</p>"; 
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<div class='cada-agendamento'><p>Nenhum agendamento encontrado.</p></div>";
    }
    ?>

    <!-- Botões de ação -->
    <div class="botoes-main">
        <form action="editar-agenda.php" method="post">
            <input type="submit" value="Editar agendamentos" class="botao-form">
        </form>
        <form action="editar-dados.php" method="post">
            <input type="submit" value="Editar perfil" class="botao-form">
        </form>
    </div>
    <br><br><br>
</main>

<!-- ===================== RODAPÉ ===================== -->
<footer>
    <img src="assets/img/logo-ifsc.png" class="logo-ifsc">
    <p>Instituto Federal de Educação, Ciência e Tecnologia de Santa Catarina IFSC</p>
    <p>&copy; 2023 HostPet</p>
</footer>

<!-- ===================== JS PRO SLIDESHOW ===================== -->
<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) { showSlides(slideIndex += n); }
function currentSlide(n) { showSlides(slideIndex = n); }

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    if (n > slides.length) { slideIndex = 1; }
    if (n < 1) { slideIndex = slides.length; }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex - 1].style.display = "block";
}
</script> 
</body>
</html>
