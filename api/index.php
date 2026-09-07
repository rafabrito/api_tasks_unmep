<?php
// carrega todas as classes do projeto (incluindo dotenv)
require_once('vendor/autoload.php');
use Dotenv\Dotenv;

// acessa a raíz do projeto e carregavariáveis de ambiente do arquivo .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required([
    'DB_HOST', 
    'DB_DBNAME', 
    'DB_USER', 
    'DB_PASSWORD', 
    'DB_CHARSET'
]);

// carregar arquivo config
require('config.php');

// definir Content-Type da resposta como JSON
header('Content-Type: application/json; charset=utf-8');

// abrir a sessão
session_start();

// carregar sistema de rotas
require_once('core/routes.php');