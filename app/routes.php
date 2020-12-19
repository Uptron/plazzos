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



});


//Merchant Routes
$app->group('/merchant', function () use ($app) {
    $app->get('/', App\Action\HomeAction::class)->setName('merchant.dashboard');
    //Products
    $app->get('/add-product', 'App\Action\HomeAction:newProduct')->setName('merchant.add-product');
    $app->get('/manage-products', 'App\Action\HomeAction:fetchProducts')->setName('merchant.manage-products');
    $app->post('/save-product', 'App\Action\HomeAction:saveProduct')->setName('merchant.save-product');
    $app->post('/update-product', 'App\Action\HomeAction:updateProduct')->setName('merchant.update-product');

    //Worker Groups
    $app->get('/add-group', 'App\Action\HomeAction:newGroup')->setName('merchant.add-group');
    $app->get('/manage-groups', 'App\Action\HomeAction:fetchGroups')->setName('merchant.manage-groups');
    $app->post('/save-group', 'App\Action\HomeAction:saveGroup')->setName('merchant.save-group');

    //Workers
    $app->get('/add-worker', 'App\Action\HomeAction:newWorker')->setName('merchant.add-worker');
    $app->get('/manage-workers', 'App\Action\HomeAction:fetchWorkers')->setName('merchant.manage-workers');
    $app->post('/save-worker', 'App\Action\HomeAction:saveWorker')->setName('merchant.save-worker');
    $app->post('/save-workers-bulk', 'App\Action\HomeAction:worker_bulk_upload')->setName('merchant.save-workers-bulk');

    //Payments
    $app->get('/initiate-payment', 'App\Action\HomeAction:initiatePayment')->setName('merchant.initiate-payment');
    $app->get('/payments/single-worker', 'App\Action\HomeAction:oneWorker')->setName('merchant.quick-payments-single-worker');
    $app->get('/payments/workergroup', 'App\Action\HomeAction:workerGroups')->setName('merchant.quick-payments-workergroup');
    $app->get('/payments/bulk-upload', 'App\Action\HomeAction:bulkUpload')->setName('merchant.quick-payments-bulk-upload');
    $app->post('/pay-workgroup', 'App\Action\HomeAction:payWorkGroup')->setName('merchant.pay-workgroup');
    $app->post('/product-payout', 'App\Action\HomeAction:productPayout')->setName('merchant.product-payout');
    $app->post('/pay-single-worker', 'App\Action\HomeAction:paySingleWorker')->setName('merchant.pay-single-worker');
    $app->get('/approve-payment', 'App\Action\HomeAction:approvePayment')->setName('merchant.approve-payment');

});
//->add(new AuthenticationMiddleware($container))
//API ROUTES
$app->group('/api', function () use ($app) {
    $app->post('/install-report/update', 'App\Action\AdminAction:saveInstallReport')->setName('admin.save-install-report');
})->add(new ApiAuthenticationMiddleware($container))
;
