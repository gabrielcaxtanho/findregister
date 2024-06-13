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

// Consulta SQL para selecionar registros pelo número
$numero = isset($_GET['numero']) ? $_GET['numero'] : '';
$sql_select = "SELECT peca, numero, localarmazenamento, observacoes FROM pecas WHERE numero LIKE :numero";
$stmt_select = $dbh->prepare($sql_select);
$stmt_select->bindValue(':numero', "%$numero%");
$stmt_select->execute();

// Verifica se há erro na execução da consulta
if ($stmt_select->errorCode() != '00000') {
    die('Erro na consulta SQL: ' . $stmt_select->errorInfo()[2]);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Peças Cadastradas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/estoque.css">
    <script src="https://kit.fontawesome.com/c0eae24639.js" crossorigin="anonymous"></script>
</head>
<body>
    <main class="rodape">
        <h1 class="rodape__texto"><i class="fa-brands fa-codepen fa-2xl" style="color: #ffffff; padding: 5px;"></i>FIND REGISTER</h1>
        <h3 class="rodape__texto" style=" padding: 10px;">TODOS SEUS REGISTROS EM UM SÓ LUGAR</h3>
    </main>


    <section class="secao">
        <h2 class="secao_elemento">HISTORICO</h2>
    </section>


    <div class="principal__elemento">
        <form method="get" action="">
            <label for="numero">NÚMERO DE PATRIMÔNIO:</label>
            <input type="text" id="numero" class="numero" name="numero" value="<?= htmlspecialchars($numero) ?>">
            <button type="submit" id="submit">BUSCAR</button>
            <button type="button" class="button" role="button" onclick="window.location.href='./index.php'">CANCELAR</button>
            <button onclick="window.print()" class="button" >IMPRIMIR RELATORIO</button>

        </form>
    </div>

    <section class="resultado" id="secaoPecas" style="display: block;">
        <div class="cards-container" id="secaoPecas">
            <?php while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="card">
                <h3><?= htmlspecialchars($row['peca']) ?></h3>
                <p><strong>PEÇA:</strong> <?= htmlspecialchars($row['peca']) ?></p>
                <p><strong>NÚMERO DE PATRIMÔNIO:</strong> <?= htmlspecialchars($row['numero']) ?></p>
                <p><strong>LOCAL ARMAZENADO:</strong> <?= htmlspecialchars($row['localarmazenamento']) ?></p>
                <p><strong>Observações:</strong> <?= htmlspecialchars($row['observacoes']) ?></p>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
</body>
</html>
