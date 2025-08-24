<?php
// =============================================
// Arquivo: processar-filtro.php
// Função: Processa os filtros de busca e exibe os cuidadores disponíveis
// =============================================

include('../includes/conexao.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HostPet - Busca</title>
    <link rel="stylesheet" href="../public/assets/css/listar.css">
</head>

<body>
    <!-- ===================== CABEÇALHO ===================== -->
    <header>
        <h1> 
            <div class="cabeçalho">
                <!-- Logo -->
                <a href="index.html">
                    <img src="../public/assets/img/logo.png" class="logo">
                </a>

                <!-- Menu -->
                <a href="#" class="menu">Como Funciona</a>
                <a href="#" class="menu">Quem Somos</a>
            </div>
        </h1>
    </header>

    <main>
        <!-- ===================== RESULTADOS DA BUSCA ===================== -->
        <div class="titulo-resultado"></div>
        <br><br><br>

        <div class="div-formata-resultado">
            <?php
            // ------------------------------
            // 1. Processamento dos filtros
            // ------------------------------
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtém os parâmetros de filtro do formulário
                $estado = $_POST["estado"];
                $cidade = $_POST["cidade"];
                $data_inicio = $_POST["data_inicio"];
                $data_fim = $_POST["data_fim"];
                $pet_desejado = isset($_POST["pet_desejado"]) ? $_POST["pet_desejado"] : "";
                $limite_preco = isset($_POST["limite_preco"]) ? $_POST["limite_preco"] : 0;

                // ------------------------------
                // 2. Construção da consulta SQL
                // ------------------------------
                $sql = "SELECT * FROM hosts WHERE estado='$estado' AND cidade='$cidade'";
                
                // Filtro por disponibilidade nas datas selecionadas
                $sql .= " AND id NOT IN (
                    SELECT id_host
                    FROM agendamentos
                    WHERE ('$data_inicio' BETWEEN data_inicio AND data_fim) 
                    OR ('$data_fim' BETWEEN data_inicio AND data_fim)
                    OR (data_inicio BETWEEN '$data_inicio' AND '$data_fim') 
                    OR (data_fim BETWEEN '$data_inicio' AND '$data_fim')
                )";
                
                // Filtro por tipo de pet aceito
                if (!empty($pet_desejado)) {
                    $sql .= " AND FIND_IN_SET('$pet_desejado', pets_que_aceita) > 0";
                }
                
                // Filtro por preço máximo
                $sql .= " AND preco_cobrado_por_dia <= $limite_preco";

                // ------------------------------
                // 3. Execução da consulta e exibição dos resultados
                // ------------------------------
                $result = $conexao->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='cuidador-card'>";
                        
                        // Foto de perfil do cuidador
                        echo "<img src='../uploads/fotos-perfil/".$row["foto_perfil"]."' alt='Foto do perfil'>";
                        
                        // Informações do cuidador
                        echo "<div class='cuidador-card2'>";
                        echo "<h2>".$row["nome"]."</h2>";
                        echo "<p><strong>Localização: </strong>".$row["cidade"].", ".$row["estado"].", ".$row["bairro"]."</p>";
                        echo "<p><strong>Preço por dia:</strong> R$ ".$row["preco_cobrado_por_dia"]."</p>";
                        
                        // Link para o perfil completo
                        echo "<a href='../public/perfil.php?id=".$row["id"]."'><button>Ver perfil</button></a>";
                        
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='sem-resultados'>Nenhum cuidador encontrado com os filtros selecionados.</p>";
                }
            }
            
            // Fecha a conexão com o banco de dados
            $conexao->close();
            ?>
            <br><br><br><br><br><br><br><br>
        </div>
    </main>

    <!-- ===================== RODAPÉ ===================== -->
    <footer>
        <img src="../public/assets/img/logo-ifsc.png" class="logo-ifsc">
        <p>Instituto Federal de Educação, Ciência e Tecnologia de Santa Catarina IFSC</p>
        <p>&copy; 2023 HostPet</p>
    </footer>
</body>
</html>