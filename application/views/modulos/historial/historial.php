<div class="target d-flex justify-content-end w-100 align-items-center rounded-3 p-3">
    <div class="d-flex gap-3">
        <button class="btnAdd d-flex gap-2 px-3 py-2 shadow text-white align-items-center" data-bs-toggle="modal" data-bs-target="#addHistorial">
            <i class="bi bi-plus-circle-fill fs-5"></i>
            <span class="text-white">Nueva Historia</span>
        </button>
        <div class="modal fade" id="addHistorial" tabindex="-1" aria-labelledby="addHistorialLabel">
            <div style="max-width: 45rem;" class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-xl">
                    <div class="modal-header">
                        <h1 class="title-module modal-title fs-5" id="addCitaLabel">Crear Historia Médica</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="message-alert" class="d-flex w-100 alert alert-danger fs-8 d-none mb-3"></span>
                        <form id="historialForm" class="d-flex align-items-center overflow-hidden" method="POST">
                            <div id="formStep1" class="d-flex flex-column gap-3">
                                <section class="d-flex gap-3">
                                    <div class="d-flex flex-column w-50">
                                        <label for="documento_paciente">Documento Paciente<span class="text-danger"> *</span></label>
                                        <input type="text" id="documento_paciente" name="documento_paciente" class="form-control" required autocomplete="off">
                                    </div>
                                    <div class="d-flex flex-column w-50">
                                        <label for="documento_medico">Documento Médico<span class="text-danger"> *</span></label>
                                        <input type="text" id="documento_medico" name="documento_medico" class="form-control" required autocomplete="off">
                                    </div>
                                </section>
                                <section class="d-flex gap-3">
                                    <div class="d-flex flex-column w-100">
                                        <label for="motivo_consulta">Motivo Consulta<span class="text-danger"> *</span></label>
                                        <input type="text" id="motivo_consulta" name="motivo_consulta" class="form-control" required autocomplete="off">
                                    </div>
                                </section>
                                <section class="d-flex gap-3">
                                    <div class="d-flex flex-column w-100">
                                        <label for="diagnostico">Diagnóstico<span class="text-danger"> *</span></label>
                                        <textarea id="diagnostico" name="diagnostico" class="form-area" rows="4" required></textarea>
                                    </div>
                                </section>
                                <section class="d-flex gap-3">
                                    <div class="d-flex flex-column w-100">
                                        <label for="tratamiento">Tratamiento<span class="text-danger"> *</span></label>
                                        <textarea id="tratamiento" name="tratamiento" class="form-area" required></textarea>
                                    </div>
                                </section>
                                <section class="d-flex gap-3">
                                    <div class="d-flex flex-column w-100">
                                        <label for="examen_fisico">Examen fisico<span class="text-danger"> *</span></label>
                                        <textarea id="examen_fisico" name="examen_fisico" class="form-area" required></textarea>
                                    </div>
                                </section>
                                <section class="d-flex gap-3">
                                    <div class="d-flex flex-column w-100">
                                        <label for="resultados_pruebas">Resultado Pruebas<span class="opacity-50 small fw-light"> (opcional)</span></label>
                                        <textarea id="resultados_pruebas" name="resultados_pruebas" class="form-area"></textarea>
                                    </div>
                                </section>
                                <section class="d-flex gap-3">
                                    <div class="d-flex flex-column w-100">
                                        <label for="antecedentes_personales">Antecedentes Personales<span class="opacity-50 small fw-light"> (opcional)</span></label>
                                        <textarea id="antecedentes_personales" name="antecedentes_personales" class="form-area"></textarea>
                                    </div>
                                    <div class="d-flex flex-column w-100">
                                        <label for="antecedentes_familiares">Antecedentes Familiares<span class="opacity-50 small fw-light"> (opcional)</span></label>
                                        <textarea id="antecedentes_familiares" name="antecedentes_familiares" class="form-area"></textarea>
                                    </div>
                                </section>
                                <section class="d-flex gap-3">
                                    <div class="d-flex flex-column w-100">
                                        <label for="estilo_vida">Estilo de Vida<span class="opacity-50 small fw-light"> (opcional)</span></label>
                                        <textarea id="estilo_vida" name="estilo_vida" class="form-area"></textarea>
                                    </div>
                                </section>
                                <section class="d-flex gap-3">
                                    <div class="d-flex flex-column w-100">
                                        <label for="notas_generales">Notas generales<span class="opacity-50 small fw-light"> (opcional)</span></label>
                                        <textarea id="notas_generales" name="notas_generales" class="form-area"></textarea>
                                    </div>
                                </section>
                                <button type="submit" id="btnAdd" class="btn-green d-flex justify-content-center align-items-center w-100 gap-2 mt-3">
                                    Guardar Historia Medica
                                    <i class="bi bi-check-circle-fill fs-5"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <table class="table table-hover">
        <thead>
            <th class="text-start">#</th>
            <th>FECHA CREADA</th>
            <th>PACIENTE</th>
            <th class="text-start">DOCUMENTO</th>
            <th>MÉDICO</th>
            <th class="text-start">DOCUMENTO MÉDICO</th>
            <th>MOTIVO CONSULTA</th>
            <th class="text-center">ACCIONES</th>
        </thead>
        <tbody>
            <?php foreach ($historiales as $historial) { ?>
                <tr>
                    <td class="text-start"><?= htmlspecialchars($historial->id_historial) ?></td>
                    <td><?= date('d-m-Y', strtotime($historial->fecha_creacion)) ?></td>
                    <td>
                        <?= htmlspecialchars($historial->paciente_primer_nombre) . ' ' . htmlspecialchars($historial->paciente_primer_apellido) ?>
                    </td>
                    <td class="text-start">
                        <div class="copy-container">
                            <span class="copyText"><?= htmlspecialchars($historial->paciente_documento) ?></span>
                            <button class="bg-transparent copyButton">
                                <i style="color: var(--texto);" class="bi bi-copy fs-6"></i>
                            </button>
                        </div>
                    </td>
                    <td><?= htmlspecialchars($historial->medico_primer_nombre) . ' ' . htmlspecialchars($historial->medico_primer_apellido) ?></td>
                    <td class="text-start">
                        <div class="copy-container">
                            <span class="copyText"><?= htmlspecialchars($historial->medico_documento) ?></span>
                            <button class="bg-transparent copyButton">
                                <i style="color: var(--texto);" class="bi bi-copy fs-6"></i>
                            </button>
                        </div>
                    </td>
                    <td><?= htmlspecialchars($historial->motivo_consulta) ?></td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton<?= htmlspecialchars($historial->id_historial) ?>">
                                <i class="bi bi-three-dots-vertical fs-6"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <button data-id="<?= htmlspecialchars($historial->id_historial) ?>" class="dropdown-item showDetails" type="button" title="Editar">
                                        Ver historia médica
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item deleteDetails" data-id="<?= htmlspecialchars($historial->id_historial) ?>" type="button" title="Eliminar">
                                        Eliminar historia médica
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div id="offcanvasHistorial" style="z-index: 9999;" class="off">
    <div class="d-flex justify-content-between align-items-center py-3">
        <h5 class="title-module">Detalles de la Historia Médica</h5>
        <button id="closeOffCanvas" type="button" class="btn-close text-reset" aria-label="Close"></button>
    </div>

    <div class="d-none content-loader position-absolute start-50 top-50 translate-middle-x translate-middle-y z-3">
        <span class="loader-button"></span>
    </div>

    <div id="contentHistorial" class="content-historial">

    </div>
</div>