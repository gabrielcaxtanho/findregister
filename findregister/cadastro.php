<?php
require 'conexao.php';

$mensagem = '';

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os valores do formulário
    $peca = $_POST['peca'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $localarmazenamento = $_POST['localarmazenamento'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';

    try {
        // Cria a consulta SQL para inserção
        $sql = "INSERT INTO pecas (peca, numero, localarmazenamento, observacoes) 
                VALUES (:peca, :numero, :localarmazenamento, :observacoes)";
        
        // Prepara a consulta
        $stmt = $dbh->prepare($sql);
        
        // Vincula os parâmetros
        $stmt->bindParam(':peca', $peca);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':localarmazenamento', $localarmazenamento);
        $stmt->bindParam(':observacoes', $observacoes);
        
        // Executa a consulta
        $stmt->execute();

        $mensagem = "<p style='color: green; text-align: center; font-size: 1.5em;'>Dados inseridos com sucesso!</p>";

    } catch (PDOException $e) {
        // Exibe uma mensagem de erro em caso de falha na inserção
        $mensagem = 'Falha na inserção: ' . $e->getMessage();
    }
}

// Consulta SQL para selecionar todos os registros
$sql_select = "SELECT peca, numero, localarmazenamento, observacoes FROM pecas";
$stmt_select = $dbh->query($sql_select);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Peças</title>
    <link rel="stylesheet" href="css/cadastro_style.css">
</head>
<body>
    <main class="rodape">
        <h1 class="rodape__texto"><i class="fa-brands fa-codepen fa-2xl" style="color: #ffffff; padding: 5px;"></i>FIND REGISTER</h1>
        <h3 class="rodape__texto" style="padding: 10px;">TODOS SEUS REGISTROS EM UM SO LUGAR</h3>
    </main>

    <?php if ($mensagem): ?>
        <section class="mensagem">
            <?= $mensagem ?>
        </section>
    <?php endif; ?>

    <section class="principal">
        <section class="principal__imagemfundo">
            <div class="principal__elemento">
               <section class="formulario_central">
                    <h1>CADASTRO DE PEÇAS</h1>
                    <form action="" method="post" class="formulario">  
                        <div class="elemento_formulario">
                            <label for="peca">PEÇA:</label>
                            <input class="campo" type="text" id="peca" name="peca" required>
                        </div>
                        <div class="elemento_formulario">
                            <label for="numero">NUMERO PATRIMONIO:</label>
                            <input class="campo" type="text" id="numero" name="numero" required>
                        </div>
                        <div class="elemento_formulario">
                            <label for="localarmazenamento">LOCAL ARMAZENADO:</label>
                            <input class="campo" type="text" id="localarmazenamento" name="localarmazenamento" required>
                        </div>
                        <div class="elemento_formulario">
                            <label for="observacoes">OBSERVAÇÕES:</label>
                            <input class="campo" type="text" id="observacoes" name="observacoes" required>
                        </div>
                        <div class="elemento_formulario_botoes">
                            <button type="submit" class="button-19" role="button">CADASTRAR PEÇA NO ESTOQUE</button>
                            <button type="button" class="button-19_2" role="button" onclick="window.location.href='./index.php'">CANCELAR</button>
                        </div>
                    </form>
               </section>
            </div>
        </section>
    </section>

    <script src="https://kit.fontawesome.com/c0eae24639.js" crossorigin="anonymous"></script>
</body>
</html>
