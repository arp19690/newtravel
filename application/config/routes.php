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
$route['static/(:any)'] = 'staticpage/index/$1';
$route['contact-us'] = 'staticpage/contact';
$route['facebook-login'] = 'index/login_with_facebook';
$route['facebook-auth'] = 'index/facebookAuth';
$route['facebook-connect'] = 'index/facebookConnect';
$route['login'] = 'index/login';
$route['logout'] = 'index/logout';
$route['register'] = 'index/register';
$route['forgot-password'] = 'index/forgotPassword';
$route['change-password'] = 'user/changePassword';
$route['activate'] = 'index/activate';
$route['my-account'] = 'user/myAccount';
$route['r'] = 'index/external_redirect';

$route['trip/post/add'] = 'trip/add_new';
$route['trip/post/edit/(:num)/(:any)'] = 'trip/add_new/$1/$2';
$route['my-trips/(:any)'] = 'trip/my_posts/$1';
$route['joined-trips/(:any)'] = 'trip/trips_joined_by_me/$1';
$route['my-wishlist/(:any)'] = 'trip/my_wishlist/$1';
$route['trip/view/(:any)'] = 'trip/trip_details/$1';
$route['trip/delete/(:any)'] = 'trip/delete_trip/$1';
$route['trip/search/query'] = 'trip/search_query';
$route['trip/all-trips'] = 'trip/all_posts';
$route['trip/show-interest/(:any)'] = 'trip/show_interest/$1';
$route['trip/post-review/(:any)'] = 'trip/store_review/$1';

$route['trip/get-featured'] = 'payments/payment_for_featured_post';
$route['trip/paypal-cancel'] = 'payments/paypal_cancel';
$route['trip/paypal-success'] = 'payments/paypal_success';

$route['my-chats'] = 'messages/index';
$route['user/(:any)'] = 'user/public_profile/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */