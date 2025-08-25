<?php 
require 'conect_bd.php';
include 'header.php';

if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $conn->query("DELETE FROM funcionarios WHERE id_funcionario = $id");
    header("Location: consulta_funcionarios.php");
    exit;
}

if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome  = trim($_POST['nome_funcionario']);
        $carga = intval($_POST['carga_horaria']);
        $sal   = floatval($_POST['salario']);
        $cargo = intval($_POST['id_cargo']);
        $stmt = $conn->prepare("UPDATE funcionarios SET nome_funcionario=?, carga_horaria=?, salario=?, id_cargo=? WHERE id_funcionario=?");
        $stmt->bind_param('sidii', $nome, $carga, $sal, $cargo, $id);
        $stmt->execute();
        header("Location: consulta_funcionarios.php");
        exit;
    }
    $dados  = $conn->query("SELECT * FROM funcionarios WHERE id_funcionario=$id")->fetch_assoc();
    $cargos = $conn->query("SELECT * FROM cargos ORDER BY nome_cargo");
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
            <input name="nome_funcionario" value="<?=htmlspecialchars($dados['nome_funcionario'])?>">

            <label>Cargo:</label>
            <select name="id_cargo">
                <?php while($c = $cargos->fetch_assoc()): ?>
                    <option value="<?=$c['id_cargo']?>" <?=($dados['id_cargo'] == $c['id_cargo'] ? 'selected' : '')?>><?=htmlspecialchars($c['nome_cargo'])?></option>
                <?php endwhile; ?>
            </select>

            <label>Carga Horária:</label>
            <input type="number" name="carga_horaria" value="<?=$dados['carga_horaria']?>">

            <label>Salário:</label>
            <input type="number" step="0.01" name="salario" value="<?=$dados['salario']?>">

            <button type="submit" class="btn-primary">Salvar Alterações</button>
            <a href="consulta_funcionarios.php" class="btn-primary" style="background:#6b7686;">Cancelar</a>
        </form>
    </div>
    </body>
    </html>
    <?php
    exit;
}

$pesquisa     = $_GET['pesquisa'] ?? '';
$cargo_filtro = $_GET['cargo'] ?? '';
$sal_min      = $_GET['salario_min'] ?? '';
$sal_max      = $_GET['salario_max'] ?? '';

$query = "SELECT f.*, c.nome_cargo 
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
</head>
<body>
<div class="container">
    <h1>Consulta de Funcionários</h1>

    <form method="get" class="filtros">
        <input type="text" name="pesquisa" placeholder="Buscar por nome" value="<?=htmlspecialchars($pesquisa)?>">
        <input type="number" step="0.01" name="salario_min" placeholder="Salário mínimo" value="<?=htmlspecialchars($sal_min)?>">
        <input type="number" step="0.01" name="salario_max" placeholder="Salário máximo" value="<?=htmlspecialchars($sal_max)?>">
        <select name="cargo">
            <option value="">Todos os cargos</option>
            <?php while($c = $cargos->fetch_assoc()): ?>
                <option value="<?=$c['id_cargo']?>" <?=($cargo_filtro == $c['id_cargo'] ? 'selected' : '')?>><?=htmlspecialchars($c['nome_cargo'])?></option>
            <?php endwhile; ?>
        </select>
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
                <th>Carga Horária</th>
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
            <td><?=$f['carga_horaria']?></td>
            <td><?=number_format($f['salario'],2,',','.')?></td>
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
