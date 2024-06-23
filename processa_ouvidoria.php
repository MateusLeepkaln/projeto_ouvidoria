<?php
session_start();
require 'inc/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['user_id'];
    $tipo = htmlspecialchars(trim($_POST['tipo']));
    $mensagem = htmlspecialchars(trim($_POST['mensagem']));
    $anexos = '';

    if (isset($_FILES['anexos'])) {
        $fileCount = count($_FILES['anexos']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $fileTmpPath = $_FILES['anexos']['tmp_name'][$i];
            $fileData = base64_encode(file_get_contents($fileTmpPath));
            $anexos .= $fileData . ';';
        }
        $anexos = rtrim($anexos, ';');
    }

    // Ajustando a consulta SQL para corresponder aos parâmetros
    $sql = "INSERT INTO ouvidoria (usuario_id, tipo, mensagem, data_envio, anexos) VALUES (?, ?, ?, NOW(), ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Verificando a correspondência dos parâmetros
        mysqli_stmt_bind_param($stmt, "isss", $usuario_id, $tipo, $mensagem, $anexos);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Solicitacao de ouvidoria enviada com sucesso!'); window.location.href = 'ouvidoria.php';</script>";
        } else {
            echo "Erro ao enviar solicitacao: " . mysqli_error($conn);
        }
    } else {
        echo "Erro ao preparar a consulta: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Método de requisição inválido.";
}
?>
