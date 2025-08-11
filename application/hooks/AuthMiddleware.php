<?php
function check_auth()
{
    $CI = &get_instance();

    $publicos = [
        'indexcontroller' => ['index'],
        'logincontroller' => ['login', 'login_view'],
        'registercontroller' => ['register_view', 'register', 'verify_email'],
        'emailvalidationcontroller' => ['verify_email'],
        'authcontroller' => ['logout'],
    ];


    $controlador_actual = strtolower($CI->router->fetch_class());
    $metodo_actual = strtolower($CI->router->fetch_method());

    if (isset($publicos[$controlador_actual])) {
        if (in_array($metodo_actual, $publicos[$controlador_actual])) {
            return;
        }
    }

    if (!$CI->session->userdata('id_usuario')) {
        redirect('/');
    }
}
