<?php 

    class Conserto {

        public $id_Concerto;
        public $id_User;
        public $id_aparelho;
        public $Descricao;
        public $Nome;
        public $CPF;
        public $Nota_Fiscal;
        public $Garantia;
        public $Atualizacoes;
        public $Apagar;
        public $Telefone;
        public $Termos;
        public $status;
        public $PrecoPeca;
        public $MetodoPagamento;
        public $Parcelas;
        public $GarantiaExtendida;
        public $PrecoTotal;
    }

    interface ConsertoDAOInterface {

        public function buildConserto($data); //pagando
        public function create(Conserto $conserto); //pegando
        public function protocolocliente($id);
        public function protocoloByID($id);
        
    }