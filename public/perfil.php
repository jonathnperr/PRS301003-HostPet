<?php
// =============================================
// Arquivo: perfil.php
// Função: Exibe o perfil detalhado de um cuidador específico
// =============================================

include('../includes/conexao.php');

// ------------------------------
// 1. Verifica se o ID do cuidador foi fornecido
// ------------------------------
if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    // ------------------------------
    // 2. Obtém os dados do cuidador
    // ------------------------------
    $sql = "SELECT * FROM hosts WHERE id = $usuario_id";
    $resultado = $conexao->query($sql);

    // ------------------------------
    // 3. Processa os dados se encontrados
    // ------------------------------
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $nome = $row["nome"];
        $email = $row["email"];
        $estado = $row["estado"];
        $cidade = $row["cidade"];
        $bairro = $row["bairro"];
        $descricao = $row["descricao"];
        $foto_perfil = $row["foto_perfil"];
        $telefone = $row["telefone"];
        $preco = $row["preco_cobrado_por_dia"];

        // ------------------------------
        // 4. Formata a lista de pets aceitos
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
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Cuidador</title>
    <link rel="stylesheet" href="assets/css/listar.css">
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
                <a href="#" class="menu">Como Funciona</a>
                <a href="#" class="menu">Quem Somos</a>
            </div>
        </h1>
    </header>

    <main class="perfil">
        <!-- ===================== PERFIL DO CUIDADOR ===================== -->
        <div class="div-exibe-host">
            <!-- Cabeçalho do perfil com foto -->
            <div class="div-ini">
                <div class="div-ini-esquerda">
                    <div class="div-ini-esquerda-baixo">
                        <label class="nome-capa"><?php echo $nome; ?></label>
                    </div>
                </div>
                <div class="div-ini-direita">
                    <img src="../uploads/fotos-perfil/<?php echo $foto_perfil; ?>" alt="Foto de Perfil" class="fotoperfil">
                </div>
            </div>
            
            <!-- Seção "Sobre o cuidador" -->
            <h2>Sobre o cuidador</h2>
            <div class="sobre-cuidador">
                <p><strong>- Nome:</strong> <?php echo $nome; ?></p>
                <p><strong>- Estado:</strong> <?php echo $estado; ?></p>
                <p><strong>- Cidade:</strong> <?php echo $cidade; ?></p>
                <p><strong>- Bairro:</strong> <?php echo $bairro; ?></p>
                <p><strong>- Telefone:</strong> <?php echo $telefone; ?></p>
                <p><strong>- Preço por hora:</strong> R$<?php echo $preco; ?></p>
                <p><strong>- Pets aceitos:</strong> <?php echo implode(', ', $pets_formatados); ?></p>
                <p><strong>- Descrição:</strong> <?php echo $descricao; ?></p>
            </div>

            <!-- ===================== FOTOS DO AMBIENTE ===================== -->
            <br><h2>Fotos do Ambiente</h2><br>
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

            <!-- ===================== CONTATO ===================== -->
            <br><h2>Entre em contato!</h2>
            <div class="texto-whats">
                <p>Para mais informações entre em contato com o cuidador clicando no botão abaixo.</p>
            </div>

            <div class="botoes-whats">
                <a href="https://wa.me/55<?php echo $telefone; ?>" target="_blank">
                    <button class="botao-whats">WhatsApp</button>
                </a>
            </div>

            <br><br><br><br><br><br>
        </div>
    </main>

    <!-- ===================== RODAPÉ ===================== -->
    <footer>
        <img src="assets/img/logo-ifsc.png" class="logo-ifsc">
        <p>Instituto Federal de Educação, Ciência e Tecnologia de Santa Catarina IFSC</p>
        <p>&copy; 2023 HostPet</p>
    </footer>

    <!-- ===================== JS DO SLIDESHOW ===================== -->
    <script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");

        if (n > slides.length) {
            slideIndex = 1;
        }

        if (n < 1) {
            slideIndex = slides.length;
        }

        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        slides[slideIndex - 1].style.display = "block";
    }
    </script>
</body>
</html>