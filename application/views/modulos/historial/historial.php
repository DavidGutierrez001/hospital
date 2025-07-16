<div class="target d-flex justify-content-end w-100 align-items-center rounded-3 p-3">
    <div class="d-flex gap-3">
        <button class="btnAdd d-flex gap-2 px-3 py-2 shadow text-white align-items-center" data-bs-toggle="modal" data-bs-target="#addHistorial">
            <i class="bi bi-search fs-5"></i>
            <span class="text-white">Consultar</span>
        </button>
        <span style="border: 1px solid; color: white;"></span>
        <button class="btnAdd d-flex gap-2 px-3 py-2 shadow text-white align-items-center" data-bs-toggle="modal" data-bs-target="#addHistorial">
            <i class="bi bi-plus-circle-fill fs-5"></i>
            <span class="text-white">Nueva Historia</span>
        </button>
    </div>
</div>

<div class="main-content">
    <table class="table">
        <thead>
            <th class="text-center">#</th>
            <th>PACIENTE</th>
            <th class="text-start">DOCUMENTO</th>
            <th>MOTIVO</th>
            <th>FECHA</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php foreach ($historiales as $historial) { ?>
                <tr>
                    <td class="text-center"><?= htmlspecialchars($historial->id_historial) ?></td>
                    <td>
                        <?= htmlspecialchars($historial->paciente_primer_nombre) . ' ' . htmlspecialchars($historial->paciente_primer_apellido) ?>
                    </td>
                    <td class="text-start">
                        <div class="copy-container">
                            <span class="copyText"><?= htmlspecialchars($historial->documento) ?></span>
                            <button class="bg-transparent copyButton">
                                <i style="color: var(--texto);" class="bi bi-copy fs-6"></i>
                            </button>
                        </div>
                    </td>
                    <td><?= htmlspecialchars($historial->motivo_consulta) ?></td>
                    <td><?= date('d-m-Y', strtotime($historial->fecha_creacion)) ?></td>
                    <td>
                        <button class="showDetails bg-transparent" data-id="<?= htmlspecialchars($historial->id_paciente) ?>">
                            <i style="color: var(--texto);" class="bi bi-stopwatch-fill fs-6"></i>
                        </button>
                    </td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div id="offcanvasHistorial" class="off shadow">
    <div class="d-flex justify-content-between align-items-center py-3">
        <h5 class="title-module">Detalles del Historial Médico</h5>
        <button id="closeOffCanvas" type="button" class="btn-close text-reset" aria-label="Close"></button>
    </div>
    <div class="d-none content-loader position-absolute start-50 top-50 translate-middle-x translate-middle-y z-3">
        <span class="loader-button"></span>
    </div>
    <div id="contentHistorial" class="content-historial">

    </div>
</div>