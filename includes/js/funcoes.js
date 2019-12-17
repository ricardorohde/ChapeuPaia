function confirmacaoCadastro(id)
{

    var resposta = confirm("Deseja remover esse registro?");
    if (resposta == true)
    {
        window.location.href = "?usuarios&excluirId=" + id;
    }
}
function confirmacaoDelTipo(id)
{

    var resposta = confirm("Deseja remover esse tipo? Será apagado todos itens dentro desse tipo");
    if (resposta == true)
    {
        window.location.href = "?produtos&tipoDelId=" + id;
    }
}
function confirmacaoConfirmPedidos(id, user)
{

    var resposta = confirm("Deseja confirmar esse pedido?");
    if (resposta == true)
    {
        window.location.href = "?pedidos&confirmPeid=" + id + "&user=" + user;
    }
}
function confirmacaoDelProdutos(id)
{

    var resposta = confirm("Deseja confirmar esse produto?Você perderá todos os dados");
    if (resposta == true)
    {
        window.location.href = "?produtos&excluirProduto=" + id;
    }
}

function confirmacaoDelPromocao(id)
{

    var resposta = confirm("Deseja confirmar essa promocao?Você perderá todos os dados");
    if (resposta == true)
    {
        window.location.href = "?promocoes&excluirPromocao=" + id;
    }
}
function confirmacaoDelPedidos(id)
{

    var resposta = confirm("Deseja deletar esse pedido?");
    if (resposta == true)
    {
        window.location.href = "?pedidos&idDel=" + id;
    }
}

function confirmacaoDelIngrediente(id) {
    var resposta = confirm("Deseja apagar esse ingrediente? Ele será excluído dos seus produtos");
    if (resposta == true)
    {
        window.location.href = "?ingredientes&ingredienteDelId=" + id;
    }
}
function confirmacaoBlock(id)
{
    var resposta = confirm("Deseja bloquear esse registro?");
    if (resposta == true)
    {
        window.location.href = "?usuarios&bloquear=" + id;
    }
}

function confirmacaoUnlock(id)
{
    var resposta = confirm("Deseja desbloquear esse registro?");
    if (resposta == true)
    {
        window.location.href = "?usuarios&desbloquear=" + id;
    }
    
}

$("#InputSearch").keyup(function() {
    var valor = $(this).val().length;
    if (valor == 0) {
        $("#BtnSearch").attr('type', 'button');
    } else {
        $("#BtnSearch").attr('type', 'submit');
    }
});
function previewImagem() {
    var imagem = document.querySelector('input[name=ImagemPerfil]').files[0];
    var preview = document.querySelector('#BoxImg');
    var reader = new FileReader();
    reader.onloadend = function() {
        preview.src = reader.result;
    }

    if (imagem) {
        reader.readAsDataURL(imagem);
    } else {
        preview.src = "";
    }
}
function previewImagemProduto() {
    var imagem = document.querySelector('input[name=imgPro]').files[0];
    var preview = document.querySelector('.imgDefautProduto');
    var reader = new FileReader();
    reader.onloadend = function() {
        preview.src = reader.result;
    }

    if (imagem) {
        reader.readAsDataURL(imagem);
    } else {
        preview.src = "../img/produtos/proDefaut.png";
    }
}
function previewEditProduto() {
    var imagem = document.querySelector('input[name=imgProEdit]').files[0];
    var preview = document.querySelector('.EditProdutoImg');
    var reader = new FileReader();
    reader.onloadend = function() {
        preview.src = reader.result;

    }

    if (imagem) {
        reader.readAsDataURL(imagem);
        $('input:imgProEdit').val(imagem);
    } else {
        preview.src = "../img/produtos/proDefaut.png";
    }
}

function previewImagemPromocaoEdit() {
    var imagem = document.querySelector('input[name=imgPromocaoEdit]').files[0];
    var preview = document.querySelector('.imgDefautPromocaoEdit');
    var reader = new FileReader();
    reader.onloadend = function() {
        preview.src = reader.result;
    }
    if (imagem) {
        reader.readAsDataURL(imagem);
    } else {
        preview.src = "../img/produtos/proDefaut.png";
    }
}
function previewImagemPromocao() {
    var imagem = document.querySelector('input[name=imgPromo]').files[0];
    var preview = document.querySelector('.imgDefautPromocao');
    var reader = new FileReader();
    reader.onloadend = function() {
        preview.src = reader.result;
    }

    if (imagem) {
        reader.readAsDataURL(imagem);
    } else {
        preview.src = "../img/produtos/proDefaut.png";
    }
}
function atualizarTipo(e)
{
    if (e.value == 1)
    {
        e.value = 0;
    } else if (e.value == 0)
    {
        e.value = 1;
    }

    tip_ativo = e.value;
    tip_codigo = e.name;
    var xml = new XMLHttpRequest();
    xml.open('GET', 'admin.php?produtos&tip_ativo=' + tip_ativo + '&tip_codigo=' + tip_codigo);
    xml.send();
    return xml;
}
$("#InputIngredienteName") && $("#InputValor").keyup(function() {

    var pressName = $("#InputIngredienteName").val().length;
    var pressValor = $("#InputValor").val().length;
    if ((pressName > 0) && (pressValor > 0)) {
        $("#BtnIgr").removeClass('BtnCadastraIngrediente');
        $("#BtnIgr").addClass('BtnCadastraIngredienteAfter');
        $("#BtnIgr").attr('type', 'submit');
    } else if ((pressName == 0) || (pressValor == 0)) {
        $("#BtnIgr").removeClass('BtnCadastraIngredienteAfter');
        $("#BtnIgr").addClass('BtnCadastraIngrediente');
        $("#BtnIgr").attr('type', 'button');
    }
});
function validaNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
        evt.preventDefault();
    }


}
function Formata(i) {
    var v = i.value.replace(/\D/g, '');
    v = (v / 100).toFixed(2) + '';
    v = v.replace(".", ",");
    v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
    v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
    i.value = v;

}



