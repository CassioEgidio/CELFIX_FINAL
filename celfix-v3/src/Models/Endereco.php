<?php

    class Endereco {

        public $ID_Endereco;
        public $ID_User;
        public $CEP;
        public $rua;
        public $bairro;
        public $cidade;
        public $estado;
        public $numero;
        public $Descricao;

    }

    interface EnderecoDAOInterface {

        public function buildEndereco($data);
    }