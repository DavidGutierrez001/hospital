<div>
    <section style="border-radius: var(--border);" class="d-flex justify-content-between align-items-center pb-3">
        <h6 class="title-module fs-5">Reporte de citas médicas</h6>
        <div class="d-flex gap-3 align-items-center">
            <section class="dropdown dropdown-center">
                <button class="d-flex justify-content-between align-items-center gap-3 py-2 px-3 btnAdd text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-download"></i>
                    Exportar reporte
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#exportarPorDiaModal">Por día</button>
                    </li>
                </ul>
                <div class="modal fade" id="exportarPorDiaModal" tabindex="-1" aria-labelledby="exportarPorDiaLabel">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title title-module" id="exportarPorDiaLabel">Generar reporte</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <form id="formExport" action="/hospital/reportes/export_citas" method="GET">
                                <div class="modal-body">
                                    <section class="mb-3">
                                        <label for="fecha_exportar" class="form-label">Seleccione la fecha</label>
                                        <input type="date" class="form-control" id="fecha_exportar" name="fecha_exportar" value="<?= date('Y-m-d') ?>" required>
                                    </section>
                                    <section class="form-check form-switch">
                                        <input class="form-check-input switchForMedico" type="checkbox" role="switch" id="switchForMedico">
                                        <label class="form-check-label" for="switchForMedico">Exportar por médico</label>
                                    </section>
                                    <section id="medico_exportar_container">
                                        <div class="medico_exportar_span"></div>
                                    </section>
                                </div>
                                <div class="modal-footer">
                                    <button style="height: 2.5rem;" id="btnExport" type="submit" class="btn-green px-3 py-2 text-white">Exportar PDF
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

    <div class="main-content">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>PACIENTE</th>
                    <th>MEDICO</th>
                    <th>FECHA</th>
                    <th>HORA</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportes_citas as $cita): ?>
                    <tr>
                        <td>
                            <div class="d-flex flex-column">
                                <span><?= htmlspecialchars($cita->paciente_primer_nombre) . ' ' . htmlspecialchars($cita->paciente_primer_apellido) ?></span>
                                <span><?= htmlspecialchars($cita->paciente_documento) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span><?= htmlspecialchars($cita->medico_primer_nombre) . ' ' . htmlspecialchars($cita->medico_primer_apellido) ?></span>
                                <span><?= htmlspecialchars($cita->medico_documento) ?></span>
                            </div>
                        </td>
                        <td><?= date('d-m-Y', strtotime($cita->fecha_cita)); ?></td>
                        <td>
                            <div class="d-flex flex-column">
                                <span><?= date('h:i A', strtotime($cita->hora_inicio)); ?> - <?= date('h:i A', strtotime($cita->hora_fin)); ?></span>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($cita->estado_cita); ?></td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>

</div>