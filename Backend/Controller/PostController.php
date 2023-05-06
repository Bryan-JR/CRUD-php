<?php


require_once 'Model/Persona.php';


class PostController
{

    private $post;


    public function __construct()
    {
        $this->post = new Persona();
    }


    public function list()
    {      
        $data = $this->post->getAll();

        header('Content-type:application/json;charset=utf-8');
        echo json_encode([
            'datos' => $data
        ]);

    }

    public function store()
    {

        echo "Esta es la acción store()";
    }
    
    public function update()
    {

        echo "Esta es la acción update()";
    }
    
}