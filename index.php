<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ouvidoria Municipal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <?php include("inc/navbar.php"); ?>
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Bem-vindo à Ouvidoria Municipal!</h1>
            <p class="lead">Sua voz é importante para nós. Utilize este canal para registrar suas reclamações, sugestões ou denúncias.</p>
            <hr class="my-4">
            <p>Para abrir uma ouvidoria, você precisa estar logado. Caso ainda não tenha cadastro, clique no botão abaixo para se registrar.</p>
            <a class="btn btn-primary btn-lg" href="cadastro.php" role="button">Cadastrar</a>
            <a class="btn btn-success btn-lg" href="ouvidoria.php" role="button">Abrir Ouvidoria</a>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <h2>Como funciona?</h2>
                <p>É simples! Basta clicar em "Abrir Ouvidoria", preencher o formulário com os detalhes do seu caso e enviar.</p>
            </div>
            <div class="col-md-6">
                <h2>Tipos de Ouvidoria</h2>
                <ul>
                    <li>Reclamação</li>
                    <li>Sugestão</li>
                    <li>Denúncia</li>
                    <li>Elogio</li>
                </ul>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>
