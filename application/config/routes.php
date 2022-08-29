<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$route['default_controller'] = 'Landingpage';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['assets/(:any)'] = 'assets/$1';

// auth
$route['signin'] = 'admin/Auth/signin';

// public side
$route['arsip'] = 'public/Arsip/index';
$route['arsip/(:num)'] = 'public/Arsip/show/$1';
$route['artikel'] = 'public/Artikel/index';
$route['artikel/(:num)'] = 'public/Artikel/show/$1';

// admin side
$route['admin'] = 'admin/Dashboard/toIndex';
$route['admin/dashboard'] = 'admin/Dashboard/index';
$route['admin/arsip'] = 'admin/Arsip/index';
$route['admin/arsip/baru'] = 'admin/Arsip/create';
$route['admin/arsip/detail/(:num)'] = 'admin/Arsip/detail/$1';
$route['admin/kode-klasifikasi'] = 'admin/KodeKlasifikasi/index';
$route['admin/kode-klasifikasi/detail/(:num)'] = 'admin/KodeKlasifikasi/detail/$1';

$route['admin/pengelola'] = 'admin/Admin/index';
$route['admin/pengelola/detail/(:num)'] = 'admin/Admin/detail/$1';

$route['admin/lampiran-arsip/upload'] = 'admin/Arsip/do_upload';

// ===== api =====
// admin
$route['api/admin'] = 'api/admin/index';
$route['api/admin/(:num)'] = 'api/admin/show/$1';

// arsip
$route['api/arsip'] = 'api/arsip/index';
$route['api/arsip/chart-data'] = 'api/arsip/chartData';
$route['api/arsip/last5'] = 'api/arsip/last5';
$route['api/arsip/(:num)'] = 'api/arsip/show/$1';
$route['api/arsip/(:num)/hapus'] = 'api/arsip/destroy/$1';
$route['api/arsip/(:num)/draft'] = 'api/arsip/draft/$1';
$route['api/arsip/(:num)/publikasi'] = 'api/arsip/publish/$1';
$route['api/arsip/(:num)/update'] = 'api/arsip/update/$1';
$route['api/arsip/(:num)/lampiran'] = 'api/arsip/storeLampiran/$1';
$route['api/arsip/(:num)/lampiran/(:num)/hapus'] = 'api/arsip/destroyLampiran/$1/$2';
// klasifikasi
$route['api/klasifikasi'] = 'api/klasifikasi/index';
$route['api/klasifikasi/baru'] = 'api/klasifikasi/store';
$route['api/klasifikasi/top5'] = 'api/klasifikasi/top5';