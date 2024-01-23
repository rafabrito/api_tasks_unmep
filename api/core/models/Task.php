<?php

namespace core\models;

use core\class\Database;

class Task {

    /**
     * Consultar todas as tarefas cadastradas
     *
     * @return $result
     */
    public function list_task() 
    {
        $db = new Database();

        $result = $db->select("SELECT * FROM task");

        return $result;
    }

    /**
     * Cadastrar uma nova tarefa
     *
     * 
     */
    public function create_task()
    {
        date_default_timezone_set('America/Sao_Paulo');

        $db = new Database();

        $params = [
            ':title' => trim($_POST['title']),
            ':description' => trim($_POST['description']),
            ':status' => trim($_POST['status']),
            ':date_at' => date('Y-m-d H:i:s', time())
        ];


        $result = $db->insert("
            INSERT INTO task VALUES(
                0,
                :title,
                :description,
                :status,
                :date_at
            )
        ", $params);

        return $result;
    }

    /**
     * Cadastrar uma nova tarefa
     *
     * @param  $id
     * @return $result
     */
    public function edit_task($id) {
        date_default_timezone_set('America/Sao_Paulo');

        $bd = new Database();

        $params = array();
        $fields = "";

        if(isset($_POST['title'])) {
            $params[':title'] = trim($_POST['title']);
        }
        
        if(isset($_POST['description'])) {
            $params[':description'] = trim($_POST['description']);
        }

        if(isset($_POST['status'])) {
            $params[':status'] = trim($_POST['status']);
        }

        $params[':date_at'] = date('Y-m-d H:i:s', time());

        foreach($params as $key => $value) {
            if(!empty($value)) {
                $key = str_replace(array(':'), "", $key);
                $fields .= $key." = :".$key.", ";

                $$key = $value;
            }
        }

        $params[':id'] = $id;

        // remover ulltimo virgula
        $fields = rtrim($fields, ', ');

        $bd->update("
            UPDATE task
            SET
            $fields
            WHERE id = :id
        ", $params);
    }

    /**
     * Deletar dos base de dados uma uma tarefa
     *
     * @param  $id
     * @return $result
     */
    public function delete_task($id) {
        $bd = new Database();

        $params = [
            ':id' => $id
        ];

        $result = $bd->delete("
            DELETE FROM task
            WHERE id = :id
        ", $params);

        return $result;
    }

    /**
     * Pesquisar uma tarefa específica
     *
     * @param  $id
     * @return $result
     */
    public function find_task($id) {
        $bd = new Database();

        $result = $bd->select("
            SELECT * FROM task 
            WHERE id IN ($id)
        ");

        return $result;
    }
}