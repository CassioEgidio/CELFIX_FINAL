<?php
    $pageTitle = "Celfix";
    $pageCSS = ["faleconosco2.css"];
    $pageJS = ["faleconosco.js"];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/DAO/UserDAO.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(false);

    include $BASE_PATH . 'src/View/header.php';

?>

    <main>
        <div class="container">
            <div class="esquerda">

                <form action="<?= $BASE_URL ?>../src/Controller/faleconoscoprocessamento.php" method="post">  

                    <input type="hidden" name="type" value="faleconosco">

                    <div class="envolta">
                            <div class="txt_field">
                                <input type="text" id="nome" name="nome" required>
                                <span></span>
                                <label>Nome</label>
                            </div>

                            <div class="txt_field">
                                <input type="email" id="email" name="email" required>
                                <span></span>
                                <label>Email</label>
                            </div>

                            <textarea id="mensagem" name="mensagem" rows="5" cols="50" placeholder="Escreva sua mensagem aqui..."></textarea>

                    </div>

                    <div class="divbotao">
                        <input class="botao" type="submit" value="Enviar">
                    </div>

                </form>

            </div>

            <div class="direita">

                <div class="conteudoesquerdatodo">
                    <div class="chatbotvisual">
                    <ul id="messageList" class="message-list"></ul>

                    <!-- aqui começa o input -->
                    <div class="searchbar-chatbot">
                        <div class="search-chatbot">
                        <input
                            id="messageInput"
                            type="text"
                            name=""
                            placeholder="Mensagem"
                            class="search-box-chatbot"
                        />
                        </div>
                        <a onclick="addMessage()" class="searchbtn-chatbot">
                        <img src="imagens/send.png" alt="envie" />
                        </a>
                    </div>
                    <!-- acaba -->
                    </div>
                </div>

                </div>
            </div>
    </main>

<?php
    include $BASE_PATH . 'src/View/footer.php';
?>