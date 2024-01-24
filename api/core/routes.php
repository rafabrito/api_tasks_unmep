<?php

// conjunto de rotas
$routes = [
    'list_task' => 'main@index',
    'create_task' => 'main@create',
    'edit_task' => 'main@edit',
    'delete_task' => 'main@destroy',
    'display_task' => 'main@show',
];

// definir ação padrão
$action = 'list_task';

// verificar se existe alguma ação na query string
if(isset($_GET['a'])) {

    // verificar se a ação existe no conjunto de rotas
    if(!key_exists($_GET['a'], $routes)){
        $action = 'list_task';
    } else {
        $action = $_GET['a'];
    }
}

// separar string que apresenta o controller e o método a ser executado
$split_action_route = explode('@', $routes[$action]);

// localização do controller Main
$controller = 'core\\controllers\\'.ucfirst($split_action_route[0]);

// nome do método
$method = $split_action_route[1];

// instanciar o controller e executar o método específico
$ctr = new $controller();
$ctr->$method();