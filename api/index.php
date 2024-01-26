<?php

// abrir a sessão
session_start();

// carregar arquivo config
require('config.php');

// carrega todas as classes do projeto 
require_once('vendor/autoload.php');

// carregar sistema de rotas
require_once('core/routes.php');