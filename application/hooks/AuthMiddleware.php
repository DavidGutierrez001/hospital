<?php
// function check_auth()
// {
//     $CI = &get_instance();

//     $publicos = [
//         'homecontroller' => ['index'],
//         'authcontroller' => ['login', 'login_view', 'logout'],
//         'registercontroller' => ['register', 'register_view'],
//         'emailvalidationcontroller' => ['verify_email'],
//     ];

//     $controlador_actual = strtolower($CI->router->fetch_class());
//     $metodo_actual = strtolower($CI->router->fetch_method());

//     if (isset($publicos[$controlador_actual])) {
//         if (in_array($metodo_actual, $publicos[$controlador_actual])) {
//             return;
//         }
//     }

//     if (!$CI->session->userdata('id_usuario')) {
//         redirect('login');
//     }
// }
