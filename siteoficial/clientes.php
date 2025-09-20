<?php include'conexao.php'; 

$sql_clientes = "SELECT * FROM clientes";
$query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
$num_clientes = $query_clientes->num_rows;

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
</head>
<body>
    <h1>Lista de Clientes</h1>
    <p>Estes são os clientes cadastrados no seu sistema:</p>
    <table border="1" cellpading="10">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>E-mail</th>
            <th>Celular</th>
            <th>Data de nascimento</th>
            <th>Data de cadastro</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <?php if($num_clientes == 0) { ?>
                <tr>
                    <td colspan="7">Nenhum cliente foi cadastrado.
                </tr>
            <?php 
            } else { 
                while($cliente = $query_clientes->fetch_assoc()) {
                
                    $celular = "Não informado";
                    if(!empty($cliente['celular'])) {
                        $celular= formatar_celular($cliente['celular']);
                    }
                    $nascimento = "Não informada";
                    if(!empty($cliente['nascimento'])) {
                        $nascimento = formatar_data($cliente['nascimento']);
                    }
                    $data_de_cadastro = date("d/m/Y H:i", strtotime($cliente['data_de_cadastro']));
                    ?>
                    <tr>
                        <td><?php echo $cliente['id']; ?></td>
                        <td><?php echo $cliente['nome']; ?></td>
                        <td><?php echo $cliente['cpf']; ?></td>
                        <td><?php echo $cliente['email']; ?></td>
                        <td><?php echo $celular; ?></td>
                        <td><?php echo $nascimento; ?></td>
                        <td><?php echo $data_de_cadastro; ?></td>
                        <td>
                            <a href="editar_cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a>
                            <a href="deletar_cliente.php?id=<?php echo $cliente['id']; ?>">Deletar</a>
                        </td>
                    </tr>
                    <?php 
                    }
                } ?>
            </tbody>
        </table>

    </body>
    </html>