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
$route['default_controller']                                = 'Landingpage';
$route['encrypt']                                           = 'Landingpage/encrypt';
$route['404_override']                                      = '';
$route['translate_uri_dashes']                              = FALSE;
$route['assets/(:any)']                                     = 'assets/$1';

// auth
$route['login']                                             = 'dashboard/Authentication/login';
$route['forgot-password']                                   = 'dashboard/Authentication/forgotPassword';
$route['forgot-password/(:any)']                            = 'dashboard/Authentication/resetPassword/$1';

// public side
$route['arsip']                                             = 'public/Arsip/index';
$route['arsip/(:num)']                                      = 'public/Arsip/show/$1';
$route['artikel']                                           = 'public/Artikel/index';
$route['artikel/(:num)']                                    = 'public/Artikel/show/$1';
$route['aduan']                                             = 'public/aduan/show';

// ===== admin =====
// dashboard
$route['dashboard']                                         = 'dashboard/Dashboard/index';
// aduan
$route['dashboard/aduan']                                   = 'dashboard/aduan/index';
$route['dashboard/aduan/detail/(:num)']                     = 'dashboard/aduan/detail/$1';
// arsip
$route['dashboard/arsip']                                   = 'dashboard/Arsip/index';
$route['dashboard/arsip/baru']                              = 'dashboard/Arsip/create';
$route['dashboard/arsip/detail/(:num)']                     = 'dashboard/Arsip/detail/$1';
// kode klasifikasi
$route['dashboard/kode-klasifikasi']                        = 'dashboard/Klasifikasi/index';
$route['dashboard/kode-klasifikasi/detail/(:num)']          = 'dashboard/Klasifikasi/detail/$1';
// pengelola
$route['dashboard/pengelola']                               = 'dashboard/Admin/index';
$route['dashboard/pengelola/detail/(:num)']                 = 'dashboard/Admin/detail/$1';
// profile
$route['dashboard/profile']                                 = 'dashboard/Profile/index';

// ===== admin api =====
// auth
$route['api/signin']                                        = 'dashboard/Authentication/API_signin';
$route['api/user']                                          = 'dashboard/Authentication/API_user';
$route['api/logout']                                        = 'dashboard/Authentication/API_logout';
$route['api/forgot-password']                               = 'dashboard/Authentication/API_forgotPassword';
$route['api/reset-password']                                = 'dashboard/Authentication/API_resetPassword';
// admin
$route['api/dashboard/admin']                               = 'dashboard/Admin/API_index';
$route['api/dashboard/admin/baru']                          = 'dashboard/Admin/API_create';
$route['api/dashboard/admin/(:num)']                        = 'dashboard/Admin/API_detail/$1';
$route['api/dashboard/admin/(:num)/aktif']                  = 'dashboard/Admin/API_aktif/$1';
$route['api/dashboard/admin/(:num)/nonaktif']               = 'dashboard/Admin/API_nonaktif/$1';
$route['api/dashboard/admin/(:num)/otoritas']               = 'dashboard/Admin/API_updateOtoritas/$1';
// aduan
$route['api/dashboard/aduan']                               = 'dashboard/Aduan/API_index';
$route['api/dashboard/aduan/(:num)']                        = 'dashboard/Aduan/API_detail/$1';
$route['api/dashboard/aduan/(:num)/update']                 = 'dashboard/Aduan/API_update/$1';
// arsip
$route['api/dashboard/arsip']                               = 'dashboard/Arsip/API_index';
$route['api/dashboard/arsip/viewer-data']                   = 'dashboard/Arsip/API_historicalViewers';
$route['api/dashboard/arsip/chart-data']                    = 'dashboard/Arsip/API_chartData';
$route['api/dashboard/arsip/last5']                         = 'dashboard/Arsip/API_last5';
$route['api/dashboard/arsip/top5']                          = 'dashboard/Arsip/API_top5';
$route['api/dashboard/arsip/(:num)']                        = 'dashboard/Arsip/API_detail/$1';
$route['api/dashboard/arsip/(:num)/delete']                 = 'dashboard/Arsip/API_destroy/$1';
$route['api/dashboard/arsip/(:num)/draft']                  = 'dashboard/Arsip/API_draft/$1';
$route['api/dashboard/arsip/(:num)/publikasi']              = 'dashboard/Arsip/API_publish/$1';
$route['api/dashboard/arsip/(:num)/restore']                = 'dashboard/Arsip/API_restore/$1';
$route['api/dashboard/arsip/(:num)/update']                 = 'dashboard/Arsip/API_update/$1';
$route['api/dashboard/arsip/(:num)/viewer-data']            = 'dashboard/Arsip/API_arsipHistoricalViewers/$1';
$route['api/dashboard/arsip/(:num)/lampiran']               = 'dashboard/Arsip/API_storeLampiran/$1';
$route['api/dashboard/arsip/(:num)/lampiran/(:num)/hapus']  = 'dashboard/Arsip/API_destroyLampiran/$1/$2';
// klasifikasi
$route['api/dashboard/klasifikasi']                         = 'dashboard/Klasifikasi/API_index';
$route['api/dashboard/klasifikasi/(:num)']                  = 'dashboard/Klasifikasi/API_detail/$1';
$route['api/dashboard/klasifikasi/(:num)/update']           = 'dashboard/Klasifikasi/API_update/$1';
$route['api/dashboard/klasifikasi/page/(:num)']             = 'dashboard/Klasifikasi/API_index/$1';
$route['api/dashboard/klasifikasi/baru']                    = 'dashboard/Klasifikasi/API_store';
$route['api/dashboard/klasifikasi/top5']                    = 'dashboard/Klasifikasi/API_top5';
$route['api/dashboard/klasifikasi/(:num)/arsip']            = 'dashboard/Klasifikasi/API_arsip/$1';
// profile
$route['api/dashboard/profile']                             = 'dashboard/Profile/API_index';
$route['api/dashboard/profile/update/name']                 = 'dashboard/Profile/API_update_name';
$route['api/dashboard/profile/update/password']             = 'dashboard/Profile/API_update_password';

// ===== public api =====
// arsip
$route['api/public/arsip']                                  = 'public/Arsip/API_index';
// aduan
$route['api/public/aduan/create']                           = 'public/Aduan/API_store';
$route['api/public/aduan/find']                             = 'public/Aduan/API_find';