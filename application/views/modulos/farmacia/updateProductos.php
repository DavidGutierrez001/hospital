<div class="content-edit d-flex flex-column align-items-center gap-3">
    <button id="btnBack" type="button" class="d-flex align-items-center gap-2 rounded-circle">
        <i class="bi bi-arrow-left-short fs-5"></i>
    </button>

    <form id="formProducto">
        <div class="d-flex flex-column gap-3">
            <h2 class="title-module fw-bold">Actualizar Producto</h2>
            <section>
                <div class="d-flex flex-column">
                    <label for="nombre_comercial">Nombre Comercial</label>
                    <input type="text" id="nombre_comercial" name="nombre_comercial" class="form-control" value="<?php echo htmlspecialchars($producto->nombre_comercial ?? NULL) ?>" required>
                </div>
            </section>
            <section>
                <div class="d-flex flex-column">
                    <label for="descripcion">Descripcion Producto</label>
                    <textarea style="max-height: 120px; min-height: 120px;" id="descripcion" name="descripcion" class="form-control" required><?php echo htmlspecialchars($producto->descripcion ?? NULL) ?></textarea>
                </div>
            </section>
            <section>
                <div class="d-flex flex-column">
                    <label for="precio">Precio</label>
                    <input type="number" id="precio" name="precio" class="form-control" value="<?php echo htmlspecialchars($producto->precio ?? NULL) ?>" step="0.01" required>
                </div>
            </section>
            <section>
                <div class="d-flex flex-column">
                    <label for="receta_especial">Receta Especial</label>
                    <select id="receta_especial" name="receta_especial" class="form-control" required>
                        <option value="1" <?php echo (isset($producto->receta_especial) && $producto->receta_especial == '1') ? 'selected' : ''; ?>>Sí</option>
                        <option value="0" <?php echo (isset($producto->receta_especial) && $producto->receta_especial == '0') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
            </section>
            <section>
                <div class="d-flex flex-column">
                    <label for="activo">Activo</label>
                    <select id="activo" name="activo" class="form-control" required>
                        <option value="1" <?php echo (isset($producto->activo) && $producto->activo == '1') ? 'selected' : ''; ?>>Sí</option>
                        <option value="0" <?php echo (isset($producto->activo) && $producto->activo == '0') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
            </section>
            
            <section>
                <div class="d-flex flex-column">
                    <label for="fecha_registro">Fecha de Registro</label>
                    <input type="date" id="fecha_registro" name="fecha_registro" class="form-control" value="<?php echo htmlspecialchars($producto->fecha_registro ?? NULL) ?>" required>
                </div>
            </section>
        </div>
        <div class="d-flex justify-content-between mt-3">
            <button type="button" id="btnUpdate" data-id="<?= $producto->id_producto ?>" class="btn-action w-100">
                Actualizar Producto <i class="bi bi-pencil-square fs-5"></i>
            </button>
        </div>
    </form>
</div>