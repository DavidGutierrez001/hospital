<div>
    <div class="target d-flex justify-content-between w-100 p-3 align-items-center rounded-3 mb-4">
        <div style="background-color:rgba(0, 0, 0, 0.09);" class="d-flex flex-column justify-content-between align-items-center text-white gap-2 p-3 rounded-3">
            <h6 class="text-white fw-light">Total Médicos</h6>
            <count-up class="fw-semibold fs-1"><?php echo htmlspecialchars(count($medicos)) ?></count-up>
        </div>
        <div>
            <button class="btnAdd d-flex gap-2 px-3 py-2 shadow text-white align-items-center" data-bs-toggle="modal" data-bs-target="#addMedico">
                <i class="bi bi-plus-circle-fill fs-5"></i>
                <span class="text-white">Nuevo Médico</span>
            </button>
        </div>

        <div class="modal fade" id="addMedico" tabindex="-1" aria-labelledby="addMedicoLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="title-module modal-title fs-5" id="addMedicoLabel">Nuevo Médico</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formMedico" class="d-flex align-items-center overflow-hidden">
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
                                        <label for="contacto">Contacto</label>
                                        <input type="text" id="contacto" name="contacto" class="form-control" required autocomplete="off">
                                    </div>
                                    <div class="d-flex flex-column w-50">
                                        <label for="especialidad">Especialidad</label>
                                        <select name="especialidad" id="especialidad">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <?php foreach ($especialidades as $especialidad): ?>
                                                <option value="<?php echo htmlspecialchars($especialidad->id_especialidad); ?>">
                                                    <?php echo htmlspecialchars($especialidad->nombre_especialidad); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </section>
                                <button type="button" id="btnNext" class="p-3 btn-green text-white mt-3">
                                    Siguiente Paso
                                    <i class="bi bi-arrow-right-circle"></i>
                                </button>
                            </div>

                            <div id="formStep2" class="inactive d-flex flex-column justify-content-around h-100 w-100 gap-3">
                                <h3 class="title-module fw-bold">Crear una cuenta</h3>

                                <section class="gap-3 d-flex flex-column w-100">
                                    <div class="d-flex flex-column w-100">
                                        <label for="email">Correo Electrónico</label>
                                        <input type="email" id="email" name="email" class="form-control" required autocomplete="off">
                                    </div>
                                    <div class="d-flex flex-column w-100">
                                        <label for="password">Contraseña</label>
                                        <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password">
                                    </div>
                                </section>

                                <button class="p-3 btn-green text-white w-100" id="btnCreate" type="button">
                                    Crear Médico
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-start">
                        <button id="btnBackStep1" class="d-none bg-transparent border-0 fs-4 text-white" type="button">
                            <i class="bi bi-arrow-left-circle fs-5"></i>
                            <span class="fs-6">Regresar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center" scope="col">#</th>
                    <th class="w-25" scope="col">MEDICO</th>
                    <th scope="col">ESPECIALIDAD</th>
                    <th class="text-start" scope="col">CONTACTO</th>
                    <th scope="col">ESTADO</th>
                    <th scope="col">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicos as $medico): ?>
                    <tr>
                        <td class="text-center" scope="row">
                            <?php echo htmlspecialchars($medico->id_medico); ?>
                        </td>
                        <td class="d-flex flex-column" scope="row">
                            <?php echo htmlspecialchars($medico->primer_nombre . ' ' . $medico->segundo_nombre . ' ' . $medico->primer_apellido . ' ' . $medico->segundo_apellido); ?>
                            <span class="text-secondary">
                                <?php echo htmlspecialchars($medico->email); ?>
                            </span>
                        </td>
                        <td scope="row">
                            <?php echo htmlspecialchars($medico->nombre_especialidad); ?>
                        </td>
                        <td class="text-start" scope="row">
                            <?php echo htmlspecialchars($medico->contacto); ?>
                        </td>
                        <td scope="row">
                            <?php if ($medico->activo): ?>
                                <div class="d-flex">
                                    <div style="background-color: #1a2b20" class="d-flex gap-2 justify-content-center align-items-center p-1 rounded-1">
                                        <span class="activo"></span>
                                        <span class="text-success">Activo</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="d-flex">
                                    <div style="background-color: #2b1c15;" class="d-flex gap-2 justify-content-center align-items-center p-1 rounded-1">
                                        <span class="inactivo"></span>
                                        <span class="text-danger">Inactivo</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <td>
                            <button data-id="<?= htmlspecialchars($medico->id_medico) ?>" class="btnEdit btn btn-success btn-sm text-white">
                                <i class="bi bi-pencil-square fs-6"></i>
                            </button>
                            <button class="btnDelete btn btn-danger btn-sm" id="<?= $medico->id_medico ?>">
                                <i class="bi bi-trash-fill fs-6"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>