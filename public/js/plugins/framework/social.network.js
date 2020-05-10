var just_urlShare = document.location.href;
var elementShare = '[id^=count_facebook]';
if (typeof($("link[rel='canonical']")) != undefined) {
    if ($("link[rel='canonical']").attr("href") != "" && $("link[rel='canonical']").attr("href") != undefined) {
        just_urlShare = $("link[rel='canonical']").attr("href");
    }
}
var cont_facebook= 0;
function barraActiva(clase){
    if($('#boton_mail').hasClass('barra-activa')){
        $('#compartirEspecial').removeClass('barra-fija');
        $('#boton_mail').removeClass('barra-activa');
    }else{
        $('#compartirEspecial').addClass(clase);
        $('#boton_mail').addClass('barra-activa');
    }
}

function eliminarClaseBarra(){
    $('#compartirEspecial').removeClass('barra-fija');
    $('#boton_mail').removeClass('barra-activa');
}

/*$(document).ready(function() {
    var url = window.location.href;
    var twitterurl = 'http://urls.api.twitter.com/1/urls/count.json?url=' + url + '&callback=?';
    $.getJSON(twitterurl, function(json){
        $('#tweetcount').text(json.count);
    });
});*/

function esconderRedes(div) {


    if (div == 'caja_redes_compartir_abajo' || div == 'compartirEspecial' || div.indexOf('compartir')==0) {
        $('.flecha_box_compartir').animate({"opacity": "0"}, "fast");    
        $('#' + div).hide("slow");  
    } else if (div == 'panel_compartir') {
          $('.flecha_box_compartir').animate({"opacity": "0"}, "fast");
        $('.panel_compartir').animate({"height": "0px", "width": "100px", "background": "#393939", "position": "absolute", "padding": "0", "box-sizing": "border-box"}, "slow");
    } 
}
function aparecerRedes(div) {
    $('.flecha_box_compartir').animate({"opacity": "1"}, "fast");
    if(div == 'caja_redes_compartir_abajo' || div == 'compartirEspecial' || div.indexOf('compartir')==0 ) {  
        $('#' + div).show("slow");
    } else if (div == 'panel_compartir' ) {
        $('.'+div).animate({"height": "174px", "transition": "all .5s ease", "ms-transition": "all .5s ease", "-moz-transition": "all .5s ease", "-o-transition": "all .5s ease", "-webkit-transition": "all .5s ease", "margin-top": "8px", "padding": "9px" }, "fast");
    } 
}

var url_larga = window.location.href;
if (typeof($("link[rel='canonical']")) != undefined) {
    if ($("link[rel='canonical']").attr("href") != "" && $("link[rel='canonical']").attr("href") != undefined) {
        var url_larga = $("link[rel='canonical']").attr("href");
    }
}
var url_affected = false;
url_larga_ ="";
url_affected_ ="";

function compartiendo(redsocial, titulo_, url_larga_ , url_affected_ ){
    if(url_larga_ || typeof url_larga_ != "undefined"){
        url_larga  = url_larga_;
    }
    url_larga = (("http://" + location.hostname) == url_larga.substring(0, ("http://" + location.hostname).length) || 'http://bit.ly' == url_larga.substring(0, 13)) ? url_larga : 'http://' + location.hostname + url_larga ;
    if(url_affected_==true){
        url_affected= url_affected_;
    }
    var titulo = titulo_;
    if(!titulo || titulo === undefined || typeof titulo == "undefined"){
        titulo  = 'Un recomendado';
    }
    if(!redsocial){
        redsocial = 'twitter';
    }
    console.log(url_larga);
    if(!url_affected) {
        $.support.cors = true;
        $.ajax({
            url: "/comun/compartir",
            type: "POST",
            //dataType:"json",
            data: {a:15, url: url_larga + "?_"},
            async: true,
            cache: false,
            success: function(data) {
                var obj = $.parseJSON(data);
                url_affected = true;
                if (typeof(obj.data.url) != 'undefined'){
                    url_larga = obj.data.url;
                }
                emergente(redsocial, url_larga, titulo);
            },
            fail: function() {
                //console.log( "fail!" );
            },
            always: function() {
                //console.log( "always!" );
                //emergentes(redsocial, url_larga, titulo);
            },
            error: function (request, strError, strTipoError) {
                //console.log( "error!" );
                //console.log( "data!" + url_larga );
                //emergentes(redsocial, url_larga, titulo);
            }
        });
    }
    else{
        emergente(redsocial, url_larga, titulo);
    }
}
function obtenerUrlLarga(){
    if(url_larga_ || typeof url_larga_ != "undefined"){
        url_larga  = url_larga_;
    }
    if(!url_affected) {
        //$.support.cors = true;
        $.support.cors = true;
        $.ajax({
            url: "/comun/compartir",
            type: "POST",
            data: {a:15},
            async: true,
            cache: false,
            success: function(data) {
                var obj = $.parseJSON(data);
//                console.log(obj);
                url_affected = true;
                url_larga = obj.data.url;
                return url_larga;
            },
            fail: function() {
                return url_larga;
            },
            always: function() {
                return url_larga;
            },
            error: function (request, strError, strTipoError) {
                return url_larga;
            }
        });
    }
    else{
        return url_larga;
    }
}
function emergente (redsocial, url_larga, titulo) {

    if (redsocial == 'facebook'){
        var random = Math.floor(Math.random() * 1000000) + 100000;
        var ventfacebook= '';
        ventfacebook = window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url_larga.toString()) + '&f=' + random + '&g=' + random, '_blank', 'toolbar=0, status=0, width=650, height=365');
        actualizarContadores(ventfacebook, url_larga);
    } else if (redsocial == 'twitter' || redsocial == 'twiter') {
        var venttwitter= window.open('https://twitter.com/share?url='+url_larga+'&via=ELTIEMPO&text=' + titulo, '_blank', 'height=365,width=660');
        actualizarContadores(venttwitter, url_larga);
    } else if (redsocial == 'google') {
        var ventgoogle =  window.open('https://plus.google.com/share?url='+url_larga, '_blank', 'height=600,width=600');
        actualizarContadores(ventgoogle, url_larga);
    }
}

function activar_contador() {

    var just_url = document.location.href;//"http://www.eltiempo.com";

    if (typeof($("link[rel='canonical']")) != undefined) {
        if ($("link[rel='canonical']").attr("href") != "" && $("link[rel='canonical']").attr("href") != undefined) {
            var just_url = $("link[rel='canonical']").attr("href");
        }
    }
    //Para Google +

    var plusones;
    var contenedor_g = document.getElementById("count_google");
    var contenedorabajo_g = document.getElementById("count_google_abajo");
    if('withCredentials' in new XMLHttpRequest() && contenedor_g && contenedorabajo_g){
       var contenedor = document.getElementById("count_google");
       var contenedorabajo = document.getElementById("count_google_abajo");
    }
   
    //Para Twitter
    var contenedor_t = document.getElementById("count_twitter");
    var contenedorabajo_t = document.getElementById("count_twitter_abajo");
    if (contenedor_t) {
        contenedor_t.innerHTML = "0";
    }
    if (contenedorabajo_t) {
        contenedorabajo_t.innerHTML = "0";
    }
    //Para Facebook
    //var count_share = 0;
    cont_facebook = 0;
    var contador_t = $('[id^=count_facebook]');
    if (contador_t.length){
        (typeof(actualizarContadoresGnral) != "undefined") && actualizarContadoresGnral(0);
    }
}


function activar_contador_multiple(id_nota, just_url ) {
    
    //Para Google +
    var contenedor_g = $("#count_google" + id_nota);
    contenedor_g.html('0');
    //Para Twitter
    var contenedor_t = $("#count_twitter" + id_nota);
    if (contenedor_t) {
        contenedor_t.html('0');
    }
    //Para Facebook
    //var count_share = 0;
    var contador_t = $('#count_facebook'+id_nota);
    if (contador_t.length){
        (typeof(actualizarContadoresGnral) != "undefined") && actualizarContadoresGnral(id_nota);
    }
}

function actualizarContadores(ventana, url_larga) {
//    var time=1000;
//    var temporizador =  setInterval(function() {
//        if (ventana) {
//            if (ventana.closed) {
                if (typeof(url_larga) && url_larga != document.location.href && url_larga.split('/').pop()) {
                    id_nota = url_larga.split('/').pop();
                    activar_contador_multiple(id_nota, url_larga);
                } else {
                    activar_contador();
                }
//                if (time!=1000) {
//                    clearInterval(temporizador);
//                }
//                time=15000;
//            }
//        }
//    }, time);
}

function actualizarContadoresGnral(id_nota) {
    var cont_participa = 0;
    if (location.href.split("/").pop() == "" && id_nota != 0 && id_nota != "") {//Aplica solo para el HOME, cuando hay varios mÃ³dulos emergentes prendidos
        elementShare = '[id^=count_facebook' + id_nota + ']';
        if (!(cont_participa = parseInt($('[data-count-participa' + id_nota + ']').attr('data-count-participa' + id_nota)))) {
            cont_participa = 0;
        }
    } else {
        elementShare = '[id^=count_facebook]';
        id_nota = $('[data-update-cont]').attr('data-update-cont');
        if (!(cont_participa = parseInt($('[data-count-participa' + id_nota + ']').attr('data-count-participa' + id_nota)))) {
            cont_participa = 0;
        }
    }
    $.ajax({
        url: "https://graph.facebook.com/" + just_urlShare,
        dataType: 'json',
    }).done(function( data ) {
        if (typeof(data) != "undefined" && typeof(data.share) != "undefined") {
            if (typeof(data.share.share_count) != "undefined") {
                cont_facebook = data.share.share_count;
            }
        } else {
            //cont_facebook = 0;
        }
        if (!(cont_facebook = parseInt(cont_facebook))) {
            cont_facebook = 0;
        }
        if (!(cont_participa = parseInt($('[data-count-participa' + id_nota + ']').attr('data-count-participa' + id_nota)))) {
            cont_participa = 0;
        }
        $(elementShare).text(cont_facebook + cont_participa);
    }).error(function ( data ) {
        if (typeof(FB) != "undefined" && typeof(FB.api) != "undefined") {
            FB.api(
                '/',
                'GET',
                {
                    "id": just_urlShare,
                    "access_token": "621809747895524|hAyyoAVk_853LQEnlyoqqBW0Wok"
                },
                function (data) {
                    if (typeof(data) != "undefined" && typeof(data.share) != "undefined") {
                        if (typeof(data.share.share_count) != "undefined") {
                            cont_facebook = data.share.share_count;
                        }
                    }
                    if (!(cont_facebook = parseInt(cont_facebook))) {
                        cont_facebook = 0;
                    }
                    if (!(cont_participa = parseInt($('[data-count-participa' + id_nota + ']').attr('data-count-participa' + id_nota)))) {
                        cont_participa = 0;
                    }
                    $(elementShare).text(cont_facebook + cont_participa);
                }
            );
        }
    });
}