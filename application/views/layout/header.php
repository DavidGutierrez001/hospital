<!DOCTYPE html>
<html lang="es">

<head>
    <title>Royal Care</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#eaf8ff">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/header.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/home.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/footer.css') ?>">
</head>

<body>
    <header class="position-sticky top-0 top-in z-3 w-100 d-flex bg-white align-items-center justify-content-between shadow-sm">
        <img class="logo" style="height: 35px;" src="<?php echo base_url('assets/img/logo.svg') ?>" alt="">
        <nav>
            <ul id="navbar" class="nav fw-medium d-flex">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sobre nosotros</a>
                </li>
                <li style="height: 50px;" class="nav-item d-flex align-items-center">
                    <a class="border-0 btn-login text-white rounded-4 px-4 py-2" href="#">Empieza</a>
                </li>
            </ul>
        </nav>
        <button id="btnMenu" class="border-0 fs-1 text-black bg-transparent">
            <i class="bi bi-list"></i>
        </button>
    </header>
    <main>