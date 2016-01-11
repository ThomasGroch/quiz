<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "questions";
$route['404_override'] = '';

$route['questions'] = "questions/index";
$route['questions/create'] = "questions/create";

// $modules_path = APPPATH . 'modules/';
//
// foreach (scandir($modules_path) as $module) {
//     if ($module != '.' && $module != '..' && $module != '.svn' && substr($module,0,1) != '#' && $module != 'welcome' && is_dir($modules_path . $module)) {
//         foreach (scandir($modules_path . $module . '/controllers/') as $controller) {
//             if (!is_dir($modules_path . $module . '/controllers/' . $controller)) {
//                 $controller = substr($controller, 0, -4);
//                 if($controller == 'home'){
//                     $route[$controller] = $route['default_controller'];
//                     $route[$controller . '/(:any)'] = $route['default_controller'] . "/$1";
//                     $route[$controller . '/(:any)/(:any)'] = $route['default_controller'] . "/$1/$2";
//                     $route[$controller . '/(:any)/(:any)/(:any)'] = $route['default_controller'] . "/$1/$2/$3";
//                 }else{
//                     $route[$controller] = $module . "/" . $controller;
//                     $route[$controller . '/(:any)'] = $module . "/" . $controller . "/$1";
//                     $route[$controller . '/(:any)/(:any)'] = $module . "/$1/$2";
//                     $route[$controller . '/(:any)/(:any)/(:any)'] = $module . "/$1/$2/$3";
//                 }
//             }
//         }
//     }
// }

/* End of file routes.php */
/* Location: ./application/config/routes.php */
