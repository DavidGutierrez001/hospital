<div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-ventas-tab" data-bs-toggle="tab" data-bs-target="#nav-ventas" type="button" role="tab" aria-controls="nav-ventas" aria-selected="true">Ventas</button>
            <button class="nav-link" id="nav-productos-tab" data-bs-toggle="tab" data-bs-target="#nav-productos" type="button" role="tab" aria-controls="nav-productos" aria-selected="false">Productos</button>
            <button class="nav-link" id="nav-inventario-tab" data-bs-toggle="tab" data-bs-target="#nav-inventario" type="button" role="tab" aria-controls="nav-inventario" aria-selected="false">Inventario</button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade mt-3 show active" id="nav-ventas" role="tabpanel" aria-labelledby="nav-ventas-tab" tabindex="0">
            <div class="d-flex flex-column w-100">
                <section>
                    <div class="target p-3 rounded-3 d-flex justify-content-between align-items-center">
                        <div style="background-color:rgba(0, 0, 0, 0.09);" class="d-flex flex-column justify-content-between align-items-center text-white gap-2 p-3 rounded-3">
                            <h6 class="text-white fw-light">Total Ventas</h6>
                            <count-up class="fw-semibold fs-1"><?php echo htmlspecialchars(count($ventas)) ?></count-up>
                        </div>
                        <div>
                            <button class="btnAdd d-flex gap-2 px-3 py-2 text-white align-items-center" data-bs-toggle="modal" data-bs-target="#addVenta">
                                <i class="bi bi-plus-circle-fill fs-5"></i>
                                <span class="text-white">Nueva Venta</span>
                            </button>
                            <div class="modal fade modal-lg" id="addVenta" tabindex="-1" aria-labelledby="modalVenta">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="title-module" id="exampleModalLabel">Registrar Venta</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <form id="formVenta" action="/hospital/farmacia/register_sale" method="POST">
                                                    <section class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <label for="documento" class="form-label">Documento Paciente</label>
                                                            <div class="d-flex">
                                                                <input type="number" id="documento" name="documento" autocomplete="off">
                                                                <button type="button" id="searchPacient" class="btnAdd d-flex px-3 align-items-center">
                                                                    <i class="bi bi-search text-white fs-6"></i>
                                                                </button>
                                                            </div>
                                                            <span id="messageSearchPacient"></span>
                                                        </div>
                                                        <div>
                                                            <button type="submit" id="btnRegisterSale" class="btn-green px-3 rounded-1 fs-8">Registrar Venta</button>
                                                        </div>
                                                    </section>
                                                    <section>
                                                        <div id="stockProducts" class="d-flex flex-column gap-2 w-100">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nombre</th>
                                                                        <th class="text-center">Precio</th>
                                                                        <th class="text-center">Cantidad</th>
                                                                    </tr>
                                                                </thead>
                                                                <?php foreach ($productos_stock as $producto) : ?>
                                                                    <tr>
                                                                        <td><?= htmlspecialchars($producto->nombre_comercial) ?></td>
                                                                        <td class="text-center">$ <?= htmlspecialchars(intval($producto->precio)) ?> COP</td>
                                                                        <td class="text-center">
                                                                            <div class="d-flex justify-content-center">
                                                                                <input type="number" name="productos[<?= $producto->id_producto ?>]" class="form-control w-25" min="0">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </section>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="main-content">
                <table class="table table-hover">
                    <thead>
                        <th class="text-center">FECHA VENTA</th>
                        <th>PRODUCTO VENDIDO</th>
                        <th>PACIENTE</th>
                        <th>DOCUMENTO</th>
                        <th>TOTAL VENTA</th>
                        <th class="text-center">ESTADO</th>
                    </thead>
                    <tbody>
                        <?php foreach ($ventas as $venta) : ?>
                            <tr>
                                <td class="text-center">
                                    <div class="d-flex flex-column">
                                        <span><?= date('d-m-Y', strtotime($venta->fecha_venta)) ?></span>
                                        <span class="fs-8 text-secondary"><?= date('H:i A', strtotime($venta->fecha_venta)) ?></span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($venta->nombre_comercial) ?></td>
                                <td><?= htmlspecialchars($venta->primer_nombre . ' ' . $venta->primer_apellido) ?></td>
                                <td><?= htmlspecialchars($venta->documento) ?></td>
                                <td>$ <?= htmlspecialchars($venta->total_venta) ?> COP</td>
                                <td class="text-center">
                                    <span class="badge bg-success fw-normal"><?= htmlspecialchars($venta->estado_venta) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade mt-3" id="nav-productos" role="tabpanel" aria-labelledby="nav-productos-tab" tabindex="0">
            <div class="d-flex flex-column w-100">
                <section id="sectionProductos">
                    <div class="target p-3 rounded-3 d-flex justify-content-between align-items-center">
                        <div style="background-color:rgba(0, 0, 0, 0.09);" class="d-flex flex-column justify-content-between align-items-center text-white gap-2 p-3 rounded-3">
                            <h6 class="text-white fw-light">Total Productos</h6>
                            <count-up class="fw-semibold fs-1"><?php echo count($productos) ?></count-up>
                        </div>
                        <button class="btnAdd d-flex gap-2 px-3 py-2 text-white align-items-center" data-bs-toggle="modal" data-bs-target="#addProducto">
                            <i class="bi bi-plus-circle-fill fs-5"></i>
                            <span class="text-white">Nuevo Producto</span>
                        </button>

                        <div class="modal fade" id="addProducto" tabindex="-1" aria-labelledby="modalProducto">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="title-module" id="exampleModalLabel">Registrar Producto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <form id="formProducto">
                                                <div class="d-flex flex-column gap-2">
                                                    <div>
                                                        <label for="nombre_comercial" class="form-label">Nombre Comercial</label>
                                                        <input type="text" id="nombre_comercial" name="nombre_comercial" required>
                                                    </div>
                                                    <div>
                                                        <label for="descripcion" class="form-label">Descripción del Producto</label>
                                                        <textarea id="descripcion" name="descripcion" required></textarea>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <label for="existencias" class="form-label">Existencias</label>
                                                            <input type="number" id="existencias" name="existencias" value="" required>
                                                        </div>
                                                        <div>
                                                            <label for="Precio" class="form-label">Precio</label>
                                                            <input type="number" id="precio" name="precio" value="" required>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                                                        <input type="date" id="fecha_registro" value="<?php echo date('Y-m-d'); ?>" name="fecha_registro" required>
                                                    </div>
                                                    <div class="form-check form-switch d-flex justify-content-end my-2 gap-2">
                                                        <input type="hidden" name="receta_especial" value="0">
                                                        <input class="form-check-input" type="checkbox" name="receta_especial" value="1" role="switch" id="switchCheckRecipe">
                                                        <label for="switchCheckRecipe" class="form-label">Requiere Receta</label>
                                                    </div>

                                                </div>
                                                <button type="button" id="btnRegisterProduct" class="btn-green d-flex w-100 align-items-center justify-content-center mt-2">Registrar Producto</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div id="mainContentProducts" class="main-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>FECHA REGISTRO</th>
                            <th>NOMBRE PRODUCTO</th>
                            <th>DESCRIPCIÓN</th>
                            <th class="text-start">RECETA ESPECIAL</th>
                            <th class="text-center">PRECIO C/U</th>
                            <th>ACTIVO</th>
                            <th class="text-start">EXISTENCIAS</th>
                            <th class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto) : ?>
                            <tr>
                                <td><?= date('d-m-Y', strtotime($producto->fecha_registro)) ?></td>
                                <td><?= htmlspecialchars($producto->nombre_comercial) ?></td>
                                <td class="w-25"><?= htmlspecialchars($producto->descripcion) ?></td>
                                <td class="text-start">
                                    <div>
                                        <span><?= htmlspecialchars($producto->receta_especial == '1' ? 'Si' : 'No') ?></span>
                                    </div>
                                </td>
                                <td class="text-center">$ <?= htmlspecialchars(intval($producto->precio)) ?> COP</td>
                                <td>
                                    <div>
                                        <span><?= htmlspecialchars($producto->activo == '1' ? 'Si' : 'No') ?></span>
                                    </div>
                                </td>
                                <td class="text-start"><?= htmlspecialchars($producto->existencias == 0 ? 'Sin existencias' : $producto->existencias . ' Unidades') ?>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical fs-6"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="btnEdit dropdown-item" data-id="<?= $producto->id_producto ?>">
                                                    Modificar
                                                </button>
                                            </li>
                                            <li>
                                                <button id="btnDelete<?= $producto->id_producto ?>" data-id="<?= $producto->id_producto ?>" class="dropdown-item btnDelete">
                                                    Eliminar
                                                </button>
                                            </li>
                                            <li>
                                                <button class="btnAddExistencias dropdown-item" value="<?= $producto->id_producto ?>" data-bs-toggle="modal" data-bs-target="#modalExistencias">
                                                    Agregar Existencias
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <div class="modal fade" id="modalExistencias" tabindex="-1" aria-labelledby="modalExistenciasLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <form id="formAgregarExistencias">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Agregar Existencias</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="existenciasIdProducto" name="id_producto">
                                            <div class="mb-3">
                                                <label for="cantidad" class="form-label">Cantidad a agregar</label>
                                                <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btnAdd existencias px-3 text-white py-2">Agregar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade mt-3" id="nav-inventario" role="tabpanel" aria-labelledby="nav-inventario-tab" tabindex="0">
            <div class="d-flex flex-nowrap gap-3" style="min-height: 710px;">
                <section class="w-50 border p-3 rounded-3">
                    <h4 class="title-module">Entradas</h4>
                    <div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>FECHA MOVIMIENTO</th>
                                    <th>PRODUCTO</th>
                                    <th>CANTIDAD INGRESADA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($entradas as $entrada) : ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <span><?= date('d-m-Y', strtotime($entrada->fecha_entrada)) ?></span>
                                                <span class="opacity-75"><?= date('h:i A', strtotime($entrada->fecha_entrada)) ?></span>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($entrada->nombre_comercial) ?></td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span><?= htmlspecialchars($entrada->cantidad) ?> Unidades</span>
                                                <i class="bi bi-arrow-up-square-fill text-success fs-5"></i>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
                <section class="w-50 border p-3 rounded-3">
                    <h4 class="title-module">Salidas</h4>
                    <div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>FECHA MOVIMIENTO</th>
                                    <th>PRODUCTO</th>
                                    <th>CANTIDAD SALIDA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($salidas as $salida) : ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <span><?= date('d-m-Y', strtotime($salida->fecha_salida)) ?></span>
                                                <span class="opacity-75"><?= date('h:i A', strtotime($salida->fecha_salida)) ?></span>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($salida->nombre_comercial) ?></td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span><?= htmlspecialchars($salida->cantidad) ?> Unidades</span>
                                                <i class="bi bi-arrow-down-square-fill text-danger fs-5"></i>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

    </div>
</div>