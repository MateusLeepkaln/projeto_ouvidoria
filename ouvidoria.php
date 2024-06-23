<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ouvidoria - Nova Solicitação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include("inc/navbar.php"); ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2>Nova Solicitação de Ouvidoria</h2>
                <form id="ouvidoriaForm" method="post" action="processa_ouvidoria.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="tipo">Tipo de Serviço Afetado</label>
                        <input type="text" class="form-control" id="tipo" name="tipo" required>
                    </div>
                    <div class="form-group">
                        <label for="mensagem">Descrição do Caso</label>
                        <textarea class="form-control" id="mensagem" name="mensagem" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="anexos">Anexos</label>
                        <input type="file" class="form-control" id="anexos" name="anexos[]" multiple required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#ouvidoriaForm').on('submit', function(e) {
                var isValid = true;

                if ($('#tipo').val().trim() === '') {
                    alert('O campo Tipo de Serviço Afetado é obrigatório.');
                    isValid = false;
                }

                if ($('#mensagem').val().trim() === '') {
                    alert('O campo Descrição do Caso é obrigatório.');
                    isValid = false;
                }

                if ($('#anexos').get(0).files.length === 0) {
                    alert('Por favor, adicione pelo menos um anexo.');
                    isValid = false;
                }

                return isValid;
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
