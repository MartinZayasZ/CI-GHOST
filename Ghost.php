<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ghost {
    
    private $key;
    private $api_url;
    private $path = '/ghost/api/v3/content/';

    public function __construct(){
        $this->CI =& get_instance();
    }

    public function configure($domain = '', $key = ''){
        $this->key = $key;
        $this->api_url = $domain . $this->path;
    }

    //consulta las notas por filtro de página y limite
    public function get_all_posts( $page = 0, $limit = 4 ){
        //armamos nuestra url a consultar
        $url = $this->create_url('posts', array(
            'include' => 'authors,tags',
            'page' => $page,
            'limit' => $limit
        ));
        return $this->get_data($url);
    }

    //consulta de una nota por el slug
    public function get_post_by_slug( $slug ){
        //armamos nuestra url a consultar
        $url = $this->create_url("posts/slug/$slug", array(
            'include' => 'authors,tags'
        ));
        return $this->get_data($url);
    }

    //consulta de una nota por el id
    public function get_post_by_id( $id ){
        //armamos nuestra url a consultar
        $url = $this->create_url("posts/$id", array(
            'include' => 'authors,tags'
        ));
        return $this->get_data($url);
    }

    //consulta de notas por tag slug
    public function get_posts_by_tag( $tag_slug ){
        //armamos nuestra url a consultar
        $url = $this->create_url('posts', array(
            'include' => 'authors,tags',
            'filter' => "tag:$tag_slug"
        ));
        return $this->get_data($url);
    }
    

    //creamos la url 
    private function create_url($content, $filters_array){

        $filters = '';
        foreach($filters_array as $index => $filter){
            $filters .= "&$index=$filter";
        }

        return $this->api_url . $content . '?key=' . $this->key . $filters;
    }

    //consulta y decodifica contenido para mostrarlo
    private function get_data($url){
        //consultamos y convertimos de string a array
        $result = json_decode(file_get_contents($url), TRUE);
        
        //regresamos el valor consultado sin mover ningún valor
        return $result;
    }
}