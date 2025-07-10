<div class="content-edit d-flex flex-column align-items-center gap-3">
<form id="formPaciente">
        <div class="d-flex flex-column gap-3">
            <h1 class="title-module fw-bold my-3">Actualizar Paciente</h1>
            <p>Información personal</p>
            <section class="d-flex gap-3">
                <div class="d-flex flex-column w-50">
                    <label for="primer_nombre">Primer nombre</label>
                    <input type="text" id="primer_nombre" name="primer_nombre" class="form-control" value="<?php echo htmlspecialchars($paciente['primer_nombre'] ?? NULL) ?>" required>
                </div>
                <div class="d-flex flex-column w-50">
                    <label for="segundo_nombre">Segundo nombre</label>
                    <input type="text" id="segundo_nombre" name="segundo_nombre" class="form-control" value="<?php echo htmlspecialchars($paciente['segundo_nombre'] ?? NULL) ?>">
                </div>
            </section>
            <section class="d-flex gap-3">
                <div class="d-flex flex-column w-50">
                    <label for="primer_apellido">Primer apellido</label>
                    <input type="text" id="primer_apellido" name="primer_apellido" class="form-control" value="<?php echo htmlspecialchars($paciente['primer_apellido'] ?? NULL) ?>" required>
                </div>
                <div class="d-flex flex-column w-50">
                    <label for="segundo_apellido">Segundo apellido</label>
                    <input type="text" id="segundo_apellido" name="segundo_apellido" class="form-control" value="<?php echo htmlspecialchars($paciente['segundo_apellido'] ?? NULL) ?>">
                </div>
            </section>
            <section class="d-flex gap-3">
                <div class="d-flex flex-column w-50">
                    <label for="fecha_nacimiento">Fecha nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" value="<?php echo htmlspecialchars($paciente['fecha_nacimiento'] ?? NULL) ?>" required>
                </div>
                <div class="d-flex flex-column w-50">
                    <label for="genero">Género</label>
                    <select name="genero" id="genero" class="form-select" required>
                        <option value="" disabled <?php echo !isset($paciente['genero']) ? 'selected' : NULL; ?>></option>
                        <option value="masculino" <?php echo (isset($paciente['genero']) && $paciente['genero'] == 'masculino') ? 'selected' : NULL; ?>>Masculino</option>
                        <option value="femenino" <?php echo (isset($paciente['genero']) && $paciente['genero'] == 'femenino') ? 'selected' : NULL; ?>>Femenino</option>
                        <option value="otro" <?php echo (isset($paciente['genero']) && $paciente['genero'] == 'otro') ? 'selected' : NULL; ?>>Otro</option>
                    </select>
                </div>
            </section>

            <section class="d-flex gap-3">
                <div class="d-flex flex-column w-50">
                    <label for="documento">Documento</label>
                    <input type="text" id="documento" name="documento" class="form-control" value="<?php echo htmlspecialchars($paciente['documento'] ?? NULL) ?>" required>
                </div>
                <div class="d-flex flex-column w-50">
                    <label for="tipo_documento">Tipo Doc.</label>
                    <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                        <option value="Cedula de ciudadania" <?php echo (isset($paciente['tipo_documento']) && $paciente['tipo_documento'] == 'Cedula de ciudadania') ? 'selected' : NULL; ?>>Cédula ciudadanía</option>
                        <option value="Cedula de extranjeria" <?php echo (isset($paciente['tipo_documento']) && $paciente['tipo_documento'] == 'Cedula de extranjeria') ? 'selected' : NULL; ?>>Cédula extrajenría</option>
                    </select>
                </div>

                <div>
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($paciente['telefono'] ?? NULL) ?>">
                </div>
            </section>

            <section class="d-flex gap-3">
                <div class="d-flex flex-column w-50">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo htmlspecialchars($paciente['direccion'] ?? NULL) ?>">
                </div>
                <div class="d-flex flex-column w-50">
                    <label for="estado_civil">Estado civil</label>
                    <select name="estado_civil" id="estado_civil" class="form-select">
                        <option value="" disabled <?php echo !isset($paciente['estado_civil']) ? 'selected' : NULL; ?>></option>
                        <option value="soltero" <?php echo (isset($paciente['estado_civil']) && $paciente['estado_civil'] == 'soltero') ? 'selected' : NULL; ?>>Soltero</option>
                        <option value="casado" <?php echo (isset($paciente['estado_civil']) && $paciente['estado_civil'] == 'casado') ? 'selected' : NULL; ?>>Casado</option>
                        <option value="divorciado" <?php echo (isset($paciente['estado_civil']) && $paciente['estado_civil'] == 'divorciado') ? 'selected' : NULL; ?>>Divorciado</option>
                        <option value="viudo" <?php echo (isset($paciente['estado_civil']) && $paciente['estado_civil'] == 'viudo') ? 'selected' : NULL; ?>>Viudo</option>
                    </select>
                </div>
            </section>
        </div>
        <div class="d-flex w-100 justify-content-between mt-3">
            <button id="btnBack" type="button" class="btn-action bg-secondary d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left-short fs-5"></i>
                Regresar
            </button>
            <button id="btnUpdate" data-id="<?php echo $paciente['id_paciente'] ?>" class="btn-action d-flex align-items-center gap-2">
                Actualizar Paciente
                <i class="bi bi-pencil-square fs-5"></i>
            </button>

        </div>
    </form>
</div>
</div>