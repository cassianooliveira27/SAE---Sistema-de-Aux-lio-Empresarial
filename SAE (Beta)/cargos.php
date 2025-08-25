<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Cargos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<?php
require 'conect_bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome_cargo']);
    $descricao = trim($_POST['descricao']);
    $salario_base = $_POST['salario_base'];

    $check = mysqli_query($conn, "SELECT 1 FROM cargos WHERE nome_cargo = '$nome'");
    if (mysqli_num_rows($check) > 0) {
        echo "<p style='color:red; text-align:center; font-weight:bold;'>⚠️ Este cargo já está cadastrado!</p>";
    } else {
        $sql = "INSERT INTO cargos (nome_cargo, descricao, salario_base) 
                VALUES ('$nome', '$descricao', '$salario_base')";
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green; text-align:center; font-weight:bold;'>✅ Cargo cadastrado com sucesso!</p>";
        } else {
            echo "<p style='color:red; text-align:center; font-weight:bold;'>❌ Erro ao cadastrar cargo!</p>";
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

        <button type="submit">Cadastrar</button>
    </form>
</div>

</body>
</html>
