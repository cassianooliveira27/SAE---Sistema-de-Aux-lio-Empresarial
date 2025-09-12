<?php 
require 'conect_bd.php';
include 'header.php';

$message = "";

if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);

    $check = $conn->prepare("SELECT COUNT(*) as total FROM funcionarios WHERE id_cargo=?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result()->fetch_assoc();

    if ($result['total'] > 0) {
        $message = "<p class='message error'>⚠️ Não é possível excluir: existem funcionários vinculados a este cargo.</p>";
    } else {
        $stmt = $conn->prepare("DELETE FROM cargos WHERE id_cargo=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "<p class='message success'>✅ Cargo excluído com sucesso!</p>";
        } else {
            $message = "<p class='message error'>❌ Erro ao excluir cargo.</p>";
        }
    }
}

if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome  = trim($_POST['nome_cargo']);
        $desc  = trim($_POST['descricao']);
        $sal   = floatval($_POST['salario_base']);
        $cmax  = intval($_POST['carga_horaria_max']);
        $stmt = $conn->prepare("UPDATE cargos SET nome_cargo=?, descricao=?, salario_base=?, carga_horaria_max=? WHERE id_cargo=?");
        $stmt->bind_param('ssdii', $nome, $desc, $sal, $cmax, $id);
        if ($stmt->execute()) {
            header("Location: consulta_cargos.php?status=edit_ok");
            exit;
        } else {
            $message = "<p class='message error'>❌ Erro ao editar cargo.</p>";
        }
    }
    $dados = $conn->query("SELECT * FROM cargos WHERE id_cargo=$id")->fetch_assoc();
    ?>
    <!doctype html>
    <html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Editar Cargo</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <div class="container">
        <h2>Editar Cargo</h2>
        <form method="post">
            <label>Nome:</label>
            <input name="nome_cargo" value="<?=htmlspecialchars($dados['nome_cargo'])?>" required>

            <label>Descrição:</label>
            <textarea name="descricao" required><?=htmlspecialchars($dados['descricao'])?></textarea>

            <label>Salário Base:</label>
            <input type="number" step="0.01" name="salario_base" value="<?=$dados['salario_base']?>" required>

            <label>Carga Horária Máxima (horas):</label>
            <input type="number" name="carga_horaria_max" min="1" max="60" value="<?=$dados['carga_horaria_max']?>" required>

            <button type="submit" class="btn-primary">Salvar Alterações</button>
            <a href="consulta_cargos.php" class="btn-primary" style="background:#6b7686;">Cancelar</a>
        </form>
    </div>
    </body>
    </html>
    <?php
    exit;
}

$pesquisa = $_GET['pesquisa'] ?? '';
$query = "SELECT * FROM cargos WHERE 1=1";
if ($pesquisa) {
    $pesq = $conn->real_escape_string($pesquisa);
    $query .= " AND nome_cargo LIKE '%$pesq%'";
}
$query .= " ORDER BY nome_cargo";
$res = $conn->query($query);
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Consulta Cargos</title>
<link rel="stylesheet" href="style.css">
<style>
.message { text-align:center; font-weight:bold; margin:10px; }
.success { color:green; }
.error { color:red; }
</style>
</head>
<body>
<div class="container">
    <h1>Consulta de Cargos</h1>

    <?php if ($message) echo $message; ?>
    <?php if (isset($_GET['status']) && $_GET['status']=='edit_ok'): ?>
        <p class="message success">✅ Cargo atualizado com sucesso!</p>
    <?php endif; ?>

    <form method="get" class="filtros">
        <input type="text" name="pesquisa" placeholder="Buscar cargo" value="<?=htmlspecialchars($pesquisa)?>">
        <button type="submit" class="btn-primary">Filtrar</button>
        <a href="consulta_cargos.php" class="btn-primary" style="background:#6b7686;">Limpar</a>
    </form>

    <?php if ($res->num_rows == 0): ?>
        <p style="color:red; text-align:center; font-weight:bold;">⚠️ Nenhum cargo encontrado com os filtros aplicados.</p>
    <?php else: ?>
    <div class="table-container">
        <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Salário Base</th>
                <th>Carga Máxima (h)</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php while($c = $res->fetch_assoc()): ?>
        <tr>
            <td><?=$c['id_cargo']?></td>
            <td><?=htmlspecialchars($c['nome_cargo'])?></td>
            <td><?=htmlspecialchars($c['descricao'])?></td>
            <td><?=number_format($c['salario_base'],2,',','.')?></td>
            <td><?=$c['carga_horaria_max']?></td>
            <td>
                <div class="action-buttons">
                    <a href="?editar=<?=$c['id_cargo']?>">Editar</a>
                    <a href="?excluir=<?=$c['id_cargo']?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
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

