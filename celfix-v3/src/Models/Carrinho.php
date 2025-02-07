<?php

    class Carrinho {

        public $id_Carrinho;
        public $Id_User;
        public $Id_Prod;

    }

    interface CarrinhoDAOInterface {

        public function buildCarrinho($data);
        public function create($id_user, $id_produto);
        public function findcarrinhoporid($user_id);
        public function deleteCarrinho($idcarrinho);

    }