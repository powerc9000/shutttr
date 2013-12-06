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
//-- required routes -----------------------//
$route['default_controller'] = 'welcome';
$route['404_override'] = 'misc/not_found';
//------------------------------------------//
$route['posts/page/(:num)'] = 'posts/index/$1';
$route['posts/photos/page/(:num)'] = 'posts/photos/$1';
$route['posts/questions/page/(:num)'] = 'posts/questions/$1';
$route['posts/critiques/page/(:num)'] = 'posts/critiques/$1';
$route['posts/following/page/(:num)'] = 'posts/following/$1';
$route['posts/links/page/(:num)'] = 'posts/links/$1';
$route['posts/tagged_with/(:any)/page/(:num)'] = 'posts/tagged_with/$1/$2';
$route['people/(:any)/photos'] = 'people/photos/$1';
$route['people/(:any)/posts'] = 'people/posts/$1';
$route['people/(:any)/posts/page/(:num)'] = 'people/posts/$1/$2';
$route['people/(:any)/critiques/page/(:num)'] = 'people/critiques/$1/$2';
$route['people/(:any)/comments/page/(:num)'] = 'people/comments/$1/$2';
$route['people/(:any)/comments'] = 'people/comments/$1';
$route['people/(:any)/critiques'] = 'people/critiques/$1';
$route['people/follow/(:any)'] = 'people/follow/$1';
$route['people/unfollow/(:any)'] = 'people/unfollow/$1';

$route['invite/(:any)'] = 'invite/index/$1';
$route['invite'] = 'invite/index';
$route['invite/email'] = 'invite/invite_email';
$route['people/page/(:num)'] = 'people/index/$1';
$route['register'] = 'login/register';
$route['logout'] = 'login/logout';
$route['forgot'] = 'login/forgot';
$route['register/now'] = 'login/register_now';
$route['activate/(:any)'] = 'login/activate/$1';
$route['reset/password/(:any)'] = 'login/reset/$1';
$route['reset/password'] = 'login/reset';
$route['people/(:any)'] = 'people/profile/$1';
$route['new/(:any)'] = 'create/$1';
$route['photo/(:any)'] = 'posts/photo/$1';
//for beta launch
$route['welcome/invited'] = 'login/invited';
//$route['photo/(:any)'] = 'photo/$1';
$route['guidelines'] = 'misc/guidelines';
$route['message/(:any)'] = 'messages/create/$1';
$route['posts/popular'] = 'posts/top_photos';
 
/* End of file routes.php */
/* Location: ./application/config/routes.php */
