<?php
function verificar_permiso()
{
    $CI = &get_instance();
    $CI->load->model('Permisos_model');

    $rol_id = $CI->session->userdata('id_rol');
    $modulo = $CI->router->fetch_class();

    if (!$CI->Permisos_model->tiene_acceso($rol_id, $modulo)) {
        show_error('Acceso denegado', 403);
    }
}
