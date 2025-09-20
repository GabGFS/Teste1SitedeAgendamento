<?php

include'conexao.php';
$id = intval($_GET['id']);
function limpar_texto($str){
    return preg_replace("/[^0-9]/", "", $str);
}

if (count($_POST) > 0) {

    $erro = false;
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $nascimento = $_POST['nascimento'];

    if (empty($nome)) {
        $erro = "Preencha o campo nome";
    }
    if (empty($cpf)) {
        $erro = "Preencha o cpf";
    }
    if (empty($celular)) {
        $erro = "Preencha o campo celular";
    }
    if (!empty($nascimento)) {
        $pedacos = explode('/', $nascimento);
        if (count($pedacos) == 3) {
            $nascimento = implode('-', array_reverse($pedacos));
        } else {
            $erro = "A data de nascimento deve segui o padrão dia/mês/ano.";
        }
    }


    if (!empty($celular)) {
        $celular = limpar_texto($celular);
        if (strlen($celular) != 11)
            $erro = "O celular deve ser preenchido no padrão: (44) 99444-4444";
    }
    if ($erro) {
        echo "<p><b>ERRO: $erro</b></p>";
    } else {
        $sql_code = "UPDATE clientes 
        SET nome = '$nome',
        cpf = '$cpf',
        email = '$email',
        celular = '$celular',
        nascimento = '$nascimento'
        WHERE id = '$id'";
        $querySuccess = $mysqli->query($sql_code) or die($mysqli->error);
        if ($querySuccess) {
            echo "<p><b>Cliente atualizado com sucesso!</br></p>";
            unset($_POST);
        }
    }
}

$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
$cliente = $query_cliente->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
</head>

<body>
    <a href="/siteoficial/clientes.php">Voltar para a lista</a>
    <form method="POST" action="">
        <p>
            <label>Nome</label>
            <input value="<?php echo $cliente['nome']; ?>" name="nome" type="text">
        </p>
        <p>
            <label>CPF</label>
            <input value="<?php echo $cliente['cpf']; ?>" name="cpf" type="text">
        </p>
        <p>
            <label>E-mail</label>
            <input value="<?php echo !empty($cliente['email']) ? $cliente['email']: ''; ?>" name="email" type="text">
        </p>
        <p>
            <label>Celular</label>
            <input value="<?php echo formatar_celular($cliente['celular']); ?>" placeholder="(44) 99444-4444" name="celular" type="text">
        </p>
        <p>
            <label>Data de nascimento</label>
            <input value="<?php if(!empty($cliente['nascimento'])) echo formatar_data($cliente['nascimento']); ?>" placeholder="dia/mês/ano" name="nascimento" type="text">
        </p>
        <p>
            <button type="submit">Salvar Cliente</button>
        </p>
    </form>
</body>
</html>