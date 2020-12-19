<?php
use Respect\Validation\Validator as v;

// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------
//Authentication
$container['auth'] = function ($container){
    return new App\Auth\Auth($container->get('em'),$container->get('settings')['admin']);
};

// Flash messages
$container['flash'] = function ($container) {
    return new Slim\Flash\Messages;
};
$container['valuer_service']= function ($container){
    return new \App\Service\valuerService($container->get('em'));
};
$container['staff_service']= function ($container){
    return new \App\Service\staffService($container->get('em'));
};
$container['home_service']= function ($container){
  return new \App\Service\HomeService($container->get('em'));
};
$container['admin_service']= function ($container){
    return new \App\Service\AdminService($container->get('em'));
};
$container['password_service']= function ($container){
    return new \App\Service\PasswordService($container->get('em'));
};

// Validation
$container['validator'] = function ($container) {
   return new App\Validation\Validator;
};

//Csrf

$container['csrf'] = function ($c) {
    return new Slim\Csrf\Guard;

};

//excel

$container['excel'] = function ($container) {

return new SpreadsheetReader;
};

$container['xls'] = function ($container) {

    return new Spreadsheet_Excel_Reader;
};




// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------
// Twig
$container['view'] = function ($container) {
    $settings = $container->get('settings');
    $view = new Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);
    $view->getEnvironment()->addGlobal('session', $_SESSION);
    $view->getEnvironment()->addGlobal('auth',[
        'check'=>$container->auth->check(),
        'user'=>$container->auth->user(),
    ]);
    $view->getEnvironment()->addGlobal('flash',$container->get('flash'));

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $container->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};
// monolog
$container['logger'] = function ($container) {
    $settings = $container->get('settings');
    $logger = new Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'], Monolog\Logger::DEBUG));
    return $logger;
};
$container['em']=function ($container){
    $settings= $container->get('settings');
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['doctrine']['meta']['auto_generate_proxies'],
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache'],
        false
    );
    return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'],$config);
};


// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------
$container[App\Action\ValuerAction::class] = function ($container) {
    return new App\Action\ValuerAction($container->get('view'), $container->get('logger'),$container->get('valuer_service'),  $container->get('em'),$container->get('flash'));
};
$container[App\Action\staffAction::class] = function ($container) {
    return new App\Action\staffAction($container->get('view'), $container->get('logger'),$container->get('staff_service'),  $container->get('em'),$container->get('flash'));
};


$container[App\Action\HomeAction::class] = function ($container) {
    return new App\Action\HomeAction($container->get('view'), $container->get('logger'),$container->get('home_service'),  $container->get('em'),$container->get('flash'));
};
$container[App\Action\AdminAction::class] = function ($container) {

    return new App\Action\AdminAction($container->get('view'), $container->get('logger'),$container->get('admin_service'),  $container->get('settings')['admin']);
};
/*$container[App\Action\AuthenticationAction::class] = function ($container) {

    return new App\Action\AuthenticationAction($container->get('view'), $container->get('logger'),$container->get('password_service'),$container->get('crsf'));
};*/
$container[App\Action\PasswordAction::class] = function ($container) {

    return new App\Action\PasswordAction($container->get('view'), $container->get('logger'),$container->get('password_service'),$container->get('settings')['admin']);
};


$app->add( new App\Middleware\ValidationErrorsMiddleware($container));
$app->add( new App\Middleware\OldInputMiddleware($container));
//$app->add( new App\Middleware\CsrfViewMiddleware($container));
//$app->add($container->get('csrf'));

//v::with('\\App\\Validation\\Rules\\');