$ = jQuery.noConflict();

$(document).ready( function(){

  console.log(ruta_rest_api);

  var url_rest = ruta_rest_api.url;

  function scroll_post(){
    var receta_anterior = $('.receta_anterior').last();

    var posicion_scroll = receta_anterior.offset().top - $(window).outerHeight();

    $(window).scroll(function(event){

      if( posicion_scroll > $(window).scrollTop() ){
        return;
      }

      $(this).off(event);
      llamar_post();



    })

  }
  scroll_post();

  function llamar_post(){
    var receta_anterior_id = $('.receta_anterior').last().attr('data-receta-anterior');
    var json_url = url_rest + receta_anterior_id +'?&_embed=true';

    $.ajax({
      dataType: 'json',
      url: json_url
    }).done(function(receta){
      template_post(receta);
    })

    function template_post(receta){

      var title = receta.title.rendered;
      var img = receta._embedded['wp:featuredmedia'][0].media_details.sizes.full.source_url;
      var horaComida = receta.ga_recetas_termino_horario;
      var tipo = receta.ga_recetas_termino_tipo;
      var precio = receta.ga_recetas_termino_precio;
      var estado = receta.ga_recetas_termino_estado;

      var calorias = receta.ga_receta_meta_informacion.input_metabox;
      var calificacion = receta.ga_receta_meta_informacion['dropdown-metabox'];
      var textarea = receta.ga_receta_meta_informacion['textarea-metabox'];
      
      var contenido = receta.content.rendered;
      var recetaAnterior = receta.ga_receta_anterior;

      var nuevo_post = '<article>';
      nuevo_post += '<h1>'+title+'</h1>';
      nuevo_post += '<img src="'+img+'" >';
      nuevo_post += '<div class="entry-content>';

      nuevo_post +=   '<div class="taxonomia">';
      nuevo_post +=     '<div class="hora-comida">';
      nuevo_post +=       'hora de comida:' + horaComida;
      nuevo_post +=     '</div>';
      nuevo_post +=     '<div class="hora-comida">';
      nuevo_post +=       'hora de platillo:' + tipo;
      nuevo_post +=     '</div>';
      nuevo_post +=     '<div class="hora-comida">';
      nuevo_post +=       'Precio de comida:' + precio;
      nuevo_post +=     '</div>';
      nuevo_post +=     '<div class="hora-comida">';
      nuevo_post +=       'Estado de animo:' + estado;
      nuevo_post +=     '</div>';
      nuevo_post +=   '</div>';

      nuevo_post +=   '<div class="informacion-extra">';
      nuevo_post +=     '<div class="calorias">';
      nuevo_post +=       'Calorias:' + calorias;
      nuevo_post +=     '</div>';
      nuevo_post +=     '<div class="hora-comida">';
      nuevo_post +=       'calificacion:' + calificacion;
      nuevo_post +=     '</div>';
      nuevo_post +=     '<div class="hora-comida">';
      nuevo_post +=       'Parrafo:' + textarea;
      nuevo_post +=       'Contenido:' +contenido;
      nuevo_post +=     '</div>';
      nuevo_post +=     '<div class="hora-comida">';
      nuevo_post +=       'Estado de animo:' + estado;
      nuevo_post +=     '</div>';
      nuevo_post +=   '</div>';

      nuevo_post +=   '<a class="receta_anterior" data-receta-anterior="'+recetaAnterior+'">';
      nuevo_post +=   'Receta Anterior';
      nuevo_post +=   '<a/>';

      nuevo_post += '</div>';
      nuevo_post += '</article>';

      jQuery('article.recetas').append(nuevo_post);
      scroll_post();
      
    }

  }

})