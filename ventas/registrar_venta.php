<?php
session_start();
require_once '../conexion.php';
$titulo = "Registrar Venta | Servitec";

include '../includes/header.php';
include '../includes/navbar.php';

// Solo usuarios autenticados
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

// Obtener productos con stock disponible
$productos = $conn->query("SELECT * FROM productos WHERE stock > 0");
?>

<main class="container py-5">
  <div class="text-center mb-5">
    <h1 class="display-6 text-primary">Registrar Nueva Venta</h1>
    <p class="text-muted">Selecciona los productos que deseas vender y define las cantidades.</p>
  </div>
<div class="container-lg ">
  <form action="guardar_venta.php" method="POST">
    <div class="table-responsive">

      <!-- Filtro por producto -->
<div class="row mb-4">
  <div class="col-md-6">
    <label for="filtroProducto" class="form-label">Filtrar por producto:</label>
    <select id="filtroProducto" class="form-select">
      <option value="">-- Mostrar todos --</option>
      <?php
      $productos->data_seek(0); // Reiniciar puntero para recorrer de nuevo
      while($prod = $productos->fetch_assoc()):
      ?>
        <option value="<?= htmlspecialchars($prod['nombre']) ?>">
          <?= htmlspecialchars($prod['nombre']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

</div>
      <table class="table table-bordered table-hover align-middle ">
        <thead class="table-light">
          <tr>
            <th>Producto</th>
            <th>Precio (COP)</th>
            <th>Stock Disponible</th>
            <th>Cantidad a Vender</th>
          </tr>
        </thead>
        <tbody>
              <?php  
              $productos->data_seek(0); // Reiniciar puntero otra vez para recorrer
                while($prod = $productos->fetch_assoc()): ?>
                <tr class="producto-row" data-nombre="<?= htmlspecialchars($prod['nombre']) ?>">
          <td><?= htmlspecialchars($prod['nombre']) ?></td>
          <td>$<?= number_format($prod['precio'], 0, ',', '.') ?></td>
          <td><?= $prod['stock'] ?></td>
          <td style="max-width: 120px;">
            <input type="number"
                  name="cantidad[<?= $prod['id'] ?>]"
                  class="form-control"
                  min="0"
                  max="<?= $prod['stock'] ?>"
                  value="0">
          </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-between mt-4">
      <a href="../productos/lista_productos.php" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left-circle"></i> Volver a productos
      </a>
      <button type="submit" class="btn btn-success px-4">
        <i class="bi bi-check-circle"></i> Registrar Venta
      </button>
    </div>
  </form>
  </div>
</main>
<script>
  document.getElementById('filtroProducto').addEventListener('change', function () {
    const filtro = this.value.toLowerCase();
    document.querySelectorAll('.producto-row').forEach(row => {
      const nombre = row.dataset.nombre.toLowerCase();
      row.style.display = filtro === '' || nombre === filtro ? '' : 'none';
    });
  });
</script>

<?php include '../includes/footer.php'; ?>