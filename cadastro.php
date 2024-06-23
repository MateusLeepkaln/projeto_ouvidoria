<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ouvidoria</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <?php include("inc/navbar.php"); ?>

  <div class="container" align="center" style="margin-top:3%;">
    <div class="col-md-4" align="left">
      <form onsubmit="return false;" id="formulario">
        <div class="form-group">
          <label>Nome</label> 
          <input type="text" class="form-control" name="nome" id="nome" required>
        </div>
        <div class="form-group">
          <label>E-mail</label>
          <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
          <label>Senha</label>
          <input type="password" class="form-control" name="senha" id="senha" required>
        </div>
        <div class="form-group">
          <label>Confirmação de Senha</label>
          <input type="password" class="form-control" name="confirmacao_senha" id="confirmacao_senha" required>
        </div>
        <div class="form-group">
          <label>Data de Nascimento</label>
          <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" required>
        </div>
        <div class="form-group">
          <label>Telefone</label>
          <input type="tel" class="form-control" name="telefone" id="telefone" required placeholder="(xx) xxxxx-xxxx">
        </div>
        <div class="form-group">
          <label>WhatsApp</label>
          <input type="tel" class="form-control" name="whatsapp" id="whatsapp" required placeholder="(xx) xxxxx-xxxx">
        </div>
        <div class="form-group">
          <label>Cidade</label>
          <input type="text" class="form-control" name="cidade" id="cidade" required>
        </div>
        <div class="form-group">
          <label for="estado">Estado</label>
          <select name="estado" id="estado" class="form-control" required>
          <option value="">Selecione o Estado</option>  
          <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
            </select>
        </div>
        <br>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" id="cadastrar">Cadastrar</button>
        </div>
      </form>
      <div id="carregando" align="center"></div>
      <div id="div_processa_formulario"></div>
    </div>
  </div>
  <?php include("inc/modal.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script type="text/javascript">
    $("#cadastrar").click(function () {
      if (
        $("#nome").val().length != 0 &&
        $("#email").val().length != 0 &&
        $("#senha").val().length != 0 &&
        $("#confirmacao_senha").val().length != 0 &&
        $("#data_nascimento").val().length != 0 &&
        $("#telefone").val().length != 0 &&
        $("#whatsapp").val().length != 0 &&
        $("#cidade").val().length != 0 &&
        $("#estado").val().length != 0
      ) {
        var nome = $("#nome").val();
        var email = $("#email").val();
        var senha = $("#senha").val();
        var confirmacao_senha = $("#confirmacao_senha").val();
        var data_nascimento = $("#data_nascimento").val();
        var telefone = $("#telefone").val();
        var whatsapp = $("#whatsapp").val();
        var cidade = $("#cidade").val();
        var estado = $("#estado").val();

        $("#formulario").css("display", "none");
        $("#carregando").html("<img src='carregando.gif' width='30%'>");

        $.post('processa_formulario.php', {
          nome: nome,
          email: email,
          senha: senha,
          confirmacao_senha: confirmacao_senha,
          data_nascimento: data_nascimento,
          telefone: telefone,
          whatsapp: whatsapp,
          cidade: cidade,
          estado: estado
        }, function (include_processa_formulario) {
          $("#div_processa_formulario").html(include_processa_formulario);
        });
      } else {
        $("#mensagem").html("Por favor, preencha todos os campos");
        $("#modal").modal("show");
      }
    });
  </script>

</body>

</html>
