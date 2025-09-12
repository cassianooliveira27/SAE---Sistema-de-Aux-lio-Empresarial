<?php 
require 'conect_bd.php';
include 'header.php';

$message = "";

// Excluir funcionário
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $stmt = $conn->prepare("DELETE FROM funcionarios WHERE id_funcionario = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $message = "<p class='message success'>✅ Funcionário excluído com sucesso!</p>";
    } else {
        $message = "<p class='message error'>❌ Erro ao excluir funcionário.</p>";
    }
}

// Editar funcionário
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $dados  = $conn->query("SELECT * FROM funcionarios WHERE id_funcionario=$id")->fetch_assoc();
    $cargos = $conn->query("SELECT * FROM cargos ORDER BY nome_cargo");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome     = trim($_POST['nome_funcionario']);
        $id_cargo = intval($_POST['id_cargo']);
        $salario  = floatval($_POST['salario']);

        $stmt = $conn->prepare("UPDATE funcionarios SET nome_funcionario=?, id_cargo=?, salario=? WHERE id_funcionario=?");
        $stmt->bind_param('sidi', $nome, $id_cargo, $salario, $id);
        if ($stmt->execute()) {
            header("Location: consulta_funcionarios.php?status=edit_ok");
            exit;
        } else {
            $message = "<p class='message error'>❌ Erro ao editar funcionário.</p>";
        }
    }
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Editar Funcionário</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Editar Funcionário</h2>
<form method="post">
    <label>Nome:</label>
    <input name="nome_funcionario" value="<?=htmlspecialchars($dados['nome_funcionario'])?>" required>

    <label>Cargo:</label>
    <select name="id_cargo" id="id_cargo" required>
        <?php 
        mysqli_data_seek($cargos, 0); 
        while($c = $cargos->fetch_assoc()): ?>
            <option value="<?=$c['id_cargo']?>" 
                    <?=($dados['id_cargo']==$c['id_cargo']?'selected':'')?>>
                <?=htmlspecialchars($c['nome_cargo'])?> (Máx: <?=$c['carga_horaria_max']?>h)
            </option>
        <?php endwhile; ?>
    </select>

    <label>Salário:</label>
    <input type="number" step="0.01" name="salario" 
           value="<?=$dados['salario']?>" required>

    <button type="submit" class="btn-primary">Salvar Alterações</button>
    <a href="consulta_funcionarios.php" class="btn-primary" style="background:#6b7686;">Cancelar</a>
</form>
</div>
</body>
</html>
<?php
exit;
}

// Filtros
$pesquisa     = $_GET['pesquisa'] ?? '';
$cargo_filtro = $_GET['cargo'] ?? '';
$sal_min      = $_GET['sal_min'] ?? 0;
$sal_max      = $_GET['sal_max'] ?? 10000;

$query = "SELECT f.*, c.nome_cargo, c.carga_horaria_max 
          FROM funcionarios f 
          LEFT JOIN cargos c ON f.id_cargo = c.id_cargo 
          WHERE 1=1";

if ($pesquisa) {
    $pesq = $conn->real_escape_string($pesquisa);
    $query .= " AND f.nome_funcionario LIKE '%$pesq%'";
}
if ($cargo_filtro) {
    $cargo_filtro = intval($cargo_filtro);
    $query .= " AND f.id_cargo = $cargo_filtro";
}
if ($sal_min !== '') {
    $query .= " AND f.salario >= " . floatval($sal_min);
}
if ($sal_max !== '') {
    $query .= " AND f.salario <= " . floatval($sal_max);
}
$query .= " ORDER BY f.nome_funcionario";

$res    = $conn->query($query);
$cargos = $conn->query("SELECT * FROM cargos ORDER BY nome_cargo");
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Consulta Funcionários</title>
<link rel="stylesheet" href="style.css">
<style>
.message { text-align:center; font-weight:bold; margin:10px; }
.success { color:green; }
.error { color:red; }
.range-container { margin: 10px 0; }
.range-label { font-weight: bold; }
.range-value { color: #007bff; margin-left: 5px; }
</style>
</head>
<body>
<div class="container">
    <h1>Consulta de Funcionários</h1>

    <?php if ($message) echo $message; ?>
    <?php if (isset($_GET['status']) && $_GET['status']=='edit_ok'): ?>
        <p class="message success">✅ Funcionário atualizado com sucesso!</p>
    <?php endif; ?>

    <form method="get" class="filtros">
        <input type="text" name="pesquisa" placeholder="Buscar por nome" value="<?=htmlspecialchars($pesquisa)?>">

        <select name="cargo">
            <option value="">Todos os cargos</option>
            <?php while($c = $cargos->fetch_assoc()): ?>
                <option value="<?=$c['id_cargo']?>" <?=($cargo_filtro==$c['id_cargo']?'selected':'')?>>
                    <?=htmlspecialchars($c['nome_cargo'])?>
                </option>
            <?php endwhile; ?>
        </select>

        <div class="range-container">
            <label class="range-label">Salário mín.: <span id="val_min"><?=$sal_min?></span></label>
            <input type="range" name="sal_min" id="sal_min" min="0" max="20000" step="100" 
                   value="<?=$sal_min?>" 
                   oninput="document.getElementById('val_min').innerText=this.value">
        </div>

        <div class="range-container">
            <label class="range-label">Salário máx.: <span id="val_max"><?=$sal_max?></span></label>
            <input type="range" name="sal_max" id="sal_max" min="0" max="20000" step="100" 
                   value="<?=$sal_max?>" 
                   oninput="document.getElementById('val_max').innerText=this.value">
        </div>

        <button type="submit" class="btn-primary">Filtrar</button>
        <a href="consulta_funcionarios.php" class="btn-primary" style="background:#6b7686;">Limpar</a>
    </form>

    <?php if ($res->num_rows == 0): ?>
        <p style="color:red; text-align:center; font-weight:bold;">⚠️ Nenhum funcionário encontrado com os filtros aplicados.</p>
    <?php else: ?>
    <div class="table-container">
        <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Cargo</th>
                <th>Carga Máx. do Cargo</th>
                <th>Salário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php while($f = $res->fetch_assoc()): ?>
        <tr>
            <td><?=$f['id_funcionario']?></td>
            <td><?=htmlspecialchars($f['nome_funcionario'])?></td>
            <td><?=htmlspecialchars($f['nome_cargo'])?></td>
            <td><?=$f['carga_horaria_max']?>h</td>
            <td>R$<?=number_format($f['salario'],2,',','.')?></td>
            <td>
                <div class="action-buttons">
                    <a href="?editar=<?=$f['id_funcionario']?>">Editar</a>
                    <a href="?excluir=<?=$f['id_funcionario']?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
