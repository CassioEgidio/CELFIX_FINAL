<?php 

    class Aparelho {

        public $id_aparelho;
        public $Descricao;
        public $Marca;
        public $image_aparelho;

    }

    interface AparelhoDAOInterface {

        public function buildAparelho($data); //pagando
        public function create(Aparelho $aparelho); //pegando
        public function findAll();
       
    }