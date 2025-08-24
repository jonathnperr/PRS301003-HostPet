<?php
// =============================================
// Arquivo: conexao.php
// Função: Criar conexão com o banco de dados MySQL
// =============================================

// Dados de configuração para acesso ao banco de dados
$hostname = 'localhost'; // Servidor do banco de dados
$user     = 'root';      // Usuário do banco de dados
$password = 'root';      // Senha do banco de dados
$database = 'hostpet';   // Nome do banco de dados

// Cria a conexão utilizando a extensão MySQLi
$conexao = new mysqli($hostname, $user, $password, $database);

// Verifica se houve erro na conexão
if ($conexao->connect_errno) {
    exit("Falha de conexão: (" . $conexao->connect_errno . ") " . $conexao->connect_error);
}
?>
