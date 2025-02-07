<?php 

    class FaleConosco {

        public $id_fale;
        public $nome;
        public $email;
        public $mensagem;

    }

    interface FaleConoscoDAOInterface {

        public function buildFale($data); 
        public function create(FaleConosco $fale); 
        public function listar();

    }