<?php

class CadastroUser extends Conexao {

    private $nome;
    private $email;
    private $senha;
    private $telefone;
    private $cidade;
    private $estado;
    private $bairro;
    private $rua;
    private $numero;

    function __construct($nome, $email, $senha, $telefone, $estado, $cidade, $bairro, $rua, $numero) {
        parent::__construct();
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->telefone = $telefone;
        $this->estado = $estado;
        $this->cidade = $cidade;
        $this->bairro = $bairro;
        $this->rua = $rua;
        $this->numero = $numero;
        $this->Cadastra();
    }

    function Cadastra() {
        $queryVer = "SELECT * FROM usuario WHERE usu_email = '{$this->email}'";
        $verifica = $this->getOne($queryVer);
        if ($verifica) {
            $_SESSION['Msgcadastro'] = "ja tem!";
        } else {
            $query = "INSERT INTO usuario(usu_nome, usu_email, usu_senha, usu_telefone,usu_estado, usu_cidade, usu_bairro, usu_rua, usu_numeroCasa, usu_pontos, usu_foto, usu_nivel, usu_status, usu_block) VALUES ('{$this->nome}', '{$this->email}', '{$this->senha}', '{$this->telefone}','{$this->estado}','{$this->cidade}','{$this->bairro}','{$this->rua}','{$this->numero}',0,'userDefaut.png', 0,0,0)";
            $cadastra = $this->execute($query);
            $_SESSION['Msgcadastro'] = "cadastrou";
            $buscaCod = "SELECT * FROM usuario WHERE usu_email = '{$this->email}'";
            if($ret = $this->getOne($buscaCod)){
                $id = $ret['usu_codigo'];
                $pasta = md5($id);
                mkdir("./includes/img/perfils/$pasta/", 0777, true);
            }
            header("Location:index.php");
        }
    }

}

class CadastroUserAdm extends Conexao {

    private $nome;
    private $email;
    private $senha;
    private $telefone;
    private $pontos;
    private $cidade;
    private $estado;
    private $bairro;
    private $rua;
    private $numero;
    private $nivel;

    public function __construct($nome, $email, $senha, $telefone, $estado, $cidade, $bairro, $rua, $numero, $pontos, $nivel) {
        parent::__construct();
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->telefone = $telefone;
        $this->pontos = $pontos;
        $this->nivel = $nivel;
        $this->estado = $estado;
        $this->cidade = $cidade;
        $this->bairro = $bairro;
        $this->rua = $rua;
        $this->numero = $numero;
        $this->CadastroUserAdm();
    }

    private function CadastroUserAdm() {
        $queryVer = "SELECT * FROM usuario WHERE usu_email = '{$this->email}'";
        $verifica = $this->getOne($queryVer);
        if ($verifica) {
            $_SESSION['MsgToAdm'] = "ja tem!";
        } else {
            $query = "INSERT INTO usuario(usu_nome, usu_email, usu_senha, usu_telefone,usu_estado, usu_cidade, usu_bairro,usu_rua, usu_numeroCasa, usu_pontos, usu_foto, usu_nivel, usu_status, usu_block) VALUES ('{$this->nome}', '{$this->email}','{$this->senha}','{$this->telefone}','{$this->estado}','{$this->cidade}','$this->bairro','{$this->rua}','{$this->numero}','{$this->pontos}','userDefaut.png', '{$this->nivel}',0,0)";
            $this->execute($query);
            $buscaCod = "SELECT * FROM usuario WHERE usu_email = '{$this->email}'";
            
            if($ret = $this->getOne($buscaCod)){
                $id = $ret['usu_codigo'];
                $pasta = md5($id);
                mkdir("../img/perfils/$pasta/", 0777, true);
                
            }
            $_SESSION['MsgToAdm'] = "cadastrado";
            header("Location:../paginas/admin.php?usuarios");
            
        }
    }

}
