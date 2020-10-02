<?php
session_start();
require_once('variaveis.php');
require_once('conexao.php');

$idPessoa = $_GET['idPessoa'];

//recuperando dados da sessao
$id_usuario   = $_SESSION["id_usuario"];
$tipoAcesso   = $_SESSION["tipo_acesso"];
$nome_usuario = "";

$sql = "SELECT nome FROM usuarios WHERE id = " . $id_usuario;
$resp = mysqli_query($conexao_bd, $sql);
if ($rows = mysqli_fetch_row($resp)) {
    $nome_usuario = $rows[0];
}

$estados = array(
    'AC' => 'Acre',
    'AL' => 'Alagoas',
    'AP' => 'Amapá',
    'AM' => 'Amazonas',
    'BA' => 'Bahia',
    'CE' => 'Ceará',
    'DF' => 'Distrito Federal',
    'ES' => 'Espírito Santo',
    'GO' => 'Goiás',
    'MA' => 'Maranhão',
    'MT' => 'Mato Grosso',
    'MS' => 'Mato Grosso do Sul',
    'MG' => 'Minas Gerais',
    'PA' => 'Pará',
    'PB' => 'Paraíba',
    'PR' => 'Paraná',
    'PE' => 'Pernambuco',
    'PI' => 'Piauí',
    'RJ' => 'Rio de Janeiro',
    'RN' => 'Rio Grande do Norte',
    'RS' => 'Rio Grande do Sul',
    'RO' => 'Rondônia',
    'RR' => 'Roraima',
    'SC' => 'Santa Catarina',
    'SP' => 'São Paulo',
    'SE' => 'Sergipe',
    'TO' => 'Tocantins'
);

//verificar se o parametro de id de edição está vazio:   
if (strlen($idPessoa) == 0)
    $idPessoa = 0;

$nome            = "";
$endereco        = "";
$numero          = 0;
$complemento     = "";
$cidade          = "";
$estado          = "";
$cep             = "";
$dataNascimento  = "";
$telefone        = "";
$celular         = "";
$email           = "";

if ($idPessoa != 0) {
    $sql = "SELECT    nome, endereco, 
                        numero, complemento, cidade, 
                        estado, cep, datanascimento, 
                        telefone, celular, email 
               FROM pessoas
                    WHERE idPessoa = $idPessoa";

    $resp = mysqli_query($conexao_bd, $sql);
    if ($rows = mysqli_fetch_row($resp)) {
        $nome              = ucwords(strtolower($rows[0]));
        $endereco          = $rows[1];
        $numero            = $rows[2];
        $complemento       = $rows[3];
        $cidade            = $rows[4];
        $estado            = $rows[5];
        $cep               = $rows[6];
        $dataNascimento    = $rows[7];
        $telefone          = $rows[8];
        $celular           = $rows[9];
        $email             = $rows[10];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SysPacientes - Lista de usuários</title>
    <link rel="icon" href="img/favicon/favicon2.ico">
    <script src="js/jquery.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <script src="js/sweetalert2.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container">

        <!-- Static navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
            <a class="navbar-brand" href="#">SysPacientes</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample09">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="admin.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <?php
                    if ($tipoAcesso != 3) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cadastros</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown09">
                                <a class="dropdown-item" href="pessoa_list.php">Cadastro de pessoas</a>
                                <a class="dropdown-item" href="usuario_list2.php">Cadastro de usuários</a>
                                <a class="dropdown-item" href="#">Cadastro de pacientes</a>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <ul class="navbar-nav navbar-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo ($nome_usuario); ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown10">
                            <a class="dropdown-item" href="minhaconta.php">Minha conta</a>
                            <a class="dropdown-item" href="logout.php">Sair</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="jumbotron">
            <form method="post" action="pessoa_gravar.php">
                <input type="hidden" id="inputIdPessoa" name="inputIdPessoa" value="<?php echo ($idPessoa) ?>">
                <div class="form-group">
                    <label for="inputNome">Nome *</label>
                    <input type="text" class="form-control" id="inputNome" name="inputNome" maxlength="100" placeholder="Nome" value="<?php echo ($nome); ?>">
                </div>

                <div class="row">
                    <div class="form-group col-9">
                        <label for="inputEmail">Email *</label>
                        <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" value="<?php echo ($email); ?>">
                    </div>

                    <div class="form-group col-3">
                        <label for="inputDataNascimento">Data de Nascimento *</label>
                        <input type="text" maxlength="10" class="form-control" id="inputDataNascimento" name="inputDataNascimento" placeholder="Data de Nascimento" value="<?php echo ($dataNascimento); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="inputTelefone">Telefone</label>
                        <input type="text" class="form-control" id="inputTelefone" name="inputTelefone" placeholder="Telefone" value="<?php echo ($telefone); ?>">
                    </div>

                    <div class="form-group col-6">
                        <label for="inputCelular">Celular *</label>
                        <input type="text" class="form-control" id="inputCelular" name="inputCelular" placeholder="Celular" value="<?php echo ($celular); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 offset-3">
                        <div class="form-group">
                            <label for="inputCep">Cep *</label>
                            <input type="text" class="form-control" id="inputCep" name="inputCep" placeholder="CEP" value="<?php echo ($cep); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEndereco">Endereço *</label>
                    <input type="text" class="form-control" maxlength="100" id="inputEndereco" name="inputEndereco" placeholder="Endereço" value="<?php echo ($endereco); ?>">
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label for="inputNumero">Número *</label>
                        <input type="text" class="form-control apenas-numeros" id="inputNumero" name="inputNumero" placeholder="Número" value="<?php echo ($numero); ?>">
                    </div>

                    <div class="form-group col-6">
                        <label for="inputComplemento">Complemento</label>
                        <input type="text" class="form-control" id="inputComplemento" name="inputComplemento" placeholder="Complemento" value="<?php echo ($complemento); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-9">
                        <label for="inputCidade">Cidade *</label>
                        <input type="text" class="form-control" id="inputCidade" name="inputCidade" placeholder="Cidade" value="<?php echo ($cidade); ?>">
                    </div>

                    <div class="form-group col-3">
                        <label for="cmbEstados">Estado</label>
                        <select name="cmbEstados" id="cmbEstados" class="form-control" value="">
                            <?php
                            foreach ($estados as $key => $value) {
                                if ($estado != "" && $estado == $key) {
                                    echo ("<option value=\"$key\" selected>$estados[$key]</option>");
                                } else {
                                    echo ("<option value=\"$key\">$estados[$key]</option>");
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <span>Campos com (*) são obrigatórios</span>
                <br>
                <div class="row">
                    <div class="col-3 offset-9 text-right">
                        <a class='btn btn-danger' id="btnCancelar" href='pessoa_list.php' role='button'>Cancelar</a>&nbsp;
                        <button class='btn btn-success' id="btnSalvar" disabled role='button'>Salvar</button>&nbsp;
                    </div>
                </div>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
        <script>
            window.jQuery || document.write('<script src="https://code.jquery.com/jquery-1.12.4.min.js"><\/script>')
        </script>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/inputmask.min.js"></script>
        <script src="js/pessoa.js"></script>
        <?php
        mysqli_close($conexao_bd);
        ?>

</body>

</html>
