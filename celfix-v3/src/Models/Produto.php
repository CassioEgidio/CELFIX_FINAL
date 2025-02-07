<?php 

    class Produto {

        public $id;
        public $titulo;
        public $subtitulo;
        public $precoavista;
        public $precoparcelado;
        public $nparcelas;
        public $categoria;
        public $estoque;
        public $descricao;
        public $frete;
        public $data_criacao;
        public $imagens = [];
        public $produtos_comprados;

        public function imageGenerateName() {
            return bin2hex(random_bytes(60)) . ".jpg";
        }


    }

    interface ProdutoDAOInterface {

        public function buildProduto($data); //pagando
        public function create(Produto $produto); //pegando
        public function update(Produto $produto);
        public function getProdutoByCategory($category); //pegando
        public function findAll();
        public function findbytitle($title);
        public function findbyid($id);
        public function destroy($id);
        public function novacompraproduto($id);

    }