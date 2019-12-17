<?php

class Login extends Conexao {

    private $email;
    private $senha;

    function __construct($email, $senha) {
        parent::__construct();
        $this->email = $email;
        $this->senha = $senha;
        $this->Logar();
    }

    private function Logar() {
        $query = "SELECT * FROM usuario WHERE usu_email = '{$this->email}' AND usu_senha = '{$this->senha}'";
        $verifica = $this->getOne($query);
        if ($verifica > 0) {
            $_SESSION['Msglogin'] = "loguei!";
            $this->sessao($verifica);
        } else {
            $_SESSION['Msglogin'] = "nao existe";
        }
    }

    private function sessao($cliente) {
        if ($cliente['usu_block'] == 1) {
            $_SESSION['Msglogin'] = "Conta bloqueada";
            
        } else if($cliente['usu_block'] == 0) {
            $_SESSION['codigoUser'] = $cliente['usu_codigo'];
            $_SESSION['nomeUser'] = $cliente['usu_nome'];
            $_SESSION['senhaUser'] = $cliente['usu_senha'];
            $_SESSION['emailUser'] = $cliente['usu_email'];
            $_SESSION['telefoneUser'] = $cliente['usu_telefone'];
            $_SESSION['estadoUser'] = $cliente['usu_estado'];
            $_SESSION['cidadeUser'] = $cliente['usu_cidade'];
            $_SESSION['bairroUser'] = $cliente['usu_bairro'];
            $_SESSION['ruaUser'] = $cliente['usu_rua'];
            $_SESSION['numeroCasaUser'] = $cliente['usu_numeroCasa'];
            $_SESSION['pontosUser'] = $cliente['usu_pontos'];
            $_SESSION['nivelUser'] = $cliente['usu_nivel'];
            $_SESSION['fotoUser'] = $cliente['usu_foto'];
            $_SESSION['pasta'] = md5($cliente['usu_codigo']);
			$_SESSION["sessiontime"] = time() + 60 * 30;
            $codigo = $cliente['usu_codigo'];
            $mudaStatus = "UPDATE usuario SET usu_status = 1 WHERE usu_codigo = {$codigo} AND usu_block = 0";
            $this->execute($mudaStatus);
            if($_SESSION['nivelUser'] == 3){
                header("Location:./includes/paginas/admin.php");
            }
            if ($_SESSION['nivelUser'] == 1) {
                header("Location:./includes/paginas/cozinha.php");
            } else if ($_SESSION['nivelUser'] == 0) {
                header("Location:index.php");
            }
        }
    }

}

class Sair extends Conexao {


    public function logout($page) {
        
        $mudaStatus = "UPDATE usuario SET usu_status = 0 WHERE usu_codigo = {$_SESSION['codigoUser']}";
        $this->execute($mudaStatus);
        
        if($page == "index"){
            header("Location:index.php");
        }else {
            header("Location:../../");
        }
        session_unset();
        session_destroy();
        
        
    }
	public function sessao(){

		if(!isset($_SESSION['emailUser']) AND !isset($_SESSION['senhaUser']))
		{	
			session_unset();
			session_destroy();
			header('Location: ../../');
		}
		else
		{
			if(isset($_SESSION["sessiontime"])){
				if(isset($_SESSION["sessiontime"]) < time())
				{
					$codigoUser = $_SESSION['codigoUser'];
					$mudaStatus = "UPDATE `usuario` SET usu_status = '0' WHERE usu_codigo = $codigoUser";
					if($this->execute($mudaStatus)){
						
					
						
						if($_SESSION['nivelUser'] == 3){
							header('Location: ../../');
						}else if($_SESSION['nivelUser'] == 0){
							header('Location: index.php');
						}else{
							header('Location: ../../');
						}
						session_destroy();
						print "<script type='text/javascript' > alert('Sessão expirada');</script>";
					}
					
				}
				else{
					 $_SESSION["sessiontime"] = time() + 60 * 5;
				}
			}
			else
			{
				
				$codigoUser = $_SESSION['codigoUser'];
				$mudaStatus = "UPDATE `usuario` SET usu_status = '0' WHERE usu_codigo = $codigoUser";
					if($this->execute($mudaStatus)){
						session_unset();
						session_destroy();
						print "<script type='text/javascript' > alert('Sessão expirada')</script>";
					}
				
				
			}
		}



	}

}

?>