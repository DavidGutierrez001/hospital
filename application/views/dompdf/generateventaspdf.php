<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reporte de Citas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif !important;
            margin: 20px;
        }

        img {
            height: 2rem;
        }

        .contain-table {
            margin-top: 4rem;
        }

        .contain-table .count-citas {
            text-align: right;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
            display: table;
        }

        th,
        td {
            border: #c2d8c3ff solid 1px;
            text-align: center;
        }

        th {
            color: #42a947ff;
        }

        thead th {
            background-color: #f9fff9ff;
            color: #2a682dff;
        }
    </style>
</head>

<body>
    <div style="position: relative;">
        <img src="<?php echo base_url('assets/img/jpg/logo6.jpg'); ?>" alt="">
        <div class="text-center">
            <span style="font-size: 1.1rem; font-weight: normal" class="text-start">Reporte de ventas del mes</span><br>
            <span style="font-size: .9rem;">Generado el <span style="text-decoration: underline;"><?= date('d-m-Y') ?></span></span>
            <span style="font-size: .9rem;">a las <span style="text-decoration: underline;"><?= date('h:i A') ?></span></span>
        </div>
        <div class="contain-table">
            <div class="count-citas">
                <span style="font-size: .9rem;">Ventas encontradas: <?= count($reportes_ventas) ?></span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>CLIENTE</th>
                        <th>DOCUMENTO</th>
                        <th>PRODUCTO</th>
                        <th>FECHA VENTA</th>
                        <th>TOTAL VENTA</th>
                        <th>ESTADO VENTA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reportes_ventas as $ventas): ?>
                        <tr>
                            <td>
                                <div>
                                    <span><?= htmlspecialchars($ventas->primer_nombre) . ' ' . htmlspecialchars($ventas->primer_apellido) ?></span><br>
                                </div>
                            </td>
                            <td>
                                <span><?= htmlspecialchars($ventas->documento) ?></span>
                            </td>
                            <td>
                                <div>
                                    <span><?= htmlspecialchars($ventas->nombre_comercial) ?></span>
                                </div>
                            </td>
                            <td><?= date('d-m-Y', strtotime($ventas->fecha_venta)); ?></td>
                            <td>
                                <div>
                                    <span><?= htmlspecialchars($ventas->total_venta); ?></span>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($ventas->estado_venta); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
    <br>
    <br>
    <br>
    <div style="text-align: right;">
        <hr style="border-bottom: 1px black solid; max-width: 300px; margin-right: 0;" />
        <span style="font-size: .9rem;">Firma del responsable</span>
    </div>
</body>

</html>