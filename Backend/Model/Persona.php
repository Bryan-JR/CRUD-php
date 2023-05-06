<?php

include 'Model/DAO.php';

class Persona extends DAO
{


    protected $table = "persona";


    public function getAll()
    {
        $result = $this->selectAll();
        return $result;
    }

    
    public function getById($id) 
    {
        //
    }


    public function store($data) {
        // 
    }


    public function update($id, $data) {}


    public function delete($id) {}

    

    
    
}