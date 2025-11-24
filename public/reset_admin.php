<?php
require_once __DIR__ . '/../src/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    $password = 'admin123';
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Try to update first
    $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE username = 'admin'");
    $stmt->execute([$hash]);

    if ($stmt->rowCount() > 0) {
        echo "<h1>Sucesso!</h1>";
        echo "<p>Senha do admin resetada com sucesso para: <strong>$password</strong></p>";
    } else {
        // If update affected 0 rows, maybe user doesn't exist, try insert
        // Check if user exists first to distinguish between "same password" and "no user"
        $check = $db->prepare("SELECT id FROM users WHERE username = 'admin'");
        $check->execute();

        if ($check->fetch()) {
            echo "<h1>Aviso</h1>";
            echo "<p>A senha já era essa ou o usuário existe mas não precisou atualizar.</p>";
        } else {
            $stmt = $db->prepare("INSERT INTO users (username, password_hash) VALUES ('admin', ?)");
            $stmt->execute([$hash]);
            echo "<h1>Sucesso!</h1>";
            echo "<p>Usuário admin criado com senha: <strong>$password</strong></p>";
        }
    }
    echo "<br><a href='/admin/login'>Ir para Login</a>";

} catch (Exception $e) {
    echo "<h1>Erro</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
