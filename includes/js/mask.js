function mascara(mascara, documento) {
    var i = documento.value.length;
    var saida = mascara.substring(0, 1);
    var texto = mascara.substring(i);
    if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
    }
}
function muda() {
    $("#Cancel").click(function() {
        document.location.href = "index.php";
    });

}
function volta() {
    $("#Cancel").click(function() {
        document.location.href = "../../";
    });

}
function efeitoMenu() {
    jQuery(document).ready(function() {
        jQuery('.toggle-nav-sair').click(function(e) {
            jQuery(this).toggleClass('active');
            jQuery('.menuSair ul').toggleClass('active');

            e.preventDefault();
        });
    });
    
}
efeitoMenu();