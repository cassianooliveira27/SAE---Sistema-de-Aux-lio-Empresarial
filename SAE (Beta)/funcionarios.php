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

function atualizarCampos() {
    const select = document.getElementById('id_cargo');
    const cargaInput = document.getElementById('carga_horaria');
    const salarioInput = document.getElementById('salario');
    const cargaMax = select.options[select.selectedIndex].getAttribute('data-carga');
    const salarioBase = select.options[select.selectedIndex].getAttribute('data-salario');

    cargaInput.value = cargaMax;
    cargaInput.max = cargaMax;
    cargaInput.readOnly = true;

    salarioInput.value = salarioBase;
    salarioInput.readOnly = true;
}
</script>
<style>
.message-container { margin-top:20px; text-align:center; }
.message { display:inline-block; padding:10px; margin:10px; border-radius:5px; width:80%; max-width:400px; }
.success { background-color:#d4edda; color:#155724; border:1px solid #c3e6cb; }
.error   { background-color:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }
</style>
</head>
<body>
<?php include 'header.php'; ?>
<?php
require 'conect_bd.php';
$message = '';
$cargos = $conn->query("SELECT * FROM cargos ORDER BY nome_cargo");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome          = trim($_POST['nome_funcionario']);
    $cpf           = trim($_POST['cpf_funcionario']);
    $id_cargo      = intval($_POST['id_cargo']);
    $carga_horaria = intval($_POST['carga_horaria']);
    $data_admissao = !empty($_POST['data_admissao']) ? $_POST['data_admissao'] : null;
    $res_cargo = $conn->query("SELECT carga_horaria_max, salario_base FROM cargos WHERE id_cargo=$id_cargo");
    $cargoData = $res_cargo->fetch_assoc();
    $cargaMax  = $cargoData['carga_horaria_max'];
    $salario   = $cargoData['salario_base'];
    if ($carga_horaria > $cargaMax) {
        $carga_horaria = $cargaMax;
    }

    $check = $conn->query("SELECT 1 FROM funcionarios WHERE cpf_funcionario = '".$conn->real_escape_string($cpf)."'");
    if ($check && $check->num_rows > 0) {
        $message = "<p class='message error'>⚠️ Este CPF já está em uso!</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO funcionarios (nome_funcionario, cpf_funcionario, id_cargo, salario, data_admissao) VALUES (?,?,?,?,?)");
        $stmt->bind_param('ssids', $nome, $cpf, $id_cargo, $salario, $data_admissao);

        if ($stmt->execute()) {
            $message = "<p class='message success'>✅ Funcionário cadastrado com sucesso!</p>";
        } else {
            $message = "<p class='message error'>❌ Erro ao cadastrar funcionário!</p>";
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
    <input type="text" name="cpf_funcionario" maxlength="14" placeholder="000.000.000-00" oninput="mascaraCPF(this)" required>

    <label>Cargo:</label>
    <select name="id_cargo" id="id_cargo" onchange="atualizarCampos()" required>
        <option value="">Selecione</option>
        <?php while($c = mysqli_fetch_assoc($cargos)): ?>
            <option value="<?=$c['id_cargo']?>" data-carga="<?=$c['carga_horaria_max']?>" data-salario="<?=$c['salario_base']?>">
                <?=htmlspecialchars($c['nome_cargo'])?> 
                (Máx: <?=$c['carga_horaria_max']?>h | Salário Base: R$<?=number_format($c['salario_base'],2,',','.')?>)
            </option>
        <?php endwhile; ?>
    </select>

    <label>Carga Horária:</label>
    <input type="number" id="carga_horaria" name="carga_horaria" min="1" readonly>

    <label>Salário:</label>
    <input type="number" id="salario" name="salario" step="0.01" readonly>

    <label>Data de Admissão:</label>
    <input type="date" name="data_admissao">

    <button type="submit">Cadastrar</button>
</form>
</div>

<div class="message-container">
<?php if ($message) echo $message; ?>
</div>

</body>
</html>
