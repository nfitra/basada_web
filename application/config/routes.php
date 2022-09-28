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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//api-route
$route['api/login']['post'] = 'mobile/Auth/login';
$route['api/signup']['post'] = 'mobile/Auth/signup';

$route['api/artikel']['get'] = 'mobile/Artikel/get_all_artikel';
$route['api/jadwal']['get'] = 'mobile/Jadwal/get_jadwal';

$route['api/request']['post'] = 'mobile/RequestSampah/request';
$route['api/request/nasabah']['get'] = 'mobile/RequestSampah/get_request_by_nasabah';
$route['api/request/admin']['get'] = 'mobile/RequestSampah/get_request_by_current_admin';
$route['api/request/(:any)']['get'] = 'mobile/RequestSampah/get_detail_request/$1';
$route['api/request/(:any)']['put'] = 'mobile/RequestSampah/update/$1';
$route['api/request-by-admin/(:any)']['get'] = 'mobile/RequestSampah/get_request_by_admin/$1';
$route['api/request-by-admin-jadwal/(:any)/(:any)']['get'] = 'mobile/RequestSampah/get_request_by_admin_jadwal/$1/$2';
$route['api/request/admin/jadwal/(:any)']['get'] = 'mobile/RequestSampah/get_request_by_current_admin_jadwal/$1';

$route['api/admin']['get'] = 'mobile/RequestSampah/get_admin';
$route['api/admin/profile']['get'] = 'mobile/Admin/profile';
$route['api/sampah']['get'] = 'mobile/Sampah/get_sampah';
$route['api/kategori-sampah']['get'] = 'mobile/Sampah/get_kategori';
$route['api/sampah-by-kategori/(:any)']['get'] = 'mobile/Sampah/get_sampah_by_kategori';

$route['api/device']['post'] = 'mobile/Device/add';
$route['api/device/(:num)']['delete'] = 'mobile/Device/delete/$1';

$route['api/nasabah']['put'] = 'mobile/Nasabah/update_nasabah';
$route['api/nasabah/profile']['get'] = 'mobile/Nasabah/get_nasabah';
$route['api/nasabah/saldo']['get'] = 'mobile/Nasabah/get_saldo';