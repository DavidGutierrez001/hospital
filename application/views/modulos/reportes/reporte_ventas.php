<div>
    <section class="d-flex justify-content-between align-items-center pb-3">
        <h6 class="title-module fs-5">Reporte de ventas</h6>
        <div class="d-flex gap-3 align-items-center">
            <div class="dropdown dropdown-center">
                <button class="d-flex justify-content-between align-items-center gap-3 py-2 px-3 btnAdd text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-download"></i>
                    Exportar reporte
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#exportarVentasModal">Por mes</button>
                    </li>
                </ul>
            </div>

            <div class="modal fade" id="exportarVentasModal" tabindex="-1" aria-labelledby="exportarVentasLabel">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title title-module" id="exportarVentasLabel">Generar reporte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <form id="formExportProducto" action="/hospital/reportes/export_ventas" method="GET">
                            <div class="modal-body">
                                <section class="mb-3">
                                    <label for="producto_exportar" class="form-label">Seleccione el producto</label>
                                    <select class="form-select" id="producto_exportar" name="producto_exportar">
                                        <option selected value="">Todos los productos</option>
                                        <?php if (isset($productos) && is_iterable($productos)): ?>
                                            <?php foreach ($productos as $producto): ?>
                                                <option value="<?= htmlspecialchars($producto->id_producto) ?>">
                                                    <?= htmlspecialchars($producto->nombre_comercial) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </section>
                                <section>
                                    <label for="fecha_producto" class="form-label">Seleccione el mes</label>
                                    <input type="month" class="form-control" id="fecha_producto" name="fecha_producto" value="<?= date('Y-m') ?>" required>
                                </section>
                            </div>
                            <div class="modal-footer">
                                <button style="height: 2.5rem;" type="submit" class="btn-green px-3 py-2 text-white">
                                    Exportar PDF <i class="bi bi-file-earmark-pdf-fill"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </section>
</div>

<div class="main-content">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>PRODUCTO</th>
                <th>FECHA VENTA</th>
                <th>PRECIO</th>
                <th>ESTADO</th>
                <th>PACIENTE</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($reportes_ventas) && is_iterable($reportes_ventas)): ?>
                <?php foreach ($reportes_ventas as $venta): ?>
                    <tr>
                        <td>
                            <div class="d-flex flex-column">
                                <span><?= htmlspecialchars($venta->nombre_comercial) ?></span>
                            </div>
                        </td>
                        <td><?= htmlspecialchars(date('Y-m-d', strtotime($venta->fecha_venta))) ?></td>
                        <td><?= htmlspecialchars(number_format($venta->total_venta, 2)) ?></td>
                        <td><?= htmlspecialchars($venta->estado_venta) ?></td>
                        <td>
                            <div class="d-flex flex-column">
                                <span><?= htmlspecialchars($venta->primer_nombre) . ' ' . htmlspecialchars($venta->primer_apellido) ?></span>
                                <span><?= htmlspecialchars($venta->documento) ?></span>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay datos de ventas disponibles.</td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>
</div>
