<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
//$route['module_name'] = 'admin';
$route['default_controller'] = "index";
$route['404_override'] = 'index/pageNotFound';

$route['home'] = 'index/index';
$route['company/(:any)'] = 'staticpage/index/$1';
$route['contact-us'] = 'staticpage/contact';
$route['facebook-login'] = 'index/loginwithfacebook';
$route['login'] = 'index/login';
$route['logout'] = 'index/logout';
$route['register'] = 'index/register';
$route['forgot-password'] = 'index/forgotPassword';
$route['change-password'] = 'user/changePassword';
$route['activate'] = 'index/activate';
$route['my-account'] = 'user/myAccount';

$route['trip/post/add'] = 'trip/add_new';
$route['trip/post/edit/(:num)/(:any)'] = 'trip/add_new/$1/$2';
$route['my-trips/(:any)'] = 'trip/my_posts/$1';
$route['trip/view/(:any)'] = 'trip/trip_details/$1';
$route['trip/delete/(:any)'] = 'trip/delete_trip/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */