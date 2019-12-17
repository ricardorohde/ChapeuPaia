function ValidarSenhaForca() {
    var senha = document.getElementById('InputSenhaCadastro').value;
    var forca = 0;
    if ((senha.length >= 4) && (senha.length <= 7)) {
        forca += 10;
    } else if (senha.length > 7) {
        forca += 25;
    }
    if ((senha.length >= 5) && (senha.match(/[a-z]+/))) {
        forca += 10;
    }
    if ((senha.length >= 6) && (senha.match(/[A-Z]+/))) {
        forca += 20;
    }
    if ((senha.length >= 7) && (senha.match(/[@#$%&*;]/))) {
        forca += 25;
    }
    mostrarForca(forca);

}
function mostrarForca(forca) {
    if (forca < 30) {
        document.getElementById("forca").innerHTML = '<div class="progress forcaSenha" style="width:100px;height:4px; border-radius: none;transition: all .3s;"><div class="progress-bar bg-danger" role="progressbar" style="width: 25%; height:4px; border-radius: none; transition:all .3s;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div><span class="forSenhaText">Fraca</span>';
    } else if ((forca >= 30) && (forca < 50)) {
        document.getElementById("forca").innerHTML = '<div class="progress forcaSenha" style="width:100px;height:4px; border-radius: none; transition:all .3s;"><div class="progress-bar bg-warning" role="progressbar" style="width: 45%; height:4px; border-radius: none;transition:all .3s;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div><span class="forSenhaText">Regular</span>';
    } else if ((forca >= 50) && (forca < 70)) {
        document.getElementById("forca").innerHTML = '<div class="progress forcaSenha" style="width:100px;height:4px; border-radius: none; transition:all .3s;"><div class="progress-bar bg-info" role="progressbar" style="width: 75%; height:4px; border-radius: none;transition:all .3s;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div><span class="forSenhaText">Boa</span>';
    } else if ((forca >= 70) && (forca < 100)) {
        document.getElementById("forca").innerHTML = '<div class="progress forcaSenha" style="width:100px;height:4px; border-radius: none; transition:all .3s;"><div class="progress-bar bg-success" role="progressbar" style="width: 100%; height:4px; border-radius: none;transition:all .3s;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div><span class="forSenhaText">Excelente</span>';
    }
}
