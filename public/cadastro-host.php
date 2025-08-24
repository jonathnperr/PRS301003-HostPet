<?php
// =============================================
// Arquivo: cadastro-host.php
// Função: Página de formulário para cadastro de um novo host
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
                <!-- Logo que leva para a página inicial -->
                <a href="index.html">
                    <img src="assets/img/logo.png" class="logo">
                </a>

                <!-- Menu de navegação -->
                <a href="#" class="menu"> Como Funciona </a> 
                <a href="#" class="menu"> Quem Somos </a>
            </div>
        </h1>
    </header> 

    <!-- ===================== CONTEÚDO PRINCIPAL ===================== -->
    <main>
        <!-- Espaço para título do formulário -->
        <div class="titulo-cadastro"></div> 
        <br><br><br>
       
        <div class="div-formata-cadastro">
            <!-- Formulário de cadastro de host -->
            <form action="../controller/processar-host.php" method="post" enctype="multipart/form-data">

                <!-- Campo Nome -->
                <label for="nome"><strong>Nome:</strong></label><br>
                <input type="text" id="nome" name="nome" required><br>

                <!-- Campo Email -->
                <label for="email"><strong>Email:</strong></label><br>
                <input type="email" id="email" name="email" required><br>

                <!-- Campo Senha -->
                <label for="senha"><strong>Senha:</strong></label><br>
                <input type="password" id="senha" name="senha" required><br>

                <!-- Campo Estado -->
                <label for="estado"><strong>Estado:</strong></label><br>
                <select id="uf" name="estado" required>
                    <option> Selecione um estado </option>
                </select><br>

                <!-- Campo Cidade -->
                <label for="cidade"><strong>Cidade:</strong></label><br>
                <select id="cidade" name="cidade" required>
                    <option> Seleciona uma cidade </option>
                </select><br>

                <!-- Campo Bairro -->
                <label for="bairro"><strong>Bairro:</strong></label><br>
                <input type="text" id="bairro" name="bairro" required><br>

                <!-- Campo Telefone -->
                <label for="telefone"><strong>Telefone:</strong></label><br>
                <input type="text" id="telefone" name="telefone" required><br>

                <!-- Campo Preço por dia -->
                <label for="preco_por_dia"><strong>Preço cobrado por dia: R$</strong></label><br>
                <input type="number" id="preco_por_dia" name="preco_por_dia" step="0.01" required> 
                <br><br>

                <!-- Pets aceitos -->
                <label><strong>Pets aceitos:</strong></label><br><br>
                <input type="checkbox" id="gato" name="pets_que_aceita[]" value="gato">
                <label for="gato"> Gato</label><br>

                <input type="checkbox" id="cachorro" name="pets_que_aceita[]" value="cachorro">
                <label for="cachorro"> Cachorro</label><br>

                <input type="checkbox" id="coelho" name="pets_que_aceita[]" value="coelho">
                <label for="coelho"> Coelho</label><br>

                <input type="checkbox" id="hamster" name="pets_que_aceita[]" value="hamster">
                <label for="hamster"> Hamster</label><br>

                <input type="checkbox" id="porquinho_da_india" name="pets_que_aceita[]" value="porquinho_da_india">
                <label for="porquinho_da_india"> Porquinho da Índia</label><br>

                <input type="checkbox" id="chinchila" name="pets_que_aceita[]" value="chinchila">
                <label for="chinchila"> Chinchila</label><br>

                <input type="checkbox" id="passaros" name="pets_que_aceita[]" value="passaros">
                <label for="passaros"> Pássaros</label><br><br>

                <!-- Campo Descrição -->
                <label for="descricao"><strong>Descrição do Usuário:</strong></label><br>
                <textarea id="descricao" name="descricao" rows="4" cols="50" required></textarea><br>

                <!-- Upload Foto de Perfil -->
                <label for="foto_perfil"><strong>Upload de Foto de Perfil:</strong></label><br>
                <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*"><br>

                <!-- Upload Fotos do Ambiente -->
                <label for="fotos_ambiente"><strong>Upload de Fotos do Ambiente do Pet:</strong></label><br>
                <input type="file" id="fotos_ambiente" name="fotos_ambiente[]" accept="image/*" multiple><br>

                <!-- Botão de envio -->
                <input type="submit" value="Cadastrar"> 
                <br><br><br><br><br><br>
            </form>
        </div>
    </main>

    <!-- ===================== RODAPÉ ===================== -->
    <footer>
        <img src="assets/img/logo-ifsc.png" class="logo-ifsc">
        <p>Instituto Federal de Educação, Ciência e Tecnologia de Santa Catarina IFSC</p>
        <p>&copy; 2023 HostPet</p>
    </footer>

    <!-- Script para preenchimento dinâmico de UF e Cidades -->
    <script type="text/javascript" src="assets/js/ufcidade.js"></script>
</body>
</html>
