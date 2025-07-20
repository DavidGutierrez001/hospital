<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel de control del hospital para la gestión eficiente de pacientes, notificaciones y administración de usuarios.">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Sin título' ?></title>

    <link rel="icon" href="<?= base_url('/assets/img/logo2.svg') ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

    <?php if (isset($css)) : ?>
        <?php foreach ($css as $style) : ?>
            <link rel="stylesheet" href="<?= base_url($style) ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <script>
        const savedTheme = localStorage.getItem("theme") || "light";
        document.documentElement.setAttribute("data-theme", savedTheme);
    </script>
</head>

<body>
    <div id="sidebarOverlay" class="position-fixed top-0 start-0 w-100 min-vh-100 bg-dark bg-opacity-25 d-none"></div>

    <div class="d-flex dashboard-contain min-vh-100 vh-100">
        <aside id="sidebarContent" class="sidebar p-3 position-fixed" role="navigation" aria-label="Barra lateral">
            <img class="sidebar-logo" src="<?= base_url('/assets/img/logo6.svg') ?>" alt="Logo de la app">

            <nav class="sidebar-nav">
                <ul class="nav-list d-flex flex-column gap-1">
                    <h1 class="nav-category">MENÚ</h1>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard/home') ?>" class="nav-link-sidebar <?= current_url() == base_url('dashboard/home') ? 'selected-nav-link-sidebar' : '' ?>">
                            <i class="bi bi-grid-1x2-fill"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard/pacientes') ?>" class="nav-link-sidebar <?= current_url() == base_url('dashboard/pacientes') ? 'selected-nav-link-sidebar' : '' ?>">
                            <i class="bi bi-person-fill"></i> Pacientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard/medicos') ?>" class="nav-link-sidebar <?= current_url() == base_url('dashboard/medicos') ? 'selected-nav-link-sidebar' : '' ?>">
                            <i class="bi bi-person-badge-fill"></i> Médicos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard/citas') ?>" class="nav-link-sidebar <?= current_url() == base_url('dashboard/citas') ? 'selected-nav-link-sidebar' : '' ?>">
                            <i class="bi bi-calendar-week-fill"></i> Citas Médicas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard/historial') ?>" class="nav-link-sidebar <?= current_url() == base_url('dashboard/historial') ? 'selected-nav-link-sidebar' : '' ?>">
                            <i class="bi bi-clipboard2-fill"></i> Historial Médico
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard/farmacia') ?>" class="nav-link-sidebar <?= current_url() == base_url('dashboard/farmacia') ? 'selected-nav-link-sidebar' : '' ?>">
                            <i class="bi bi-capsule"></i> Farmacia
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard/reportes') ?>" class="nav-link-sidebar <?= current_url() == base_url('dashboard/reportes') ? 'selected-nav-link-sidebar' : '' ?>">
                            <i class="bi bi-bar-chart-fill"></i> Reportes
                        </a>
                    </li>
                </ul>
                <ul class="mt-auto">
                    <li class="nav-item">
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <button id="btnTheme" class="toggle-theme d-flex align-items-center" aria-label="Cambiar tema">
                                <i class="bi bi-moon-fill"></i>
                            </button>
                            <button id="btnLogout" class="logout-link d-flex align-items-center" aria-label="Cerrar sesión">
                                <i class="bi bi-power"></i>
                            </button>
                        </div>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="dashboard-main d-flex flex-column gap-3">
            <header class="dashboard-header">
                <div class="dashboard-header-nav d-flex align-items-center justify-content-end w-100 gap-3">
                    <button id="sidebarBtn" class="dashboard-header-nav-btn hamburger-btn position-relative" aria-label="Abrir menú lateral">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div class="d-flex align-items-center gap-3">
                        <button class="dashboard-header-nav-btn position-relative" aria-label="Mensajes">
                            <i class="bi bi-envelope fs-5"></i>
                            <span class="badge-noti position-absolute bg-danger rounded-circle"></span>
                        </button>
                        <button class="dashboard-header-nav-btn position-relative" aria-label="Notificaciones">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="badge-noti position-absolute bg-danger rounded-circle"></span>
                        </button>
                        <div class="divider"></div>
                        <div class="profile d-flex align-items-center justify-content-center gap-2">
                            <div class="img-profile rounded-circle"></div>
                            <div class="d-flex flex-column">
                                <span class="profile-name fw-medium"><?= isset($this->session->userdata['primer_nombre']) ? htmlspecialchars($this->session->userdata['primer_nombre']) : 'Usuario' ?></span>
                                <span style="font-size: 0.8rem;" class="opacity-50">
                                    <?php
                                    switch ($this->session->userdata['id_rol'] ?? '') {
                                        case '1':
                                            echo 'Paciente';
                                            break;
                                        case '2':
                                            echo 'Médico';
                                            break;
                                        case '3':
                                            echo 'Recepcionista';
                                            break;
                                        case '4':
                                            echo 'Farmacéutico';
                                            break;
                                        case '5':
                                            echo 'Admin';
                                            break;
                                        default:
                                            echo 'Usuario';
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="dashboard-content p-3 rounded-4">
                <section id="dashboardContent">
                    <?php if (isset($vista)) $this->load->view($vista); ?>
                </section>
            </div>
        </main>
    </div>

    <!-- Librerías JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/gh/lekoala/formidable-elements@master/dist/count-up.min.js"></script>
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <!-- AutoAnimate -->
    <script type="module">
        import autoAnimate from 'https://cdn.jsdelivr.net/npm/@formkit/auto-animate';
        const el = document.querySelector('.modal-content');
        if (el) {
            autoAnimate(el, {
                duration: 300,
                easing: 'ease-in-out'
            });
        }
    </script>

    <?php if (isset($library)) : ?>
        <?php foreach ($library as $lib) : ?>
            <script src="<?= $lib ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($js)) : ?>
        <?php foreach ($js as $script) : ?>
            <script src="<?= base_url($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Alertas SweetAlert2 -->
    <?php if ($this->session->flashdata('success')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '<?= $this->session->flashdata('success') ?>',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '<?= $this->session->flashdata('error') ?>',
                confirmButtonText: 'Cerrar'
            });
        </script>
    <?php endif; ?>

    <!-- Inicializar DataTables -->
    <script>
        new DataTable(".table", {
            responsive: true,
            paging: false,
            language: {
                info: "Mostrando _START_ de _END_",
                infoEmpty: "Mostrando 0 de 0 entradas",
                infoFiltered: "(filtrado de _MAX_ entradas totales)",
                lengthMenu: "Mostrar _MENU_ entradas",
                search: "Buscar:",
                zeroRecords: "No se encontraron registros coincidentes",
            },
            order: [[0, "desc"]],
        });
    </script>
</body>

</html>
