<?php
session_start();
require 'inc/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function sanitizeInput($data) {
        return htmlspecialchars(trim($data));
    }

    $email = filter_var(sanitizeInput($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $senha = md5(sanitizeInput($_POST["senha"]));

    if (!$email) {
        $error = "E-mail inválido";
    } else {
        $sqlVerificaLogin = "SELECT id, nome FROM usuario WHERE email = ? AND senha = ? AND status = 'ativo'";
        $stmt = mysqli_prepare($conn, $sqlVerificaLogin);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $email, $senha);
            mysqli_stmt_execute($stmt);
            $resultadoLogin = mysqli_stmt_get_result($stmt);

            if ($resultadoLogin && mysqli_num_rows($resultadoLogin) > 0) {
                $user = mysqli_fetch_assoc($resultadoLogin);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nome'];
                error_log("Login successful for user: " . $user['nome']); // Log de sucesso de login

                // Verifique se não há saída antes deste ponto
                if (headers_sent()) {
                    error_log("Headers already sent, cannot redirect.");
                    echo "<script>window.location.href = 'ouvidoria.php';</script>";
                } else {
                    header("Location: ouvidoria.php");
                }
                exit;
            } else {
                $error = "Login ou senha inválidos, ou conta não ativada.";
            }

            mysqli_stmt_close($stmt); // Fecha o statement após a execução
        } else {
            $error = "Erro ao preparar a consulta: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Ouvidoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
    <?php include("inc/navbar.php"); ?>
    <div class="container" align="center" style="margin-top:3%;">
        <div class="col-md-4" align="left">
            <form method="post" id="loginForm">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" name="senha" id="senha" required>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <?php
            if (isset($error)) {
                echo "<div class='alert alert-danger mt-3' role='alert'>$error</div>";
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
