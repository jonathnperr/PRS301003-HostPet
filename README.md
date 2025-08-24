# HostPet - Plataforma de Hospedagem para Pets

<p align="center">
  <img src="public/assets/img/logo.png" alt="HostPet Logo" width="300">
</p>

## ℹ️ Sobre o Repositório

Repositório contendo o **Projeto Integrador de Conclusão de Curso** desenvolvido para a disciplina **PRS301003 - Projeto de Software II** do Instituto Federal de Santa Catarina (IFSC). O sistema implementa uma plataforma web que conecta donos de pets com hosts, facilitando o processo de hospedagem de animais de estimação.

## 🎯 Objetivo Geral

Desenvolver uma plataforma web completa para gerenciamento de hospedagem de pets que permita:

- Cadastro de hosts com informações detalhadas
- Sistema de busca com filtros avançados (localização, tipo de pet, datas, preço)
- Gestão de perfil, agenda e fotos dos hosts
- Sistema de autenticação e controle de acesso
- Interface responsiva e intuitiva para usuários

## 📋 Funcionalidades Principais

### Módulo de Cadastro
- **Cadastro de Hosts**: Formulário completo com dados pessoais, localização, tipos de pets aceitos, preços e descrição
- **Upload de Fotos**: Sistema para upload de foto de perfil e fotos dos ambientes
- **Validação de Dados**: Campos obrigatórios e formatação adequada

### Módulo de Autenticação
- **Login**: Sistema seguro de autenticação com senhas criptografadas
- **Sessões**: Controle de acesso às áreas restritas
- **Logout**: Encerramento seguro de sessões

### Módulo de Perfil e Dashboard
- **Visualização de Perfil**: Página pública com informações do host
- **Dashboard Pessoal**: Área restrita para gerenciamento do perfil
- **Edição de Dados**: Atualização de informações pessoais e preferências

### Módulo de Agendamento
- **Gestão de Agenda**: Sistema para cadastro de períodos disponíveis
- **Edição de Horários**: Ferramenta para modificar agenda
- **Verificação de Conflitos**: Prevenção de agendamentos sobrepostos

### Módulo de Busca
- **Filtros Avançados**: Busca por localização, tipo de pet, datas e preço
- **Resultados Personalizados**: Exibição de cuidadores disponíveis
- **Visualização de Perfis**: Acesso rápido aos detalhes dos hosts

## 🏗️ Arquitetura do Sistema

### Padrão MVC (Model-View-Controller)
- **Model**: Entidades do sistema (Host, Agendamento, Fotos) e acesso ao banco
- **View**: Interface do usuário (páginas PHP com HTML/CSS)
- **Controller**: Processamento de formulários e lógica de negócio

### Estrutura de Diretórios
```
/PRS301003-HostPet
├── controller/           # Processadores de formulários
│   ├── processar-filtro.php
│   ├── processar-host.php
│   └── processar-login.php
├── includes/             # Includes e configurações
│   └── conexao.php
├── public/               # Arquivos públicos e interface
│   ├── assets/
│   │   ├── css/         # Estilos
│   │   ├── img/         # Imagens
│   │   └── js/          # Scripts JavaScript
│   ├── cadastro-host.php
│   ├── dashboard.php
│   ├── editar-*.php     # Páginas de edição
│   ├── filtro.php
│   ├── index.html
│   ├── login.php
│   └── perfil.php
├── uploads/              # Uploads de usuários
│   ├── fotos-local/     # Fotos do ambiente
│   └── fotos-perfil/    # Fotos de perfil
└── fotosbase/           # Imagens base do sistema
```

## 🛠️ Tecnologias Utilizadas

- **PHP 7+**: Linguagem de programação backend
- **MySQL**: Banco de dados relacional
- **HTML5/CSS3**: Estrutura e estilização frontend
- **JavaScript**: Interatividade e validações
- **Apache**: Servidor web

## 📚 Conceitos de Desenvolvimento Web Aplicados

- Programação server-side com PHP
- Manipulação de formulários e upload de arquivos
- Sessões e controle de acesso
- Persistência de dados com MySQL
- Interface responsiva com CSS
- Validação de dados no frontend e backend
- Organização de projeto em camadas

## 👨‍💻 Como Executar

### Pré-requisitos
- Servidor web (Apache recomendado)
- PHP 7.0 ou superior
- MySQL 5.6 ou superior
- Navegador web moderno

### Configuração
1. Clone o repositório para o diretório do servidor web
2. Configure o banco de dados MySQL com as tabelas necessárias
3. Ajuste as credenciais de banco no arquivo `includes/conexao.php`
4. Certifique-se que o diretório `uploads/` tem permissões de escrita
5. Acesse via navegador o diretório do projeto

### Estrutura do Banco de Dados
As tabelas necessárias incluem:
- `hosts` (informações dos cuidadores)
- `agendamentos` (datas disponíveis)
- `fotos_ambiente` (fotos dos locais de hospedagem)

## 📖 Referências Bibliográficas

1. **PHP and MySQL Web Development** - Luke Welling, Laura Thomson
2. **Modern PHP: New Features and Good Practices** - Josh Lockhart
3. **Desenvolvimento Web com PHP e MySQL** - Luke Welling, Laura Thomson
4. **Pro PHP and jQuery** - Jason Lengstorf, Keith Wald

## 👨‍🏫 Disciplina

**PRS301003 - PROJETO DE SOFTWARE II**  
Instituto Federal de Santa Catarina - Campus Florianópolis Centro  
Curso Técnico em Desenvolvimento de Sistemas

### Orientação
- Professora Catia dos Reis Machado

### Desenvolvido por
Jonathan Moraes Pereira

*Projeto acadêmico desenvolvido para fins educacionais - IFSC 2023*

---

**Nota**: Este projeto foi desenvolvido como trabalho de conclusão do curso técnico, integrando os conhecimentos adquiridos durante a formação e demonstrando habilidades em desenvolvimento web full-stack.
