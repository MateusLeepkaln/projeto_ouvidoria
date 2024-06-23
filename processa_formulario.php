<?php
require("PHPMailer/PHPMailerAutoload.php");
require("inc/conexao.php");

session_start();

function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

$nome = ucfirst(sanitizeInput($_POST["nome"]));
$email = filter_var(sanitizeInput($_POST["email"]), FILTER_VALIDATE_EMAIL);
$senha = md5(sanitizeInput($_POST["senha"]));
$confirmacao_senha = md5(sanitizeInput($_POST["confirmacao_senha"]));
$data_nascimento = sanitizeInput($_POST["data_nascimento"]);
$telefone = sanitizeInput($_POST["telefone"]);
$whatsapp = sanitizeInput($_POST["whatsapp"]);
$cidade = sanitizeInput($_POST["cidade"]);
$estado = sanitizeInput($_POST["estado"]);

if (!$email) {
    die("E-mail inválido");
}

if ($senha !== $confirmacao_senha) {
    die("As senhas não coincidem");
}

// Verifica se já existe um usuário com este e-mail
$sqlVerificaCadastro = "SELECT `email` FROM usuario WHERE `email` = ?";
$stmt = mysqli_prepare($conn, $sqlVerificaCadastro);

if (!$stmt) {
    die("Erro ao preparar a consulta: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$resultadoVerificaCadastro = mysqli_stmt_get_result($stmt);

$qtdLinhas = mysqli_num_rows($resultadoVerificaCadastro);

if ($qtdLinhas > 0) {
    echo "<style>#carregando{display:none;}</style>
    <div class='alert alert-danger' role='alert'>Já existe um cadastro com esse e-mail ($email)</div>
    <br>
    <a class='btn btn-primary' href='cadastro.php' role='button'>Voltar</a>
    ";
} else {
    $hash = sprintf('%07x', mt_rand(0, 0xFFFFFFF));
    $sqlCadastroUsuario = "INSERT INTO usuario (nome, data_nascimento, email, telefone, whatsapp, senha, confirmacao_senha, cidade, estado, hash, cadastro, ativacao, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NULL, 'pendente')";

    $stmt = mysqli_prepare($conn, $sqlCadastroUsuario);

    if (!$stmt) {
        die("Erro ao preparar a consulta de cadastro: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssssssssss", $nome, $data_nascimento, $email, $telefone, $whatsapp, $senha, $confirmacao_senha, $cidade, $estado, $hash);

    if (mysqli_stmt_execute($stmt)) {
        enviarEmailVerificacao($email, $hash);

        echo "<style>#carregando{display:none;}</style>
        <div class='alert alert-success' role='alert'>Cadastro realizado com sucesso! Verifique seu e-mail para ativar sua conta.</div>
        <br>
        <a class='btn btn-primary' href='login.php' role='button'>Ir para o login</a>
        ";
    } else {
        echo "<style>#carregando{display:none;}</style>
        <div class='alert alert-danger' role='alert'>Erro ao realizar o cadastro: " . mysqli_error($conn) . "</div>
        <br>
        <a class='btn btn-primary' href='cadastro.php' role='button'>Voltar</a>
        ";
    }
}

mysqli_close($conn);

function enviarEmailVerificacao($email, $token) {
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor de e-mail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'mkgdnina@gmail.com'; 
        $mail->Password = 'wyof ioxt qaxe cwww'; 
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        // Configurações do e-mail
        $mail->setFrom('mkgdnina@gmail.com', 'Rogere'); 
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Verificacao de E-mail';
        $mail->Body = "Clique no link para verificar seu e-mail: <a href='http://localhost/verificar.php?token=$token'>Verificar E-mail</a>";

        $mail->send();
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail de verificacao: {$mail->ErrorInfo}";
    }
}
?>
