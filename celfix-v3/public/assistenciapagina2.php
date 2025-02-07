<?php
    $pageTitle = "Celfix";
    $pageCSS = ["assistenciapagi2.css"];
    $pageJS = ["assistenciapagina2.js"];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/DAO/UserDAO.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(true);

    include $BASE_PATH . 'src/View/header.php';

    $marca = filter_input(INPUT_POST, "marca");
    $aparelho = filter_input(INPUT_POST, "aparelho");
    $descricao = filter_input(INPUT_POST, "descricao");
    $idaparelho = filter_input(INPUT_POST, "idapar");
    $idusuario = filter_input(INPUT_POST, "idusuario");

?>
    <main>
        <div class="formulario">
            <form method="post" class="fo" action="<?= $BASE_URL ?>../src/Controller/assistencia1.php">

                <input type="hidden" name="type" value="assistencia">
                <input type="hidden" name="marca" value="<?=$marca?>">
                <input type="hidden" name="aparelho" value="<?=$aparelho?>">
                <input type="hidden" name="descricao" value="<?=$descricao?>">
                <input type="hidden" name="idapar" value="<?=$idaparelho?>">
                <input type="hidden" name="idusuario" value="<?=$idusuario?>">

                <div class="form-group">
                    <div class="txt_field seg1">
                        <input type="text" name="Nome" value="<?= $userData->name ?>" required class="in1">
                        <span></span>
                        <label>Nome</label>
                    </div>
                    
                    <div class="txt_field seg1">
                        <input type="text" name="CPF" value="<?= $userData->cpf ?>" required class="in1">
                        <span></span>
                        <label>CPF</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="nota-fiscal">
                        <label class="nota-fiscal-label">Possui nota fiscal?</label>
                        <div class="radio-group">
                            <input type="radio" name="nota-fiscal" value="1" class="radio" id="nota-sim" required>
                            <label class="item" for="nota-sim">Sim</label>
                            <div class="separator">|</div>
                            <input type="radio" name="nota-fiscal" value="0" class="radio" id="nota-nao" required>
                            <label class="item" for="nota-nao">Não</label>
                        </div>
                    </div>

                    <div class="garantia">
                        <label class="nota-fiscal-label">Está dentro da garantia?</label>
                        <div class="radio-group">
                            <input type="radio" name="garantia" value="1" class="radio" id="garantia-sim" required>
                            <label class="item" for="garantia-sim">Sim</label>
                            <div class="separator">|</div>
                            <input type="radio" name="garantia" value="0" class="radio" id="garantia-nao" required>
                            <label class="item" for="garantia-nao">Não</label>
                        </div>
                    </div>
                </div>

                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="Atualizacoes" class="checkbox" value="1">
                        <span class="checkbox-custom"></span>
                        Quer receber atualizações sobre seu aparelho via e-mail e SMS?
                    </label>
                    <p class="informacao-negacao">Para negar, apenas não marcar essa caixa</p>
                </div>

                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="Apagar" class="checkbox" value="1" required>
                        <span class="checkbox-custom"></span>
                        Está ciente que podemos apagar todas as informações do aparelho se necessário?
                    </label>
                </div>

                <div class="form-group">
                    <div class="txt_field seg1 meio">
                        <input type="text" value="<?= $userData->telefone ?>" required class="in1" id="telefone" name="Telefone">
                        <span></span>
                        <label>Telefone</label>
                    </div>
                </div>

                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="Termos" class="checkbox" value="1" required>
                        <span class="checkbox-custom"></span>
                        Eu aceito os Termos e Condições
                    </label>
                    <a href="#" class="informacao-negacao">Ver Termos</a>
                </div>
            
                <div class="avanc">
                    <input type="submit" id="submit-button" value="Avançar" disabled>
                </div>
            </form>
        </div>
    </main>

</body>
</html>