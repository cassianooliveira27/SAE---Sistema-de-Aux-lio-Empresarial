<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Cargos</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .message-container {
            margin-top: 20px;
            text-align: center;
        }

        .message {
            display: inline-block;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            width: 80%;
            max-width: 400px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<?php
require 'conect_bd.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome          = trim($_POST['nome_cargo']);
    $descricao     = trim($_POST['descricao']);
    $salario_base  = isset($_POST['salario_base']) ? floatval($_POST['salario_base']) : 0;
    $carga_max     = isset($_POST['carga_horaria_max']) ? intval($_POST['carga_horaria_max']) : 40;

    if ($carga_max <= 0) {
        $message = "<p class='message error'>❌ Carga horária máxima inválida.</p>";
    } else {
        $check = $conn->query("SELECT 1 FROM cargos WHERE nome_cargo = '".$conn->real_escape_string($nome)."'");
        if ($check && $check->num_rows > 0) {
            $message = "<p class='message error'>⚠️ Este cargo já está cadastrado!</p>";
        } else {
            $stmt = $conn->prepare("INSERT INTO cargos (nome_cargo, descricao, salario_base, carga_horaria_max) VALUES (?,?,?,?)");
            $stmt->bind_param('ssdi', $nome, $descricao, $salario_base, $carga_max);
            if ($stmt->execute()) {
                $message = "<p class='message success'>✅ Cargo cadastrado com sucesso!</p>";
            } else {
                $message = "<p class='message error'>❌ Erro ao cadastrar cargo.</p>";
            }
        }
    }
}
?>

<div class="container">
    <h2>Cadastro de Cargos</h2>
    <form method="POST">
        <label>Nome do Cargo:</label>
        <input type="text" name="nome_cargo" required>

        <label>Descrição:</label>
        <textarea name="descricao" required></textarea>

        <label>Salário Base:</label>
        <input type="number" step="0.01" name="salario_base" required>

        <label>Carga Horária Máxima (horas):</label>
        <input type="number" name="carga_horaria_max" min="1" max="60" value="40" required>

        <button type="submit">Cadastrar</button>
    </form>
</div>

<div class="message-container">
    <?php if ($message) echo $message; ?>
</div>

</body>
</html>