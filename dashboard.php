<?php
session_start();
require("inc/conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Obtém informações do usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sqlUsuario = "SELECT nome, email FROM usuario WHERE id = ?";
$stmtUsuario = mysqli_prepare($conn, $sqlUsuario);
mysqli_stmt_bind_param($stmtUsuario, "i", $usuario_id);
mysqli_stmt_execute($stmtUsuario);
$resultUsuario = mysqli_stmt_get_result($stmtUsuario);
$usuario = mysqli_fetch_assoc($resultUsuario);

// Obtém contagem de ouvidorias por tipo
$sqlOuvidorias = "SELECT tipo, COUNT(*) as count FROM ouvidoria GROUP BY tipo";
$resultOuvidorias = mysqli_query($conn, $sqlOuvidorias);
$ouvidorias = [];
while ($row = mysqli_fetch_assoc($resultOuvidorias)) {
    $ouvidorias[$row['tipo']] = $row['count'];
}

mysqli_close($conn);
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Ouvidoria Municipal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include("inc/navbar.php"); ?>

    <div class="container mt-5">
        <h1>Bem-vindo, <?php echo htmlspecialchars($usuario['nome']); ?>!</h1>
        <p>Seu e-mail: <?php echo htmlspecialchars($usuario['email']); ?></p>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ouvidorias</h5>
                        <p class="card-text">Reclamações: <?php echo isset($ouvidorias['Reclamação']) ? $ouvidorias['Reclamação'] : 0; ?></p>
                        <p class="card-text">Sugestões: <?php echo isset($ouvidorias['Sugestão']) ? $ouvidorias['Sugestão'] : 0; ?></p>
                        <p class="card-text">Denúncias: <?php echo isset($ouvidorias['Denúncia']) ? $ouvidorias['Denúncia'] : 0; ?></p>
                        <p class="card-text">Elogios: <?php echo isset($ouvidorias['Elogio']) ? $ouvidorias['Elogio'] : 0; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Acesso Rápido</h5>
                        <a href="ouvidoria.php" class="btn btn-primary">Abrir Ouvidoria</a>
                        <a href="ver_ouvidorias.php" class="btn btn-secondary">Ver Ouvidorias</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
