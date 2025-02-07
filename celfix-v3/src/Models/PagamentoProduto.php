<?php 

    class PagamentoProduto {

        public $id_compra;
        public $id_produto;
        public $id_usuario;
        public $id_endereco;
        public $Status;
        public $preco_total;
        public $tipo_pagamento;
        public $n_parcelas;
        public $qtde_pecas_compradas;
        public $data_entrega;
        public $data_compra;

        public function getFutureDate() {
            $currentDate = new DateTime();
            $currentDate->modify('+7 days');
            return $currentDate->format('Y-m-d');
        }

    }

    interface PagamentoProdutoDAOInterface {

        public function buildPagamento($data); //pagando
        public function create(PagamentoProduto $pagamento); //pegando
        public function listarProtocolosporcliente($id);
        public function listarProtocolosporaadm();
        public function AtualizarStatus($Status, $ID_Compra);

    }