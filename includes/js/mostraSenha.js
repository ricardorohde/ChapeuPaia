$(document).ready(function() {
    $("#BtnViewHidden").click(function() {
        var src = $(this).find(".eyePerfil").attr("src");
        if (src == '../img/icons/view.png')
        {
            $(".eyePerfil").attr('src', '../img/icons/hide.png');
            $(".SenhaPerfil").attr('type', 'password');
        }
        if (src == "../img/icons/hide.png")
        {
            $(".eyePerfil").attr('src', '../img/icons/view.png');
            $(".SenhaPerfil").attr('type', 'text');
        }
    });
    $("#BtnViewHiddenAdm").click(function() {
        var src = $(this).find(".eyeCadastroAdm").attr("src");
        if (src == '../img/icons/view.png')
        {
            $(".eyeCadastroAdm").attr('src', '../img/icons/hide.png');
            $(".SenhaCadastroAdm").attr('type', 'password');
        }
        if (src == "../img/icons/hide.png")
        {
            $(".eyeCadastroAdm").attr('src', '../img/icons/view.png');
            $(".SenhaCadastroAdm").attr('type', 'text');
        }
    });
    $("#BtnViewHiddenCadastro").click(function() {
        var src = $(this).find(".eyeCadastrar").attr("src");
        if (src == 'includes/img/icons/view.png')
        {
            $(".eyeCadastrar").attr('src', 'includes/img/icons/hide.png');
            $(".SenhaCadastro").attr('type', 'password');
        }
        if (src == "includes/img/icons/hide.png")
        {
            $(".eyeCadastrar").attr('src', 'includes/img/icons/view.png');
            $(".SenhaCadastro").attr('type', 'text');
        }
    });
    $("#BtnViewHiddenLogin").click(function() {
        var src = $(this).find(".eyeLogin").attr("src");
        if (src == 'includes/img/icons/view.png')
        {
            
            $(".eyeLogin").attr('src', 'includes/img/icons/hide.png');
            $(".SenhaLogin").attr('type', 'password');
        }
        if (src == "includes/img/icons/hide.png")
        {
            $(".eyeLogin").attr('src', 'includes/img/icons/view.png');
            $(".SenhaLogin").attr('type', 'text');
        }
    });
});
