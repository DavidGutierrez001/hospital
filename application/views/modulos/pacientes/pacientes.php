<div>
    <div class="target d-flex justify-content-between w-100 p-3 align-items-center rounded-3 mb-4">
        <div style="background-color:rgba(0, 0, 0, 0.09);" class="d-flex flex-column justify-content-between align-items-center text-white gap-2 p-3 rounded-3">
            <h6 class="text-white fw-light">Total Pacientes</h6>
            <count-up class="fw-semibold fs-1"><?php echo htmlspecialchars(count($pacientes)) ?></count-up>
        </div>
        <div>
            <button class="btnAdd d-flex gap-2 px-3 py-2 shadow text-white align-items-center" data-bs-toggle="modal" data-bs-target="#addPacient">
                <i class="bi bi-plus-circle-fill fs-5"></i>
                <span class="text-white">Nuevo Paciente</span>
            </button>
        </div>
    </div>

    <div class="modal fade" id="addPacient" tabindex="-1" aria-labelledby="addPacientLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="title-module modal-title fs-5 fw-bold" id="addPacientLabel">Agregar Nuevo Paciente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPaciente" class="d-flex position-relative overflow-hidden">
                        <div id="formStep1" class="d-flex flex-column gap-3">
                            <section class="d-flex gap-3">
                                <div class="d-flex flex-column w-50">
                                    <label for="primer_nombre">Primer Nombre</label>
                                    <input type="text" id="primer_nombre" name="primer_nombre" class="form-control" required autocomplete="off">
                                </div>
                                <div class="d-flex flex-column w-50">
                                    <label for="segundo_nombre">Segundo Nombre</label>
                                    <input type="text" id="segundo_nombre" name="segundo_nombre" class="form-control" autocomplete="off">
                                </div>
                            </section>
                            <section class="d-flex gap-3">
                                <div class="d-flex flex-column w-50">
                                    <label for="primer_apellido">Primer Apellido</label>
                                    <input type="text" id="primer_apellido" name="primer_apellido" class="form-control" required autocomplete="off">
                                </div>
                                <div class="d-flex flex-column w-50">
                                    <label for="segundo_apellido">Segundo Apellido</label>
                                    <input type="text" id="segundo_apellido" name="segundo_apellido" class="form-control" autocomplete="off">
                                </div>
                            </section>
                            <section class="d-flex gap-3">
                                <div class="d-flex flex-column w-50">
                                    <label for="fecha_nacimiento">Fecha Nacimiento</label>
                                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
                                </div>
                                <div class="d-flex flex-column w-50">
                                    <label for="genero">Género</label>
                                    <select name="genero" id="genero" class="form-select" required>
                                        <option value="" disabled selected></option>
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                            </section>
                            <section class="d-flex gap-3">
                                <div class="d-flex flex-column w-50">
                                    <label for="documento">Documento</label>
                                    <input type="text" id="documento" name="documento" class="form-control" required autocomplete="off">
                                </div>
                                <div class="d-flex flex-column w-50">
                                    <label for="tipo_documento">Tipo Documento</label>
                                    <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                                        <option value="" disabled selected></option>
                                        <option value="Cedula de ciudadania">Cédula de ciudadanía</option>
                                        <option value="Cedula de extranjeria">Cédula de extranjería</option>
                                    </select>
                                </div>
                            </section>
                            <section class="d-flex gap-3">
                                <div class="d-flex flex-column w-50">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" id="telefono" name="telefono" class="form-control" required autocomplete="off">
                                </div>
                                <div class="d-flex flex-column w-50">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" id="direccion" name="direccion" class="form-control" required autocomplete="off">
                                </div>
                            </section>
                            <section>
                                <div class="d-flex flex-column">
                                    <label for="estado_civil">Estado Civil</label>
                                    <select name="estado_civil" id="estado_civil" class="form-select" required>
                                        <option value="" disabled selected></option>
                                        <option value="soltero">Soltero</option>
                                        <option value="casado">Casado</option>
                                        <option value="divorciado">Divorciado</option>
                                        <option value="viudo">Viudo</option>
                                        <option value="union libre">Unión libre</option>
                                    </select>
                                </div>
                            </section>
                            <button type="button" id="btnNext" class="p-3 btn-green text-white mt-3">
                                Siguiente Paso
                            </button>
                        </div>

                        <div id="formStep2" class="inactive d-flex flex-column justify-content-around align-items-center h-100 w-100 gap-3">
                            <h1 class="title-module text-center">Crear una cuenta al Paciente</h1>
                            <section class="gap-4 d-flex flex-column">
                                <div class="d-flex flex-column w-100">
                                    <label for="email">Correo Electrónico</label>
                                    <input type="email" id="email" name="email" class="form-control" required autocomplete="off">
                                </div>
                                <div class="d-flex flex-column w-100">
                                    <label for="password">Contraseña</label>
                                    <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password">
                                </div>
                            </section>
                            <button class="p-3 btn-green text-white" id="btnCreate" type="button">
                                <i class="bi bi-check2"></i>
                                Crear Paciente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <table id="tablaPacientes" class="table nowrap">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>NOMBRES</th>
                    <th>APELLIDOS</th>
                    <th class="text-start">DOCUMENTO</th>
                    <th class="text-start">CORREO</th>
                    <th class="text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pacientes as $p): ?>
                    <tr>
                        <td class="text-center"><?php echo htmlspecialchars($p->id_paciente) ?></td>
                        <td><?php echo htmlspecialchars($p->primer_nombre . ' ' . $p->segundo_nombre) ?></td>
                        <td><?php echo htmlspecialchars($p->primer_apellido . ' ' . $p->segundo_apellido) ?></td>
                        <td class="text-start">
                            <div class="copy-container">
                                <span class="copyText"><?= htmlspecialchars($p->documento) ?></span>
                                <button class="bg-transparent copyButton" type="button">
                                    <i style="color: var(--texto);" class="bi bi-copy fs-6"></i>
                                </button>
                            </div>
                        </td>
                        <td class="text-start"><?= htmlspecialchars($p->email) ?></td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton<?= htmlspecialchars($p->id_paciente) ?>">
                                    <i class="bi bi-three-dots-vertical fs-6"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button data-id="<?= htmlspecialchars($p->id_paciente) ?>" class="dropdown-item btnEdit" type="button" title="Editar">
                                            Modificar paciente
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item btnDelete" data-id="<?= htmlspecialchars($p->id_paciente) ?>" type="button" title="Eliminar">
                                            Eliminar paciente
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>