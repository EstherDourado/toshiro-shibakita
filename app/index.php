<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exemplo PHP - Microsserviços</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      color: #333;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1,
    h2 {
      color: #2c3e50;
    }

    .info {
      background: #e8f4f8;
      padding: 15px;
      border-left: 4px solid #3498db;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #3498db;
      color: white;
    }
  </style>
</head>

<body>

  <div class="container">
    <h1>Ambiente de Microsserviços 🐳</h1>

    <?php
    // Pegando variáveis de ambiente (Segurança)
    $servername = getenv('DB_HOST') ?: "db";
    $username = getenv('DB_USER') ?: "root";
    $password = getenv('DB_PASS') ?: "Senha123";
    $database = getenv('DB_NAME') ?: "meubanco";

    $host_name = gethostname();

    echo "<div class='info'>";
    echo "<strong>Servidor PHP (Container ID):</strong> " . $host_name . "<br>";
    echo "<strong>Versão do PHP:</strong> " . phpversion();
    echo "</div>";

    // Criar conexão
    $link = new mysqli($servername, $username, $password, $database);

    if (mysqli_connect_errno()) {
      die("<p style='color:red;'>Falha na conexão com o Banco de Dados: " . mysqli_connect_error() . "</p>");
    }

    // Gerando dados aleatórios para inserção
    $valor_rand2 = strtoupper(substr(bin2hex(random_bytes(4)), 1));

    // Preparando a query para evitar SQL Injection
    $stmt = $link->prepare("INSERT INTO dados (Nome, Sobrenome, Endereco, Cidade, Host) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $valor_rand2, $valor_rand2, $valor_rand2, $valor_rand2, $host_name);

    if ($stmt->execute()) {
      echo "<p style='color:green;'>✅ Novo registro criado com sucesso por este container!</p>";
    } else {
      echo "<p style='color:red;'>Erro ao inserir: " . $stmt->error . "</p>";
    }
    $stmt->close();

    // Listando os dados inseridos
    echo "<h2>Últimos Registros no Banco:</h2>";
    $result = $link->query("SELECT * FROM dados ORDER BY AlunoID DESC LIMIT 10");

    if ($result->num_rows > 0) {
      echo "<table>";
      echo "<tr><th>ID</th><th>Nome Hash</th><th>Criado Pelo Container</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["AlunoID"] . "</td>";
        echo "<td>" . $row["Nome"] . "</td>";
        echo "<td><code>" . $row["Host"] . "</code></td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "<p>Nenhum dado encontrado.</p>";
    }

    $link->close();
    ?>
  </div>

</body>

</html>