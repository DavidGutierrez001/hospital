<div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Medicamentos</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Recetas</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
            <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled" aria-selected="false" disabled>Disabled</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active mt-3" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
            <div class="d-flex flex-column w-100">
                <section>
                    <div class="target p-3 rounded-3 d-flex justify-content-between align-items-center">
                        <div style="background-color:rgba(0, 0, 0, 0.09);" class="d-flex flex-column justify-content-between align-items-center text-white gap-2 p-3 rounded-3">
                            <h6 class="text-white fw-light">Medicamentos</h6>
                            <count-up class="fw-semibold fs-1"><?php echo count($medicamentos) ?></count-up>
                        </div>
                        <button class="btnAdd d-flex gap-2 px-3 py-2 text-white align-items-center" data-bs-toggle="modal" data-bs-target="#addMedicamento">
                            <i class="bi bi-plus-circle-fill fs-5"></i>
                            <span class="text-white">Nuevo Medicamento</span>
                        </button>

                        <div class="modal fade" id="addMedicamento" tabindex="-1" aria-labelledby="modalMedicamento">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="title-module" id="exampleModalLabel">Agregar Medicamento</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>

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
            <div class="main-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>NOMBRE PRODUCTO</th>
                            <th>DESCRIPCIÓN</th>
                            <th class="text-start">RECETA ESPECIAL</th>
                            <th>ACTIVO</th>
                            <th>FECHA REGISTRO</th>
                            <th class="text-start">EXISTENCIAS</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medicamentos as $medicamento) : ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($medicamento->id_medicamento) ?></td>
                                <td><?= htmlspecialchars($medicamento->nombre_comercial) ?></td>
                                <td><?= htmlspecialchars($medicamento->descripcion) ?></td>
                                <td class="text-start">
                                    <div>
                                        <span><?= htmlspecialchars($medicamento->receta_especial ? 'Si' : 'No') ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <span class="d-flex badge fw-normal fs-8 <?= htmlspecialchars($medicamento->activo == '1' ? 'bg-success' : 'bg-danger') ?>">
                                            <?= htmlspecialchars($medicamento->activo == '1' ? 'Stock' : 'Sin Stock') ?>
                                        </span>
                                    </div>
                                </td>
                                <td><?= date('d-m-Y', strtotime($medicamento->fecha_registro)) ?></td>
                                <td class="text-start"><?= htmlspecialchars($medicamento->existencias == 0 ? 'Sin existencias' : $medicamento->existencias . ' Unidades') ?>
                                </td>
                                <td>
                                    <button class="bg-transparent">
                                        <i class="bi bi-pencil-square fs-6"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>


        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
            <h1>Profile Content</h1>
        </div>
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">...</div>
        <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...</div>
    </div>

</div>