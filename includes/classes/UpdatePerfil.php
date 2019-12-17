<?php

class UpdatePerfil extends Conexao {

    private $nome;
    private $email;
    private $senha;
    private $telefone;
    private $cidade;
    private $estado;
    private $bairro;
    private $rua;
    private $numeroCasa;
    private $pasta;
    private $extensao;
    private $extensaoTipo;
    private $pastaUser;

    public function __construct($novoNome, $novoEmail, $novaSenha, $novoTelefone, $novaCidade, $novoEstado, $novoBairro, $ruaCasa, $numeroNovoCasa, $novoNomeImg, $extensao, $pasta, $extensaoTipo) {
        parent::__construct();
        $this->nome = $novoNome;
        $this->email = $novoEmail;
        $this->senha = $novaSenha;
        $this->telefone = $novoTelefone;
        $this->estado = $novoEstado;
        $this->cidade = $novaCidade;
        $this->bairro = $novoBairro;
        $this->rua = $ruaCasa;
        $this->numeroCasa = $numeroNovoCasa;
        $this->novoNomeImg = $novoNomeImg;
        $this->pasta = $pasta;
        $this->extensao = $extensao;
        $this->extensaoTipo = $extensaoTipo;
        $this->Altera();
    }

    private function Altera() {
        if (($this->extensaoTipo == "image/jpg") || ($this->extensaoTipo == "image/jpeg") || ($this->extensaoTipo == "image/png")) {
            $fotoName = $this->novoNomeImg;
        } else if (($this->extensaoTipo != "image/jpg") || ($this->extensaoTipo != "image/jpeg") || ($this->extensaoTipo != "image/png")) {
            $_SESSION['extensaoinvalida'] = "Não pode ser utilizado esse tipo de extensão. Apenas jpg/jpeg e pngs";
        } else if ($this->novoNomeImg == null) {
            $fotoName = "userDefaut.png";
            $this->novoNomeImg = $fotoName;
        }
        if ($this->extensaoTipo != null) {
            $pastaSave = md5($_SESSION['codigoUser']);
            unlink("../img/perfils/$pastaSave/". $_SESSION['fotoUser'] . ""); 
            $this->pastaUser = $pastaSave;
            $query = "UPDATE `usuario` SET `usu_nome`= '{$this->nome}',`usu_email`= '{$this->email}', `usu_senha`='{$this->senha}', `usu_telefone`='{$this->telefone}', usu_estado = '{$this->estado}', usu_cidade = '{$this->cidade}', usu_bairro = '{$this->bairro}', usu_rua = '{$this->rua}', usu_numeroCasa = '{$this->numeroCasa}', `usu_foto`='$fotoName' WHERE usu_codigo = {$_SESSION['codigoUser']}";
        } else {
            $query = "UPDATE `usuario` SET `usu_nome`= '{$this->nome}',`usu_email`= '{$this->email}', `usu_senha`='{$this->senha}', `usu_telefone`='{$this->telefone}', usu_estado = '{$this->estado}', usu_cidade = '{$this->cidade}', usu_bairro = '{$this->bairro}', usu_rua = '{$this->rua}', usu_numeroCasa = '{$this->numeroCasa}' WHERE usu_codigo = {$_SESSION['codigoUser']}";
        }

        $this->execute($query);
        $this->sessaoNova();
    }

    private function sessaoNova() {
        $_SESSION['nomeUser'] = $this->nome;
        $_SESSION['senhaUser'] = $this->senha;
        $_SESSION['emailUser'] = $this->email;
        $_SESSION['telefoneUser'] = $this->telefone;
        $_SESSION['estadoUser'] = $this->estado;
        $_SESSION['cidadeUser'] = $this->cidade;
        $_SESSION['bairroUser'] = $this->bairro;
        $_SESSION['ruaUser'] = $this->rua;
        $_SESSION['numeroCasaUser'] = $this->numeroCasa;
        if ($this->extensaoTipo == null) {
            
        } else {
            $_SESSION['fotoUser'] = $this->novoNomeImg;
        }
        if ($_SESSION['nivelUser'] == 3) {
            header("Location:admin.php");
        } else if ($_SESSION['nivelUser'] == 2) {
            header("Location:pedidos.php");
        } else if ($_SESSION['nivelUser'] == 1) {
            header("Location:cozinha.php");
        } else if ($_SESSION['nivelUser'] == 0) {
            header("Location: ../../");
        }
    }

}
