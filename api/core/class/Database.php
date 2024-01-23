<?php

namespace core\class;

use Exception;
use PDO;
use PDOException;

class Database {
    private $connection;

    /**
     * Realizar conexão ao banco de dados
     *
     * 
     */
    private function connect()
    {
        $this->connection = new PDO(
            'mysql:'.
            'host='.DB_HOST.';'.
            'dbname='.DB_DBNAME.';'.
            'charset='.DB_CHARSET,
            DB_USER,
            DB_PASSWORD,
            array(PDO::ATTR_PERSISTENT => true)
        );

        // debug
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    /**
     * Realizar desconexão do banco de dados
     *
     * 
     */
    private function disconnect()
    {
        $this->connection = null;
    }

    /**
     * Realizar consulta ao banco de dados (SELECT)
     *
     * @return $result
     */
    public function select($sql, $param = null)
    {
        // elimina espaços antes e depois
        $sql = trim($sql);

        // verificar se é uma clausula SELECT ou select
        if(!preg_match("/^SELECT/i", $sql)) {
            throw new Exception("Database - Não é uma instrução SELECT");
        }
        
        $this->connect();

        $result = null;

        try {
            if(!empty($param)){
                $exe = $this->connection->prepare($sql);
                $exe->execute($param);
                $result = $exe->fetchAll(PDO::FETCH_CLASS); # os resultados estão na forma de objeto
            } else {
                $exe = $this->connection->prepare($sql);
                $exe->execute();
                $result = $exe->fetchAll(PDO::FETCH_CLASS);
            }
        } catch (PDOException $e){
            // caso exista erro
            return false;
        }

        $this->disconnect();

        return $result;
    }

    /**
     * Realizar inserção no banco de dados (INSERT)
     *
     * 
     */
    public function insert($sql, $param = null)
    {
        // elimina espaços antes e depois
        $sql = trim($sql);
        
        // verificar se é uma clausula INSERT ou insert
        if(!preg_match("/^INSERT/i", $sql)) {
            throw new Exception("Database - Não é uma instrução INSERT");
        }
        
        $this->connect();

        try {
            if(!empty($param)){
                $exe = $this->connection->prepare($sql);
                $exe->execute($param);
            } else {
                $exe = $this->connection->prepare($sql);
                $exe->execute();
            }
        } catch (PDOException $e){
            // caso exista erro
            return false;
        }

        $this->disconnect();
    }

    /**
     * Realizar atualização de dados existentes no banco de dados (UPDATE)
     *
     * 
     */
    public function update($sql, $param = null) 
    {
        // elimina espaços antes e depois
        $sql = trim($sql);
        
        // verificar se é uma clausula UPDATE ou update
        if(!preg_match("/^UPDATE/i", $sql)) {
            throw new Exception("Database - Não é uma instrução UPDATE");
        }
        
        $this->connect();

        try {
            if(!empty($param)){
                $exe = $this->connection->prepare($sql);
                foreach($param as $key => $value) {
                    $exe->bindValue($key, $value, PDO::PARAM_STR);
                }
                $exe->execute();
            } else {
                $exe = $this->connection->prepare($sql);
                $exe->execute();
            }
        } catch (PDOException $e){
            // caso exista erro
            return false;
        }

        $this->disconnect();
    }

    /**
     * Realizar deleção de dados existentes no banco de dados (UPDATE)
     *
     * 
     */
    public function delete($sql, $param = null)
    {
        // elimina espaços antes e depois
        $sql = trim($sql);

        // verificar se é uma clausula DELETE ou delete
        if(!preg_match("/^DELETE/i", $sql)) {
            throw new Exception("Database - Não é uma instrução DELETE");
        }
        
        $this->connect();

        try {
            if(!empty($param)) {
                $exe = $this->connection->prepare($sql);
                $exe->execute($param);
            } else {
                $exe = $this->connection->prepare($sql);
                $exe->execute();
            }
        } catch (PDOException $e) {
            // caso exista erro
            return false;
        }

        $this->disconnect();
    }
}
