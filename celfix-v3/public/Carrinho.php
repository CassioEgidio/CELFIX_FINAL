<?php
    $pageTitle = "Celfix";
    $pageCSS = ["carrinho111.css"];
    $pageJS = [""];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include $BASE_PATH . 'src/View/header.php';

    include_once($BASE_PATH . 'src/Models/Carrinho.php');
    include_once($BASE_PATH . 'src/DAO/CarrinhoDAO.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $user = new User();

    $userData = $userDao->verifyToken(true);

    $carrinhoDao = new CarrinhoDAO($conn, $BASE_URL);

    $carrinhos = $carrinhoDao->findcarrinhoporid($userData->id);

    $Qprod = 0;

    //print_r($carrinhos);exit();
?>

<main>
  <div class="tudo">
    <div class="esquerda">

        <div class="informa">

          <div class="row car-row">
              <p class="car-caer">Carrinho de Compras</p>
                <p class="car-num">
                    (<?php 
                        if (!empty($carrinhos)) { 
                            $Qprod = count($carrinhos);
                        } 
                        echo $Qprod;
                    ?>)
                </p>
          </div>

          <div class="row car-row">
              <p class="car-li">Limpar</p>
          </div>

        </div>

        <div class="itens" id="itemContainer">
        <?php if($Qprod != 0): ?>
            <?php foreach($carrinhos as $carrinho): 

            if($carrinho->frete == false) {
                $carrinho->frete = "25.90";
            } else {
                $carrinho->frete = "Grátis";
            } ?>

            <div class="item1">
                <div class="diviso">
                
                    <form action="<?= $BASE_URL ?>../src/Controller/carrinhoprocess2.php" method="POST">
                        <input type="hidden"name="idcarrinho" value="<?= $carrinho->id_Carrinho?>">
                        <input type="submit" class="btcex" value="excluir">
                    </form>
                    <img class="im" src="<?= $BASE_URL?>imagens/produtos/<?= $carrinho->imagens[0]?>" alt="Celular">
                    <span class="left-text2">
                        <p><?= $carrinho->titulo?></p>
                        <h2>R$ <?= $carrinho->precoavista?></h2>
                        Frete: <p class="car-li"><?= $carrinho->frete?></p>
                    </span>
                    <div class="button-group">
                        <span class="right-btn">-</span>
                        <h1 class="quantity">0</h1>
                        <span class="left-btn">+</span>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>   
        <?php endif; ?>
        </div>

        <form id="productForm" action="process_products.php" method="POST">
            <!-- Inputs ocultos serão adicionados dinamicamente -->
        </form>

    </div>

    <div class="direita">
    <div class="superior">
        <p class="titulo">Resumo</p>
        
        <div class="row total-row">
            <p class="titul">SubTotal</p>
            <p class="total-price">R$ 0,00</p> 
        </div>

        <div class="row total-row2">
            <p class="titul">Frete</p>
            <p class="total-price2">R$ 0,00</p> 
        </div>

        <div class="row total-row3">
            <p class="titulo">Total</p>
            <p class="total-price3">R$ 0,00</p> 
        </div>

       
        <div class="button-container">
            <button class="butPagar">Continuar</button>
        </div>
    </div>
</div>



    </div>
  </div>

</main>



<footer></footer>
<script src="autocompletar.js"></script>
<script src="Carrinho.js"></script>
</body>

</html>



<script>


document.querySelectorAll('.item1').forEach(item => {
    const quantityElement = item.querySelector('.quantity'); // Localizar a quantidade dentro deste item
    const incrementButton = item.querySelector('.left-btn'); // Botão de incremento
    const decrementButton = item.querySelector('.right-btn'); // Botão de decremento
    const priceElement = item.querySelector('h2'); // Preço do item
    const freteElement = item.querySelector('.car-li'); // Elemento do frete
    const precoUnitario = parseFloat(priceElement.textContent.replace('R$', '').replace(',', '.')); // Preço unitário do item
    let freteValor = 0; // Inicializa o valor do frete

    // Verifica se o frete é grátis ou tem um valor
    if (freteElement.textContent.includes('Grátis')) {
        freteValor = 0; // Frete grátis
    } else {
        freteValor = parseFloat(freteElement.textContent.replace('Frete: R$', '').replace(',', '.')); // Extrai o valor do frete
    }

    // Função para atualizar o preço total do item
    function updateTotalPrice() {
        const quantity = parseInt(quantityElement.textContent, 10); // Quantidade atual
        let totalPrice = precoUnitario * quantity; // Preço total sem frete
        let totalWithFrete = totalPrice + (quantity > 0 ? freteValor : 0); // Soma o frete somente se houver itens selecionados
        updateTotalCarrinho(); // Atualiza o total do carrinho

        // Exibe o total com o valor correto no card
        return totalWithFrete;
    }

    // Função para atualizar o total do carrinho
    function updateTotalCarrinho() {
        let totalProdutos = 0;
        let totalFrete = 0;

        document.querySelectorAll('.item1').forEach(item => {
            const quantity = parseInt(item.querySelector('.quantity').textContent, 10);
            const price = parseFloat(item.querySelector('h2').textContent.replace('R$', '').replace(',', '.'));
            let frete = 0;
            const freteElement = item.querySelector('.car-li');
            if (!freteElement.textContent.includes('Grátis')) {
                frete = parseFloat(freteElement.textContent.replace('Frete: R$', '').replace(',', '.'));
            }

            // Se o item tiver quantidade > 0, soma o valor do produto e o frete
            if (quantity > 0) {
                totalProdutos += price * quantity;
                totalFrete += frete;
            }
        });

        // Atualiza o subtotal (valor dos produtos)
        document.querySelector('.total-price').textContent = `R$ ${totalProdutos.toFixed(2)}`;

        // Atualiza o valor do frete
        document.querySelector('.total-price2').textContent = `R$ ${totalFrete.toFixed(2)}`;

        // Atualiza o total final (soma de produtos + frete)
        document.querySelector('.total-price3').textContent = `R$ ${(totalProdutos + totalFrete).toFixed(2)}`;
    }

    // Incrementar a quantidade
    incrementButton.addEventListener('click', () => {
        let currentQuantity = parseInt(quantityElement.textContent, 10);
        quantityElement.textContent = currentQuantity + 1;
        updateTotalPrice();
    });

    // Decrementar a quantidade (não permite valores negativos)
    decrementButton.addEventListener('click', () => {
        let currentQuantity = parseInt(quantityElement.textContent, 10);
        if (currentQuantity > 0) { // Impede que fique negativo
            quantityElement.textContent = currentQuantity - 1;
            updateTotalPrice();
        }
    });

    // Inicializa o total do carrinho ao carregar a página
    updateTotalCarrinho();
});


</script>