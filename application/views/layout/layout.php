<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo isset($title) ? $title : 'Sin nombre'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/global.css') ?>">

    <?php if (isset($css)) : ?>
        <?php foreach ($css as $style) : ?>
            <link rel="stylesheet" href="<?php echo base_url($style); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>
    <?php echo isset($content) ? $content : ''; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($js)) : ?>
        <?php foreach ($js as $script) : ?>
            <script src="<?php echo base_url($script); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '<?= $this->session->flashdata('success') ?>',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '<?= $this->session->flashdata('error') ?>',
                confirmButtonText: 'Cerrar'
            });
        </script>
    <?php endif; ?>
</body>

</html>