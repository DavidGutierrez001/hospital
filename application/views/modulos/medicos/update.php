<div class="content-edit d-flex flex-column align-items-center gap-3">
    <button id="btnBack" type="button" class=" bg-secondary d-flex align-items-center gap-2 rounded-circle">
        <i class="bi bi-arrow-left-short fs-5"></i>
    </button>

    <form id="formMedico">
        <div class="d-flex flex-column gap-3">
            <h1 class="title-module fw-bold my-3">Actualizar Médico</h1>
            <p>Información del médico</p>
            <section class="d-flex gap-3">
                <div class="d-flex flex-column w-50">
                    <label for="primer_nombre">Primer nombre</label>
                    <input type="text" id="primer_nombre" name="primer_nombre" class="form-control" value="<?php echo htmlspecialchars($medicos->primer_nombre ?? NULL) ?>" required>
                </div>
                <div class="d-flex flex-column w-50">
                    <label for="segundo_nombre">Segundo nombre</label>
                    <input type="text" id="segundo_nombre" name="segundo_nombre" class="form-control" value="<?php echo htmlspecialchars($medicos->segundo_nombre ?? NULL) ?>">
                </div>
            </section>
            <section class="d-flex gap-3">
                <div class="d-flex flex-column w-50">
                    <label for="primer_apellido">Primer apellido</label>
                    <input type="text" id="primer_apellido" name="primer_apellido" class="form-control" value="<?php echo htmlspecialchars($medicos->primer_apellido ?? NULL) ?>" required>
                </div>
                <div class="d-flex flex-column w-50">
                    <label for="segundo_apellido">Segundo apellido</label>
                    <input type="text" id="segundo_apellido" name="segundo_apellido" class="form-control" value="<?php echo htmlspecialchars($medicos->segundo_apellido ?? NULL) ?>">
                </div>
            </section>
            <section class="d-flex gap-3">
                <div class="d-flex flex-column w-100">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($medicos->email ?? NULL) ?>" required>
                </div>
            </section>
            <section class="d-flex gap-3">
                <div class="d-flex flex-column w-50">
                    <label for="contacto">Contacto</label>
                    <input type="text" id="contacto" name="contacto" class="form-control" value="<?php echo htmlspecialchars($medicos->contacto ?? NULL) ?>">
                </div>
                <div class="d-flex flex-column w-50">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-select">
                        <option value="1" <?php echo htmlspecialchars($medicos->activo == 1) ? 'selected' : ''; ?>>Activo</option>
                        <option value="0" <?php echo htmlspecialchars($medicos->activo == 0) ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>
            </section>
            <section class="d-flex gap-3">
                <div class="d-flex flex-column w-100">
                    <label for="especialidad">Especialidad</label>
                    <select name="especialidad" id="especialidad" class="form-select">
                        <option value="" disabled selected>Seleccionar</option>
                        <?php foreach ($especialidades as $especialidad): ?>
                            <option value="<?php echo htmlspecialchars($especialidad->id_especialidad); ?>" <?php echo htmlspecialchars($medicos->id_especialidad == $especialidad->id_especialidad) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($especialidad->nombre_especialidad); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </section>
        </div>
        <div class="d-flex w-100 justify-content-between mt-3">
            <button type="button" id="btnUpdate" data-id="<?php echo $medicos->id_medico ?>" class="btn-action d-flex align-items-center justify-content-center gap-2 w-100">
                Actualizar Médico
                <i class="bi bi-pencil-square fs-5"></i>
            </button>
        </div>
    </form>
</div>