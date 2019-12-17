<?php

class Conexao {

    private $conn; //Atributo de verificação da conexão
    private $host; //Atributo de caminho do seu servidor
    private $user; //Atributo do nome do usuario
    private $password; //Atrbuto de senha
    private $baseName; // Atributo do Banco
    private $port; //Porta de acesso ao mysql
    private $debug; //Verificação de erros

    function __construct() {
        $this->conn = false;
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        $this->baseName = "chapeu";
        $this->port = "3306";
        $this->debug = true;
        $this->connect();
    }

    function connect() {
        if (!$this->conn) {
            try {
                $this->conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->baseName . '', $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            } catch (Exception $e) {
                die('Erro' . $e->getMessage());
            }

            if (!$this->conn) {
                $this->status_fatal = true;
                echo 'Connection BDD failed';
                die();
            } else {
                $this->status_fatal = false;
            }
        }

        return $this->conn;
    }

    function execute($query) {
        if (!$resultado = $this->conn->exec($query)) {
            echo 'PDO::errorInfo():';
            echo '<br />';
            echo 'Erro SQL:' . $query . '<br />';
        }
        return $resultado;
    }

    function getAll($query) {
        $resultado = $this->conn->prepare($query);
        $ret = $resultado->execute();
        if (!$ret) {
            echo 'PDO::errorInfo():';
            echo '<br />';
            echo 'Erro SQL:' . $query . '<br />';
        }
        $resultado->setFetchMode(PDO::FETCH_ASSOC);
        $retorno = $resultado->fetchAll();

        return $retorno;
    }

    function getOne($query) {
        $resultado = $this->conn->prepare($query);
        $ret = $resultado->execute();
        if (!$ret) {
            echo 'PDO::errorInfo():';
            echo '<br />';
            echo 'Erro SQL:' . $query . '<br />';
        }
        $resultado->setFetchMode(PDO::FETCH_ASSOC);
        $retorno = $resultado->fetch();
        return $retorno;
    }

    

}

?>