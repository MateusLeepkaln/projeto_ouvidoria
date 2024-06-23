<?php
require("inc/conexao.php");

function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

if (isset($_GET['token'])) {
    $token = sanitizeInput($_GET['token']);

    // Verifica se o token é válido
    $sql = "SELECT * FROM usuario WHERE hash = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultado)) {
        // Atualiza o status do usuário para ativado
        $sqlUpdate = "UPDATE usuario SET ativacao = NOW(), status = 'ativo' WHERE hash = ?";
        $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);

        if (!$stmtUpdate) {
            die("Erro ao preparar a consulta de atualização: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmtUpdate, "s", $token);

        if (mysqli_stmt_execute($stmtUpdate)) {
            echo "<div class='alert alert-success' role='alert'>Conta ativada com sucesso! Você pode fazer login agora.</div>
            <br>
            <a class='btn btn-primary' href='login.php' role='button'>Ir para o login</a>
            ";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro ao ativar a conta: " . mysqli_error($conn) . "</div>
            <br>
            <a class='btn btn-primary' href='cadastro.php' role='button'>Voltar</a>
            ";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Token inválido ou expirado!</div>
        <br>
        <a class='btn btn-primary' href='cadastro.php' role='button'>Voltar</a>
        ";
    }

    mysqli_close($conn);
} else {
    echo "<div class='alert alert-danger' role='alert'>Token não fornecido!</div>
    <br>
    <a class='btn btn-primary' href='cadastro.php' role='button'>Voltar</a>
    ";
}
?>
