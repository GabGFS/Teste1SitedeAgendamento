<?php

function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}

if (count($_POST) > 0) {

    include('conexao.php');

    $erro = false;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $nascimento = $_POST['nascimento'];

    if (empty($nome)) {
        $erro = "Preencha o campo nome";
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
    if (!$erro) {
        $sql_code = "INSERT INTO clientes (nome, email, celular, data_de_cadastro)
    VALUES ('$nome', '$email', '$celular', NOW())";
        $querySuccess = $mysqli->query($sql_code) or die($mysqli->error);
        if ($querySuccess) {

            echo "<p><b>Cliente cadastrado com sucesso!</br></p>";
            unset($_POST);
            /*    
                            if ($querySuccess) {
                                $sql_code = "INSERT INTO agendamento (id_cliente, id_servico, data_e_hora_agendamento, observacoes)
                                VALUES (8, 1, '2025-09-20 15:30:00', 'semobservac')";
                                $querySuccess = $mysqli->query($sql_code) or die($mysqli->error);
                                if ($querySuccess) {
                                    echo "<p><b>Cliente cadastrado com sucesso!</br></p>";
                                    unset($_POST);
                                }
                            }
                                */
        }
    }
}
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
            <input value="<?php if (isset($_POST['nome']))
                echo $_POST['nome']; ?>" name="nome" type="text">
        </p>
        <p>
            <label>E-mail</label>
            <input value="<?php if (isset($_POST['email']))
                echo $_POST['email']; ?>" name="email" type="text">
        </p>
        <p>
            <label>Celular</label>
            <input value="<?php if (isset($_POST['celular']))
                echo $_POST['celular']; ?>" placeholder="(44) 99444-4444" name="celular" type="text">
        </p>
        <p>
            <label>Data de nascimento</label>
            <input value="<?php if (isset($_POST['nascimento']))
                echo $_POST['nascimento']; ?>" placeholder="dia/mês/ano" name="nascimento" type="text">
        </p>
        <p>
            <button type="submit">Salvar Cliente</button>
        </p>
    </form>
</body>

</html>