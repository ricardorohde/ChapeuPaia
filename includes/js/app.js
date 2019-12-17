
var $target = $('.anime'), animationClass = 'anime-start', offset = $(window).height() * 3 / 4;
var $target2 = $('#Menu'), animationClassMenu = 'MenuAdd';

function animeScroll() {
    var documentTop = $(document).scrollTop();

    $target.each(function() {
        var itemTop = $(this).offset().top;
        if (documentTop > 30) {
            $target2.addClass(animationClassMenu);

        } else {
            $target2.removeClass(animationClassMenu);
        }
        if (documentTop > itemTop - offset) {
            $(this).addClass(animationClass);
        } else {
            $(this).removeClass(animationClass);
        }
    });

}
animeScroll();
$(document).scroll(function() {
    animeScroll();
});
/*Funcção do meu efeito no input*/
$(".textb .InputName").on("focus", function() {
    $(this).addClass('effectInput');
});
$(".textb .InputName").on("blur", function() {
    if ($(this).val() == "") {
        $(this).removeClass('effectInput');
    }
});
$(".textb .InputSenha").on("focus", function() {
    $(this).addClass('effectInput');
});
$(".textb .InputSenha").on("blur", function() {
    if ($(this).val() == "") {
        $(this).removeClass('effectInput');
    }
});
$("#InptEmail") && $("#InptPass").keyup(function() {

    var pressEmail = $("#InptEmail").val().length;
    var pressPass = $("#InptPass").val().length;
    if ((pressEmail > 0) && (pressPass > 0)) {
        $(".btnLogin").attr('type', 'submit');
        $(".btnLogin").css('background-position', 'right');
    } else if ((pressEmail == 0) || (pressPass == 0)) {
        $(".btnLogin").attr('type', 'button');
        $(".btnLogin").css('background-position', 'left');
    }
});
(function($) {
    "use strict";

    // manual carousel controls
    $('.next').click(function() {
        $('.carousel').carousel('next');
        return false;
    });
    $('.prev').click(function() {
        $('.carousel').carousel('prev');
        return false;
    });

})(jQuery);

function Add(id) {
    var input = document.getElementById(id);
    if (input.value <= 8) {
        input.value = Number(input.value) + 1;
        var codigo = document.querySelector('.' + id);
        var codigoV = codigo.value;
        var qtd = input.value;
        $.ajax({
            url: "./includes/classes/cliente.php?updatePro=" + codigoV + "&qtd=" + qtd
        }).done(function(msg) {
            document.getElementById('Msg').innerHTML = msg;
        });
        window.location.href = "produtos.php?cart";
    } else {
        input.value = input.value;
    }


}

function Sub(id) {
    var input = document.getElementById(id);
    if (input.value >= 1) {
        input.value = Number(input.value) - 1;
        if (input.value == 0) {
            var resposta = confirm("Deseja remover esse produto?");
            if (resposta == true)
            {
                var codigo = document.querySelector('.' + id);
                var codigoV = codigo.value;
                $.ajax({
                    url: "./includes/classes/cliente.php?delProdutoSelected=" + codigoV
                }).done(function(msg) {
                    document.getElementById('Msg').innerHTML = msg;
                });
                window.location.href = "produtos.php?cart";
            }

        } else {
            var codigo = document.querySelector('.' + id);
            var codigoV = codigo.value;
            var qtd = input.value
            $.ajax({
                url: "./includes/classes/cliente.php?updatePro=" + codigoV + "&qtd=" + qtd
            }).done(function(msg) {
                document.getElementById('Msg').innerHTML = msg;
            });
            window.location.href = "produtos.php?cart";
        }
    } else {
        input.value = input.value;
    }
}