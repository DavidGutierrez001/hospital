<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'IndexController/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Login
$route['login'] = 'auth/LoginController/login_view';
$route['login_user'] = 'auth/LoginController/login';

// Registro
$route['register'] = 'auth/RegisterController/register_view';
$route['register_user'] = 'auth/RegisterController/register';
$route['verify_email'] = 'auth/RegisterController/verify_email';

$route['logout'] = 'AuthController/logout';

// Dashboard
$route['dashboard'] = 'DashboardController/index';
$route['dashboard/logout'] = 'DashboardController/logout';

// Módulos
$route['dashboard/home'] = 'modulos/HomeController/index';
$route['dashboard/pacientes'] = 'modulos/PacientesController/index';
$route['dashboard/medicos'] = 'modulos/MedicosController/index';
$route['dashboard/citas'] = 'modulos/CitasController/index';

$route['pacientes/view_editar/(:num)'] = 'modulos/PacientesController/view_editar/$1';
$route['pacientes/update/(:num)'] = 'modulos/PacientesController/update/$1';
$route['pacientes/create'] = 'modulos/PacientesController/create';
$route['pacientes/delete/(:num)'] = 'modulos/PacientesController/delete/$1';

$route['medicos/create'] = 'modulos/MedicosController/create';
$route['medicos/view_editar/(:num)'] = 'modulos/MedicosController/view_editar/$1';
$route['medicos/update/(:num)'] = 'modulos/MedicosController/update/$1';
$route['medicos/delete/(:num)'] = 'modulos/MedicosController/delete/$1';

$route['citas/medicos_disponibles'] = 'modulos/CitasController/verify_available_citas';
$route['citas/verify_available_citas'] = 'modulos/CitasController/verify_available_citas';
$route['citas/create_cita'] = 'modulos/CitasController/create_cita';
$route['citas/cancel_cita/(:num)'] = 'modulos/CitasController/cancel_cita/$1';
$route['citas/get_next_citas_json'] = 'modulos/CitasController/get_next_citas_json';
