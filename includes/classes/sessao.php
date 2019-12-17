<!-- //Código para adicionar no login para autenticar a sessão -->
<?php
	include 'Conexao.php';
	if(!isset($_SESSION['emailUser']) AND !isset($_SESSION['senhaUser']))
	{	
		session_start();
		session_unset();
        session_destroy();
		header('Location: index.php');
	}
	else
	{
		if(isset($_SESSION["sessiontime"])){
			if(isset($_SESSION["sessiontime"]) < time())
			{
				$codigoUser = $_SESSION['codigoUser'];
				$mudaStatus = "UPDATE `usuario` SET usu_status = '0' WHERE usu_codigo = $codigoUser";
				session_destroy();
				
				header('Location: index.php');
				print "<script type='text/javascript' > alert('Sessão expirada');</script>";
			}
			else{
				 $_SESSION["sessiontime"] = time() + 60 * 5;
			}
		}
		else
		{
			
			$codigoUser = $_SESSION['codigoUser'];
			$mudaStatus = "UPDATE `usuario` SET usu_status = '0' WHERE usu_codigo = $codigoUser";
			session_destroy();
			unset($_SESSION['email']);
			unset($_SESSION['senha']);
			unset($_SESSION['usuario']);
			unset($_SESSION['nivelacesso']);
			unset($_SESSION['usercodigo']);
			unset($_SESSION['serie']);
			header('Location:login.php');
			print "<script type='text/javascript' > alert('Sessão expirada')</script>";
			
		}
	}
?>

