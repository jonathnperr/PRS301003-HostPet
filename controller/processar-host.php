<?php
// =============================================
// Arquivo: processar-host.php
// Função: Processar os dados informados pelo usuário para cadastro na plataforma
// =============================================
include('../includes/conexao.php');

// Verifica se o formulário foi enviado via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // =============================
    // 1. CAPTURA E TRATAMENTO DOS DADOS DO FORMULÁRIO
    // =============================

    // Nome: deixa tudo em minúsculo e depois coloca a primeira letra de cada palavra em maiúsculo
    $nome = ucwords(strtolower($_POST["nome"]));

    $email = $_POST["email"];

    // Criptografa a senha antes de armazenar no banco
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $estado = $_POST["estado"];
    $cidade = $_POST["cidade"];

    // Bairro com formatação de letras
    $bairro = ucwords(strtolower($_POST["bairro"]));

    $descricao = $_POST["descricao"];
    $preco_por_dia = $_POST["preco_por_dia"];

    // Junta os pets aceitos em uma string separada por vírgula
    $pets_que_aceita = implode(",", $_POST["pets_que_aceita"]);

    $telefone = $_POST['telefone'];

    // =============================
    // 2. UPLOAD DA FOTO DE PERFIL
    // =============================
    if ($_FILES["foto_perfil"]["error"] == UPLOAD_ERR_OK) {
        $nome_arquivo_perfil = $_FILES["foto_perfil"]["name"];
        move_uploaded_file(
            $_FILES["foto_perfil"]["tmp_name"],
            '../uploads/fotos-perfil/' . $nome_arquivo_perfil
        );
    } else {
        $nome_arquivo_perfil = null;
    }

    // =============================
    // 3. INSERE OS DADOS PRINCIPAIS DO HOST NO BANCO
    // =============================
    $sql = "INSERT INTO hosts 
            (nome, email, senha, estado, cidade, bairro, descricao, foto_perfil, preco_cobrado_por_dia, pets_que_aceita, telefone) 
            VALUES 
            ('$nome', '$email', '$senha', '$estado', '$cidade', '$bairro', '$descricao', '$nome_arquivo_perfil', $preco_por_dia, '$pets_que_aceita', '$telefone')";

    if ($conexao->query($sql) === TRUE) {

        // Obtém o ID
        $cuidador_id = $conexao->insert_id;

        // =============================
        // 4. UPLOAD DAS FOTOS DO AMBIENTE
        // =============================
        if (!empty($_FILES["fotos_ambiente"]["name"][0])) {
            foreach ($_FILES["fotos_ambiente"]["tmp_name"] as $key => $tmp_name) {
                $nome_arquivo_ambiente = $_FILES["fotos_ambiente"]["name"][$key];
                move_uploaded_file(
                    $tmp_name,
                    '../uploads/fotos-local/' . $nome_arquivo_ambiente
                );

                // Insere cada foto do ambiente na tabela separada
                $sql_fotos_ambiente = "INSERT INTO fotos_ambiente (id_host, caminho_foto) 
                                       VALUES ('$cuidador_id', '$nome_arquivo_ambiente')";
                $conexao->query($sql_fotos_ambiente);
            }
        }

        // Redireciona para o dashboard após o cadastro
        header("Location: ../public/dashboard.php");
    } else {
        echo "Erro ao cadastrar: " . $conexao->error;
    }

    // Fecha a conexão com o banco
    $conexao->close();

} else {
    // Caso o acesso não seja via POST, redireciona para o formulário
    header("Location: ../public/formulario.php");
    exit();
}
?>
