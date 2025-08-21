<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar usuario</title>
</head>
<body>
    <h2>Registrar nuevo usuario</h2>
    <form action="guardar_usuario.php" method="POST">
        <label>Nombre completo:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="contraseña" required><br><br>

        <label>Rol:</label><br>
        <select name="rol" required>
            <option value="administrador">Administrador</option>
            <option value="vendedor">Vendedor</option>
        </select><br><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>