<?php

// abrir a sessão
session_start();

// carregar arquivo config
require('config.php');

//(foi necessário executar composer init e composer updade antes)
// carrega todas as classes do projeto 
require_once('vendor/autoload.php');

// carregar sistema de rotas
require_once('core/routes.php');