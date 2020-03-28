<?php 
/*
    Plugin Name: GA Artist REST API
    Plugin URI:
    Description: Añade funcionalidad Scroll infinito ajax y rest api wordpress
    Version: 1.0
    Author: Edison Perdomo
    Author URI:
    License: GLP2
    Licence URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

function ga_rest_api_scripts(){
  wp_enqueue_script('jquery');
  wp_enqueue_script('ga-recetas-js', plugin_dir_url(__FILE__) . 'ga-rest-api.js' );

  wp_localize_script(
    'ga-recetas-js',
    'ruta_rest_api',
    array(
      'url' => rest_url('wp/v2/recetas-api/')
    )
  );

}
add_action('wp_enqueue_scripts', 'ga_rest_api_scripts');


function ga_rest_api(){

  //retorna el id del post anterior
  register_rest_field( 
    'recetas', 
    'ga_receta_anterior', //nombre del campo en la api rest
    array(
      'get_callback' => 'ga_receta_anterior_ID', // es la funcion retorna id
      'schema' => null,
      'update_callback' => null
    ), 
  );

  //retonas los valores metabox
  register_rest_field( 
    'recetas', 
    'ga_receta_meta_informacion', //nombre del campo en la api rest
    array(
      'get_callback' => 'ga_receta_meta', // es la funcion retorna id
      'schema' => null,
      'update_callback' => null
    ), 
  );

  //retona las taxonomia
  register_rest_field( 
    'recetas', 
    'ga_receta_taxonomia', //nombre del campo en la api rest
    array(
      'get_callback' => 'ga_receta_taxonomia', // es la funcion retorna id
      'schema' => null,
      'update_callback' => null
    ), 
  );

  //retorna los terminos de las taxonomia
  register_rest_field( 
    'recetas', 
    'ga_receta_termino_precio', //nombre del campo en la api rest
    array(
      'get_callback' => 'ga_receta_termino_precio', // es la funcion retorna id
      'schema' => null,
      'update_callback' => null
    ), 
  );

  register_rest_field( 
    'recetas', 
    'ga_receta_termino_tipo', //nombre del campo en la api rest
    array(
      'get_callback' => 'ga_receta_termino_tipo', // es la funcion retorna id
      'schema' => null,
      'update_callback' => null
    ), 
  );

  register_rest_field( 
    'recetas', 
    'ga_receta_termino_horario', //nombre del campo en la api rest
    array(
      'get_callback' => 'ga_receta_termino_horario', // es la funcion retorna id
      'schema' => null,
      'update_callback' => null
    ), 
  );

  register_rest_field( 
    'recetas', 
    'ga_receta_termino_estado', //nombre del campo en la api rest
    array(
      'get_callback' => 'ga_receta_termino_estado', // es la funcion retorna id
      'schema' => null,
      'update_callback' => null
    ), 
  );

}
add_action('rest_api_init', 'ga_rest_api');


function ga_receta_anterior_ID(){
  return get_previous_post()->ID;
}


function ga_receta_meta(){
  global $post;
  
  $post_id = $post->ID;
  return get_post_meta($post_id);
}

function ga_receta_taxonomia(){
  global $post;
  return get_object_taxonomies($post);
}

//retornando los termino de las taxonomia
function ga_receta_termino_precio(){
  global $post;
  $post_id = $post->ID;
  return get_the_term_list($post_id, 'precio_receta');
}

function ga_receta_termino_tipo(){
  global $post;
  $post_id = $post->ID;
  return get_the_term_list($post_id, 'tipo-comida');
}

function ga_receta_termino_horario(){
  global $post;
  $post_id = $post->ID;
  return get_the_term_list($post_id, 'horario-menu');   
}

function ga_receta_termino_estado(){
  global $post;
  $post_id = $post->ID;
  return get_the_term_list($post_id, 'estado');
}