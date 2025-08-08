<div class="content-module gap-3">
    <div class="d-flex flex-column w-100">
        <section>
            <div class="target p-3 rounded-3 d-flex justify-content-between align-items-center">
                <div style="background-color:rgba(0, 0, 0, 0.09);" class="d-flex flex-column justify-content-between align-items-center text-white gap-2 p-3 rounded-3">
                    <h6 class="text-white fw-light">Total Citas Médicas</h6>
                    <count-up class="fw-semibold fs-1"><?php echo htmlspecialchars(count($citas)) ?></count-up>
                </div>
                <button class="btnAdd d-flex gap-2 px-3 py-2 text-white align-items-center" data-bs-toggle="modal" data-bs-target="#addCita">
                    <i class="bi bi-plus-circle-fill fs-5"></i>
                    <span class="text-white">Agendar cita</span>
                </button>
            </div>

            <div class="modal fade" id="addCita" tabindex="-1" aria-labelledby="addCitaLabel">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="title-module modal-title fs-5" id="addCitaLabel">Agendar Cita Médica</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span id="message-alert" class="d-flex w-100 alert alert-danger fs-8 d-none mb-3"></span>
                            <form id="citasForm" class="d-flex align-items-center overflow-hidden" method="POST">
                                <div id="formStep1" class="d-flex flex-column gap-3">
                                    <section class="d-flex gap-3">
                                        <div class="d-flex flex-column w-50">
                                            <label for="fecha_cita">Fecha Cita</label>
                                            <input type="date" id="fecha_cita" name="fecha_cita" class="form-control" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                                        </div>
                                        <div class="d-flex flex-column w-50">
                                            <label for="hora_inicio">Hora Inicio de la Cita</label>
                                            <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" value="07:00" required>
                                        </div>
                                    </section>
                                    <section class="d-flex gap-3">
                                        <div class="d-flex flex-column w-100">
                                            <label for="especialidades">Especialidad del médico</label>
                                            <select id="especialidades" name="especialidad" class="form-select" required>
                                                <option value="" disabled selected>Seleccionar</option>
                                                <?php foreach ($especialidades as $especialidad) : ?>
                                                    <option value="<?= htmlspecialchars($especialidad->id_especialidad) ?>">
                                                        <?= htmlspecialchars($especialidad->nombre_especialidad) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column w-100">
                                            <label for="duracion">Duración de la cita (minutos)</label>
                                            <input type="number" id="duracion" name="duracion" class="form-control" value="15" min="15" max="40" required>
                                        </div>
                                    </section>

                                    <button type="button" id="btnNext" class="btn-green d-flex justify-content-center align-items-center w-100 gap-2 mt-3">
                                        Validar disponibilidad
                                        <i class="bi bi-search fs-5"></i>
                                    </button>
                                </div>

                                <div id="formStep2" class="inactive d-flex flex-column h-100 w-100">
                                    <section id="contentMedicos" class="d-flex flex-column w-100 gap-3">

                                    </section>
                                </div>
                                <div id="formStep3" class="inactive d-flex flex-column h-100 w-100 gap-3">
                                    <section id="contentPacientes" class="d-flex flex-column w-100">
                                        <label for="doc_paciente">Documento del paciente</label>
                                        <input type="text" id="doc_paciente" name="doc_paciente" class="form-control" autocomplete="off" required>
                                    </section>
                                    <button class="btn-green" type="submit">Agendar cita médica</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer d-flex justify-content-end w-100">
                            <button id="btnBackStep1" class="d-none bg-transparent border-0 fs-4 text-white" type="button">
                                <i class="bi bi-arrow-left-circle fs-8"></i>
                                <span class="fs-8">Regresar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="main-content">
            <table class="table table-hover align-middle">
                <thead>
                    <th class="text-center">#</th>
                    <th>FECHA CITA</th>
                    <th>HORA INICIO</th>
                    <th class="text-start">DOCUMENTO</th>
                    <th>PACIENTE</th>
                    <th>MÉDICO</th>
                    <th>ESTADO</th>
                    <th class="text-center">ACCIONES</th>
                </thead>
                <tbody>
                    <?php if (count($citas) > 0) : ?>
                        <?php foreach ($citas as $cita) : ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars(htmlspecialchars($cita->id_cita)) ?></td>
                                <td><?= date('d/m/Y', strtotime($cita->fecha_cita)) ?></td>
                                <td><?= date('h:i A', strtotime($cita->hora_inicio)) ?></td>
                                <td class="text-start"><?= htmlspecialchars($cita->documento) ?></td>
                                <td><?= htmlspecialchars($cita->primer_nombre) . ' ' . htmlspecialchars($cita->primer_apellido) ?></td>
                                <td><?= htmlspecialchars($cita->medico_nombre) . ' ' . htmlspecialchars($cita->medico_apellido) ?></td>
                                <td>
                                    <span class="<?=
                                                    htmlspecialchars($cita->estado_cita) == 'Cancelada' ? 'status-canceled' : (
                                                        htmlspecialchars($cita->estado_cita) == 'Asistida' ? 'status-success' : (
                                                            htmlspecialchars($cita->estado_cita) == 'Programada' ? 'text-warning' : (
                                                                htmlspecialchars($cita->estado_cita) == 'Reagendada' ? 'status-reagendada' : ''
                                                            )
                                                        )
                                                    )
                                                    ?>">
                                        <?= htmlspecialchars($cita->estado_cita) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($cita->estado_cita !== 'Cancelada' && $cita->estado_cita !== 'Asistida') : ?>
                                        <div class="dropdown">
                                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton<?= htmlspecialchars($cita->id_cita) ?>">
                                                <i class="bi bi-three-dots-vertical fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <button data-id="<?= htmlspecialchars($cita->id_cita) ?>" class="dropdown-item" type="button"
                                                        data-bs-toggle="modal" data-bs-target="#modalReagendar<?= htmlspecialchars($cita->id_cita) ?>">
                                                        Reagendar cita
                                                    </button>
                                                </li>
                                                <?php if ($cita->estado_cita !== 'Cancelada') : ?>
                                                    <li>
                                                        <button class="dropdown-item btnAsistida" data-id="<?= htmlspecialchars($cita->id_cita) ?>" type="button">
                                                            Cancelar cita
                                                        </button>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                    <div class="d-flex gap-1">
                                        <div>
                                            <div class="modal fade" id="modalReagendar<?= htmlspecialchars($cita->id_cita) ?>" tabindex="-1" aria-labelledby="modalReagendarLabel<?= htmlspecialchars($cita->id_cita) ?>">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title title-module" id="modalReagendarLabel<?= htmlspecialchars($cita->id_cita) ?>">Reagendar cita</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <form id="reagendarCita-<?= htmlspecialchars($cita->id_cita) ?>" method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_cita" value="<?= htmlspecialchars($cita->id_cita) ?>">

                                                                <div class="mb-3">
                                                                    <label for="nueva_fecha<?= htmlspecialchars($cita->id_cita) ?>" class="form-label">Nueva fecha</label>
                                                                    <input type="date" name="fecha_cita" id="nueva_fecha<?= htmlspecialchars($cita->id_cita) ?>" value="<?= $cita->fecha_cita ?>" class="form-control">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="nueva_hora<?= htmlspecialchars($cita->id_cita) ?>" class="form-label">Nueva hora</label>
                                                                    <input type="time" name="hora_inicio" id="nueva_hora<?= htmlspecialchars($cita->id_cita) ?>" value="<?= $cita->hora_inicio ?>" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btnReagendar reagendarCita btn-action w-100"
                                                                    data-id="<?= htmlspecialchars(htmlspecialchars($cita->id_cita)) ?>">
                                                                    Reagendar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center">No hay citas programadas.</td>
                        </tr>
                    <?php endif; ?>
            </table>
        </section>
    </div>

    <div class="calendar-content p-3 d-flex flex-column gap-3 rounded-3">
        <h4 class="title-module fw-bold">Próximas citas</h4>
        <div id='calendar'></div>
    </div>
</div>