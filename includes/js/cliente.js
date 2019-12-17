
function cadastraProduto(codigo) {

    $(".BxDadosCarrinho").css('display', 'block');
    $.ajax({
        url: "./includes/classes/cliente.php?proCompra=" + codigo
    }).done(function(msg) {
        document.getElementById('Msg').innerHTML = msg;
    });
    itensCarrinho(0);
    $("#clickCart").attr('checked', 'true');
    CarregaCarrinho();
}

function itensCarrinho(e)
{
    var xml = new XMLHttpRequest();
    xml.open('GET', 'includes/classes/cliente.php?pedido=' + e);
    xml.onload = function()
    {
        var itens = xml.response;
        itens = JSON.parse(itens);
        var DivCarrinho = document.getElementById('bxDadosCarrinho');
        DivCarrinho.innerHTML = itens;
    }
    xml.send();
}
function notification(e)
{
    var xml = new XMLHttpRequest();
    xml.open('GET', 'includes/classes/cliente.php?mensagens=' + e);
    xml.onload = function()
    {
        var itens2 = xml.response;
        itens2 = JSON.parse(itens2);
        var DivMensage = document.getElementById('bxDadosNotification');
        DivMensage.innerHTML = itens2;
    }
    xml.send();
}
function CarregaCarrinho() {
    var xml = new XMLHttpRequest();
    xml.open('GET', 'includes/classes/cliente.php?carrinho=' + 0);
    xml.onload = function()
    {
        var itensInside = xml.response;
        itensInside = itensInside;
        $("#Itens").attr('value', itensInside);
    }
    xml.send();
}
function CarregaMensagens() {
    var xml = new XMLHttpRequest();
    xml.open('GET', 'includes/classes/cliente.php?totalMensages=' + 0);
    xml.onload = function()
    {
        var itensInside2 = xml.response;
        itensInside2 = itensInside2;
        $("#Mensages").attr('value', itensInside2);
    }
    xml.send();
}
CarregaCarrinho();
CarregaMensagens();
$(document).ready(function() {
    $("#clickCart").click(function(event) {
        if ($("#clickNotification").is(':checked')) {
            $(".BxDadosNotification").css({'display': 'none'});

        }
        if ($("#clickCart").is(':checked')) {
            $(".BxDadosCarrinho").css({'display': 'block'});
        } else {
            $(".BxDadosCarrinho").css({'display': 'none'});
        }
    });
    $("#clickNotification").click(function(event) {
        if ($("#clickCart").is(':checked')) {
            $(".BxDadosCarrinho").css({'display': 'none'});


        }
        if ($("#clickNotification").is(':checked')) {

            $(".BxDadosNotification").css({'display': 'block'});
        } else {
            $(".BxDadosNotification").css({'display': 'none'});
            CarregaMensagens();
        }

    });

});
function validaLocation() {
    var form = document.querySelector("#FormLocation");

    form.addEventListener("submit", function(event) {
        var bairro = document.querySelector('.bairro');
        var rua = document.querySelector('.avenida');
        var numero = document.querySelector('.numeroCasa');
        if ((bairro.value == "") || (rua.value == "") || (numero.value == "")) {
            var alerta = document.querySelector(".alertError p");
            alerta.style.display = "block";
            event.preventDefault();
        } else {
            var bairroV = bairro.value;
            var ruaV = rua.value;
            var numeroV = numero.value;
            $.ajax({
                url: "./includes/classes/cliente.php?saveLocation&bairro=" + bairroV + "&rua=" + ruaV + "&numero=" + numeroV
            }).done(function(msg) {
                document.getElementById('Msg').innerHTML = msg;
            });
            $(document).ready(function() {
                $('#location').modal('hide');

            });
            window.location.reload(false);
        }

    });
}
function delProduto(codigo) {
    var resposta = confirm("Deseja remover esse produto?");
    if (resposta == true)
    {
        $.ajax({
            url: "./includes/classes/cliente.php?delProdutoSelected=" + codigo
        }).done(function(msg) {
            document.getElementById('Msg').innerHTML = msg;
        });
        window.location.reload(true);
    }
}