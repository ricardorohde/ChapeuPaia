function setProdutosCompra(id, e)
{
    if(e.checked == true)
    {
        var xml = new XMLHttpRequest();
        xml.open('GET' ,'../classes/setPromocao.php?id=' + id);
        xml.onload = function()
        {
            var str = xml.response;
            var selecionados = document.getElementById('selecionadosPromocao');
            selecionados.innerHTML += str;
        }
        xml.send();
    }else{
        if(e.checked == false){
            var xml = new XMLHttpRequest();
        xml.open('GET' ,'../classes/setPromocao.php?id=' + id);
        xml.onload = function()
        {
            var str = xml.response;
            var selecionados = document.getElementById('selecionadosPromocao');
            selecionados.innerHTML -= str;
        }
        xml.send();
        }
    } 
}
