<?php

namespace core\controllers;

use core\models\Task;

class Main 
{
    /**
     * Exibir listagem das tarefas.
     *
     * @return Http\Response
     */
    public function index() 
    {   
        $task = new Task();
        $list_task = $task->list_task();

        // tratar o campo date_at para o formato d-m-Y
        foreach($list_task as $value) {
            $date = date_create($value->date_at);
            $value->date_at = date_format($date, 'd-m-Y');
        }
        
        $data = [
            'tasks' => $list_task
        ];
        
        echo json_encode($data);
    }

    /**
     * Criar uma nova tarefa
     *
     * @return Http\Response
     */
    public function create() 
    {   
        // status válidos
        $status = array('pendente','executando', 'concluída');
        $data = null;

        // verificar se todos os campos foram especificados
        if(isset($_POST['title']) AND isset($_POST['description']) AND isset($_POST['status'])){
            if(!empty($_POST['title'])) {
                if(!empty($_POST['description'])) {
                    if(!empty($_POST['status'])) {
                        // converter o campo status para minúsculo e remover espaços no início e no final
                        $sts = mb_convert_case(trim($_POST['status']), MB_CASE_LOWER_SIMPLE, 'UTF-8');
                        if(in_array($sts, $status)) {
                            $task = new Task();
                            $task->create_task();

                            $data = [
                                "sucess" => [
                                    "message" => "Tarefa criada com sucesso!"
                                ] 
                            ];
                        } else {
                            $data = [
                                "error" => [
                                    "message" => "Status não existe",
                                    "possible status" => ["pendente","executando", "concluída"]
                                ] 
                            ];
        
                            echo json_encode($data);
                        }
                    } else {
                        $data = [
                            "error" => [ "message" => "O campo 'status' não foi definido"]
                        ];
                    }
                } else {
                    $data = [
                        "error" => [ "message" => "O campo 'description' não foi definido"]
                    ];

                    echo json_encode($data);
                }
            } else {
                $data = [
                    "error" => ["message" => "O campo 'title' não foi definido"]
                ];

                echo json_encode($data);
            }
        } else {
            $data = [
                "error" => [ "message" => "Não foram preenchido todos os campos"]
            ];

            echo json_encode($data);
        }
        
    }

    /**
     * Editar tarefa específica
     *
     * @return Http\Response
     */
    public function edit()
    {   
        // status válidos
        $status = array('pendente','executando', 'concluída');
        $data = null;
    
        if(!empty($_POST)) {
            if(isset($_GET['id']) AND !empty($_GET['id'])) {
                if((isset($_POST['title']) OR isset($_POST['description']) OR isset($_POST['status']))) {
                    // verificar se existe o campo status e se o status é válido estando em minúsculo ou em maiusculo
                    if(isset($_POST['status']) AND !in_array(mb_convert_case(trim($_POST['status']), MB_CASE_LOWER_SIMPLE, 'UTF-8'), $status)) {
                        $data = [
                            "error" => [
                                "message" => "Status não existe",
                                "possible status" => ["pendente","executando", "concluída"]
                            ] 
                        ];
    
                        echo json_encode($data);
                    } else {
                        $task = new Task();
                        $verify = $task->find_task($_GET['id']);
                        if(!empty($verify)) {

                            $task->edit_task($_GET['id']);

                            $task_edited = $task->find_task($_GET['id']);

                            // // tratar o campo date_at para o formato d-m-Y
                            $date = date_create($task_edited[0]->date_at);
                            $task_edited[0]->date_at = date_format($date, 'd-m-Y');

                            $data = [
                                "task" => $task_edited,
                                "message" => "Tarefa editada com sucesso!"
                            ];

                            echo json_encode($data);
                        } else {
                            $data = [
                                "error" => [ "message" => "Tarefa não existe"]
                            ];

                            echo json_encode($data);
                        }
                    }
                }
            } else {
                $data = [
                    "error" => [ "message" => "Não foi especificado o id da tarefa"]
                ];

                echo json_encode($data);
            }
        } else {
            $task = new Task();
            $verify = $task->find_task($_GET['id']);
            if(!empty($verify)) {
                $data = [
                    "task" => $verify,
                    "message" => "Nenhum campo foi alterado!"
                ];

                echo json_encode($data);
            } else {
                $data = [
                    "error" => [ "message" => "Tarefa não existe"]
                ];

                echo json_encode($data);
            }
        }
    }

    /**
     * Remover tarefa específica
     *
     * @return Http\Response
     */
    public function destroy()
    {
        if(isset($_GET['id']) AND !empty($_GET['id'])) {
            $task = new Task();
            $verify = $task->find_task($_GET['id']);

            if(!empty($verify)) {

                $task->delete_task($_GET['id']);

                $data = [
                    "removed" => intval($_GET['id']),
                    "message" => "Tarefa deletada com sucesso!"
                ];

                echo json_encode($data);
            } else {
                $data = [
                    "error" => [ "message" => "Tarefa não existe"]
                ];

                echo json_encode($data);
            }
        }
    }
}