<ul class="nav nav-tabs" id="reportesTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="citas-tab" data-bs-toggle="tab" href="#citas" role="tab">Citas Médicas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pacientes-tab" data-bs-toggle="tab" href="#pacientes" role="tab">Pacientes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="ventas-tab" data-bs-toggle="tab" href="#ventas" role="tab">Ventas de Farmacia</a>
    </li>
</ul>

<div class="tab-content mt-3" id="reportesTabsContent">
    <div class="tab-pane fade show active" id="citas" role="tabpanel">
        <?php $this->load->view('modulos/reportes/reporte_citas'); ?>
    </div>
    <div class="tab-pane fade" id="pacientes" role="tabpanel">
        <?php $this->load->view('modulos/reportes/reporte_pacientes'); ?>
    </div>
    <div class="tab-pane fade" id="ventas" role="tabpanel">
        <?php $this->load->view('modulos/reportes/reporte_ventas'); ?>
    </div>
</div>