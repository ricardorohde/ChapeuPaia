$(document).ready(function() {
    $("#clickCart").click(function(event) {
        if ($("#clickCart").is(':checked')) {
            $(".BxDadosCarrinho").css({'display': 'block'});
        } else {
            $(".BxDadosCarrinho").css({'display': 'none'});
        }
    });
    $('.carousel').slick({
        dots: false,
        infinite: false,
        arrows: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: false
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }

        ]
    });

});
function buscaJs() {
    var input = document.getElementById('inptBsc');
    window.location.href = "produtos.php?filterName=" + input.value;
}