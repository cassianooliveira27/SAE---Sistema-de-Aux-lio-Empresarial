<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Funcionários</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function mascaraCPF(campo) {
        let v = campo.value.replace(/\D/g, '');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        campo.value = v;
    }
    </script>
</head>
<body>
<?php include 'header.php'; ?>
<?php
require 'conect_bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome_funcionario'];
    $cpf = $_POST['cpf_funcionario'];
    $cargo = $_POST['id_cargo'];
    $carga_horaria = $_POST['carga_horaria'];
    $salario = $_POST['salario'];
    $data_admissao = $_POST['data_admissao'];
    $check = mysqli_query($conn, "SELECT 1 FROM funcionarios WHERE cpf_funcionario = '$cpf'");
    if (mysqli_num_rows($check) > 0) {
        echo "<p style='color:red; text-align:center; font-weight:bold;'>⚠️ Este CPF já está em uso!</p>";
    } else {
        $sql = "INSERT INTO funcionarios (nome_funcionario, cpf_funcionario, id_cargo, carga_horaria, salario, data_admissao) 
                VALUES ('$nome', '$cpf', '$cargo', '$carga_horaria', '$salario', '$data_admissao')";
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green; text-align:center; font-weight:bold;'>✅ Funcionário cadastrado com sucesso!</p>";
        } else {
            echo "<p style='color:red; text-align:center; font-weight:bold;'>❌ Erro ao cadastrar funcionário!</p>";
        }
    }
}
?>

<div class="container">
    <h2>Cadastro de Funcionários</h2>
    <form method="POST">
        <label>Nome:</label>
        <input type="text" name="nome_funcionario" required>

        <label>CPF:</label>
        <input name="cpf_funcionario" id="cpf" maxlength="14" oninput="mascaraCPF(this)" required>

        <label>Cargo:</label>
        <select name="id_cargo">
            <?php
            $result = mysqli_query($conn, "SELECT id_cargo, nome_cargo FROM cargos");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['id_cargo']}'>{$row['nome_cargo']}</option>";
            }
            ?>
        </select>

        <label>Carga Horária:</label>
        <input type="number" name="carga_horaria" required>

        <label>Salário:</label>
        <input type="number" step="0.01" name="salario" required>

        <label>Data de Admissão:</label>
        <input type="date" name="data_admissao">

        <button type="submit">Cadastrar</button>
    </form>
</div>

</body>
</html>
