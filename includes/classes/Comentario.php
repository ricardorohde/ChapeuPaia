<?php

class Comentario extends Conexao {

    function __construct() {
        parent::__construct();
    }

    public function getAllComents() {
        if ($com = $this->getAll("SELECT usu.*, com.* FROM comentario com, usuario usu WHERE com.usu_codigo = usu.usu_codigo ORDER BY com.com_comentario DESC LIMIT 6")) {
            $cont = 1;
            foreach ($com as $comentario) {
                if($cont == 1){
                    echo '<div class="d-block col-12 col-md-4 d-lg-block col-lg-2">';
                }
                if ($cont >= 4) {
                    echo '<div class="d-none d-md-none d-lg-block col-lg-2">';
                } 
                if($cont >= 2 && $cont < 4) {
                    echo '<div class="d-none d-md-block col-md-4 col-lg-2">';
                }
                echo '
                        <div class="bxComent">
                            <div class="bxImgComent">';

                if ($comentario['usu_foto'] == "userDefaut.png") {
                    $foto = 'userDefaut.png';
                } else {
                    $pasta = md5($comentario['usu_codigo']);
                    $foto = $pasta . '/' . $comentario['usu_foto'];
                }
                echo '<img src="includes/img/perfils/' . $foto . '" />
                            </div>
                            <div class="bxTextComent p-3">
                            <p class="nameComent mt-0 mb-0"">' .$comentario['usu_nome'] . '</p>
                            <p>'. $comentario['com_comentario'] . '</p>
                            </div>
                        </div>
                    </div>
                
                ';
                $cont++;
            }
        }
    }
    public function cadastra($comentario){
        $query = "INSERT INTO comentario(com_comentario, usu_codigo) VALUES ('$comentario', ".$_SESSION['codigoUser'].")";
        if($this->execute($query)){
            $_SESSION['comentarioEnviado'] = "true";
            header("Location: index.php");
        }
    }

}
