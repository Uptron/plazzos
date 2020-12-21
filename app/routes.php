<?php
// Routes
//Login Page
use App\Middleware\ApiAuthenticationMiddleware;
use App\Middleware\AuthenticationMiddleware;

$app->get('/', App\Action\AuthenticationAction::class);

$app->get('/auth/login', 'App\Action\AuthenticationAction:getSignIn')
    ->setName('auth.login');
$app->post('/auth/login', 'App\Action\AuthenticationAction:postSignIn')
    ->setName('auth.post-login');;

$app->get('/auth/signup', 'App\Action\AuthenticationAction:getSignup')
    ->setName('auth.signup');
$app->post('/auth/signup', 'App\Action\AuthenticationAction:postSignup')
    ->setName('auth.post-signup');



$app->group('',function () use ($app){

    $app->get('/auth/password/change', 'App\Action\PasswordAction:getChangePassword')
        ->setName('auth.change-password');
    $app->post('/auth/password/change', 'App\Action\PasswordAction:postChangePassword')
        ->setName('auth.post-change-password');

    $app->get('/logout', 'App\Action\AuthenticationAction:logout')
        ->setName('auth.logout');

})->add(new AuthenticationMiddleware($container));

//Administration Routes
$app->group('/admin', function () use ($app) {
    $app->get('/', App\Action\AdminAction::class)->setName('admin.dashboard');
   //Valuers
    $app->get('/add-valuer', 'App\Action\AdminAction:newValuer')->setName('admin.add-valuer');
    $app->get('/manage-valuers', 'App\Action\AdminAction:fetchValuers')->setName('admin.manage-valuers');
    $app->post('/save-valuer', 'App\Action\AdminAction:saveValuer')->setName('admin.save-valuer');
    $app->post('/update-valuer', 'App\Action\AdminAction:saveValuer')->setName('admin.update-valuer');
//staff
    $app->get('/add-staff', 'App\Action\AdminAction:newstaff')->setName('admin.add-staff');
    $app->get('/manage-staff', 'App\Action\AdminAction:fetchstaff')->setName('admin.manage-staff');
    $app->post('/save-staff', 'App\Action\AdminAction:savestaff')->setName('admin.save-staff');
    $app->post('/update-staff', 'App\Action\AdminAction:savestaff')->setName('admin.update-staff');

    //Users
    $app->get('/add-user', 'App\Action\AdminAction:newuser')->setName('admin.add-user');
    $app->get('/manage-users', 'App\Action\AdminAction:fetchusers')->setName('admin.manage-users');
    $app->post('/save-user', 'App\Action\AdminAction:saveuser')->setName('admin.save-user');
    $app->post('/update-user', 'App\Action\AdminAction:saveuser')->setName('admin.update-user');
    $app->get('/add-group', 'App\Action\AdminAction:newgroup')->setName('admin.add-group');
    $app->get('/manage-groups', 'App\Action\AdminAction:fetchgroups')->setName('admin.manage-groups');
    $app->post('/save-group', 'App\Action\AdminAction:savegroup')->setName('admin.save-group');

    //Valuation Requests
    $app->get('/valuation-requests', 'App\Action\AdminAction:valuationrequests')->setName('admin.valuation-requests');


});


//Valuer Routes
$app->group('/valuer', function () use ($app) {
    $app->get('/', App\Action\ValuerAction::class)->setName('valuer.dashboard');
    //valuation
    $app->get('/valuation-requests', 'App\Action\ValuerAction:fetchvaluationrequests')->setName('valuer.valuation-requests');
    $app->get('/completed-requests', 'App\Action\ValuerAction:fetchcompletedrequests')->setName('valuer.completed-requests');
    $app->post('/submit-valuation', 'App\Action\ValuerAction:submitvaluation')->setName('valuer.submit-valuation');


})->add(new AuthenticationMiddleware($container));

//Staff Routes

$app->group('/staff', function () use ($app) {
    $app->get('/', App\Action\StaffAction::class)->setName('staff.dashboard');
    //valuation
    $app->get('/request-valuation', 'App\Action\StaffAction:valuationRequest')->setName('staff.request-valuation');
    $app->get('/manage-requests', 'App\Action\StaffAction:manageRequests')->setName('staff.manage-requests');
    $app->post('/save-request', 'App\Action\StaffAction:saveRequest')->setName('staff.save-request');
    $app->post('/update-valuation', 'App\Action\StaffAction:updateRequest')->setName('staff.update-request');
});
//API ROUTES
$app->group('/api', function () use ($app) {
    $app->post('/install-report/update', 'App\Action\AdminAction:saveInstallReport')->setName('admin.save-install-report');
})->add(new ApiAuthenticationMiddleware($container))
;
