<?php
// =============================================
// Arquivo: filtro.php
// Função: Página de busca de hosts de acordo com os filtros do usuário
// =============================================

include('../includes/conexao.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HostPet - Busca</title>
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

    <main>
        <!-- ===================== FORMULÁRIO DE BUSCA ===================== -->
        <div class="titulo-encontrar"></div>
        <br><br><br>

        <div class="div-formata-encontrar">
            <!-- Formulário de filtros de busca -->
            <form method="post" action="../controller/processar-filtro.php">
                <!-- Filtro por estado -->
                <label for="estado"><strong>Estado:</strong></label>
                <select id="uf" name="estado" required>
                    <option>Selecione um estado</option>
                </select><br>

                <!-- Filtro por cidade -->
                <label for="cidade"><strong>Cidade:</strong></label>
                <select id="cidade" name="cidade" required>
                    <option>Seleciona uma cidade</option>
                </select><br>

                <!-- Filtro por tipo de pet -->
                <label for="pet_desejado"><strong>Pet Desejado:</strong></label>
                <select id="pet_desejado" name="pet_desejado">
                    <option value="">Qualquer pet</option>
                    <option value="gato">Gato</option>
                    <option value="cachorro">Cachorro</option>
                    <option value="coelho">Coelho</option>
                    <option value="hamster">Hamster</option>
                    <option value="porquinho_da_india">Porquinho da índia</option>
                    <option value="chinchila">Chinchila</option>
                    <option value="passaros">Pássaros</option>
                </select><br>

                <!-- Filtro por período -->
                <label for="data_inicio"><strong>De:</strong></label>
                <input type="date" id="data_inicio" name="data_inicio" required><br>

                <label for="data_fim"><strong>Até:</strong></label>
                <input type="date" id="data_fim" name="data_fim" required><br>

                <!-- Filtro por preço -->
                <label for="limite_preco"><strong>Limite de Preço:</strong></label>
                <input type="number" step="0.01" id="limite_preco" name="limite_preco" placeholder="0.00" required><br>

                <!-- Botão de submit -->
                <input type="submit" value="Buscar">
                <br><br><br><br><br><br><br>
            </form>
        </div>
    </main>

    <!-- ===================== RODAPÉ ===================== -->
    <footer>
        <img src="assets/img/logo-ifsc.png" class="logo-ifsc">
        <p>Instituto Federal de Educação, Ciência e Tecnologia de Santa Catarina IFSC</p>
        <p>&copy; 2023 HostPet</p>
    </footer>

    <!-- Script para seleção de estados e cidades -->
    <script type="text/javascript" src="assets/js/ufcidade.js"></script>
</body>
</html>