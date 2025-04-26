<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo PHP</title>
</head>
<body>

<?php
ini_set("display_errors", 1);
header('Content-Type: text/html; charset=utf-8');

echo 'Versão Atual do PHP: ' . phpversion() . '<br>';

// Configurações do banco de dados
$servername = "54.234.153.24";
$username = "root";
$password = "Senha123";
$database = "meubanco";

// Criar conexão usando try-catch para melhor tratamento de erros
try {
    $link = new mysqli($servername, $username, $password, $database);

    // Verificar conexão
    if ($link->connect_error) {
        throw new Exception("Falha na conexão: " . $link->connect_error);
    }

    // Gerar valores aleatórios
    $valor_rand1 = rand(1, 999);
    $valor_rand2 = strtoupper(substr(bin2hex(random_bytes(4)), 1));
    $host_name = gethostname();

    // Usar prepared statements para evitar SQL Injection
    $query = $link->prepare("INSERT INTO dados (AlunoID, Nome, Sobrenome, Endereco, Cidade, Host) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("isssss", $valor_rand1, $valor_rand2, $valor_rand2, $valor_rand2, $valor_rand2, $host_name);

    if ($query->execute()) {
        echo "Novo registro criado com sucesso!";
    } else {
        throw new Exception("Erro ao inserir registro: " . $query->error);
    }

    // Fechar a consulta e a conexão
    $query->close();
    $link->close();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>

</body>
</html>