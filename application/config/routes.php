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
$route['api/login']['post'] = 'api/Auth/login';
$route['api/signup']['post'] = 'api/Auth/signup';

$route['api/artikel']['get'] = 'api/Artikel/get_all_artikel';
$route['api/jadwal']['get'] = 'api/Jadwal/get_jadwal';

$route['api/request']['post'] = 'api/RequestSampah/request';
$route['api/request/done/(:any)']['put'] = 'api/RequestSampah/done/$1';
$route['api/request/confirm/(:any)']['put'] = 'api/RequestSampah/confirm/$1';
$route['api/request/reject/(:any)']['put'] = 'api/RequestSampah/reject/$1';
$route['api/request/test']['put'] = 'api/RequestSampah/test';
$route['api/request/testhttp']['put'] = 'api/RequestSampah/testHTTP';
$route['api/request/nasabah']['get'] = 'api/RequestSampah/get_request_by_nasabah';
$route['api/request/admin']['get'] = 'api/RequestSampah/get_request_by_current_admin';
$route['api/request/(:any)']['get'] = 'api/RequestSampah/get_detail_request/$1';
$route['api/request/(:any)']['put'] = 'api/RequestSampah/update/$1';
$route['api/request-by-admin/(:any)']['get'] = 'api/RequestSampah/get_request_by_admin/$1';
$route['api/request-by-admin-jadwal/(:any)/(:any)']['get'] = 'api/RequestSampah/get_request_by_admin_jadwal/$1/$2';
$route['api/request/admin/jadwal/(:any)']['get'] = 'api/RequestSampah/get_request_by_current_admin_jadwal/$1';

$route['api/admin']['get'] = 'api/RequestSampah/get_admin';
$route['api/unit']['get'] = 'api/RequestSampah/get_unit';
$route['api/unit/(:any)']['get'] = 'api/RequestSampah/get_unit_by_status/$1';
$route['api/admin']['put'] = 'api/Admin/update_admin';
$route['api/admin/profile']['get'] = 'api/Admin/profile';
$route['api/sampah']['get'] = 'api/Sampah/get_sampah';
$route['api/kategori-sampah']['get'] = 'api/Sampah/get_kategori';
$route['api/sampah-by-kategori/(:any)']['get'] = 'api/Sampah/get_sampah_by_kategori/$1';

$route['api/device']['post'] = 'api/Device/add';
$route['api/device/(:num)']['delete'] = 'api/Device/delete/$1';

$route['api/nasabah']['put'] = 'api/Nasabah/update_nasabah';
$route['api/nasabah/profile']['get'] = 'api/Nasabah/get_nasabah';
$route['api/nasabah/saldo']['get'] = 'api/Nasabah/get_saldo';

$route['api/artikel']['get'] = 'api/Artikel/get_all_artikel';
$route['api/artikel/(:any)']['get'] = 'api/Artikel/get_artikel_by_id/$1';

$route['api/change-password/nasabah']['put'] = 'api/Nasabah/change_password';
