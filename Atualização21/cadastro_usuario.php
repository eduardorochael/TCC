<?php
session_start();
include('conexao.php');

// Verifica se o usuário é admin
if ($_SESSION['tipo'] !== 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $usuario = trim($_POST['usuario']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $tipo = $_POST['tipo'];

    // Insere o usuário no banco de dados
    $sql = "INSERT INTO usuarios (nome, usuario, senha, tipo) VALUES (:nome, :usuario, :senha, :tipo)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':tipo', $tipo);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
    } else {
        echo "<p style='color: red;'>Erro ao cadastrar usuário.</p>";
    }
}
?>

<?php include('cabecalho.php'); ?>
<div class="form-container">
    <h2>Cadastro de Usuário</h2>
    <form method="POST" action="cadastro_usuario.php">
        <div>
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div>
            <label for="usuario">Usuário</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <div>
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <div>
            <label for="tipo">Tipo</label>
            <select id="tipo" name="tipo" required>
                <option value="admin">Admin</option>
                <option value="recepcionista">Recepcionista</option>
                <option value="enfermeira">Enfermeira</option>
                <option value="medico">Médico</option>
            </select>
        </div>
        <div>
            <button type="submit">Cadastrar</button>
        </div>
    </form>
</div>
<?php include('rodape.php'); ?>