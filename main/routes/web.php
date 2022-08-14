<?php

use Illuminate\Support\Facades\Route;


// clear artisan
Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    // \Illuminate\Support\Facades\Artisan::call('optimize');
    $notify[] = ['success', 'Cache has been cleared.'];
    return redirect()->route('home')->withNotify($notify);
});

Route::get(
    '/random',
    function ($length = 8) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
);

// Route::get('/cron', 'CronController@cron')->name('pv.matching.cron');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// User Support Ticket
Route::prefix('ticket')->group(function () {
    Route::get('/', 'TicketController@supportTicket')->name('ticket');
    Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');
    Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');
    Route::put('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');
    Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
});

/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('post.login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify-code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.change-link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });
    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

        // Users Manager
        Route::get('users', 'ManageUsersController@allUsers')->name('users.all');
        Route::get('users/active', 'ManageUsersController@activeUsers')->name('users.active');
        Route::get('users/banned', 'ManageUsersController@bannedUsers')->name('users.banned');
        Route::get('users/email-verified', 'ManageUsersController@emailVerifiedUsers')->name('users.emailVerified');
        Route::get('users/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.emailUnverified');
        Route::get('users/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.smsUnverified');
        Route::get('users/sms-verified', 'ManageUsersController@smsVerifiedUsers')->name('users.smsVerified');

        Route::get('users/{scope}/search', 'ManageUsersController@search')->name('users.search');
        Route::get('user/detail/{id}', 'ManageUsersController@detail')->name('users.detail');
        Route::get('user/referral/{id}', 'ManageUsersController@userRef')->name('users.ref');
        Route::post('user/update/{id}', 'ManageUsersController@update')->name('users.update');
        Route::post('user/add-sub-balance/{id}', 'ManageUsersController@addSubBalance')->name('users.addSubBalance');
        Route::get('user/send-email/{id}', 'ManageUsersController@showEmailSingleForm')->name('users.email.single');
        Route::post('user/send-email/{id}', 'ManageUsersController@sendEmailSingle')->name('users.email.single');
        Route::get('user/transactions/{id}', 'ManageUsersController@transactions')->name('users.transactions');
        Route::get('user/withdrawals/{id}', 'ManageUsersController@withdrawals')->name('users.withdrawals');
        Route::get('user/withdrawals/shiba/{id}', 'ManageUsersController@withdrawalShiba')->name('users.withdrawals.shiba');
        Route::get('user/withdrawals/via/{method}/{type?}/{userId}', 'ManageUsersController@withdrawalsViaMethod')->name('users.withdrawals.method');

        Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
        Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.send');
        Route::get('notification/read/{id}', 'AdminController@notificationRead')->name('notification.read');
        Route::get('notifications', 'AdminController@notifications')->name('notifications');

        // epins
        Route::get('epins', 'ManageEpinsController@allEpins')->name('epins.all');
        Route::get('epins/unused', 'ManageEpinsController@unusedEpins')->name('epins.unused');
        Route::get('epins/used', 'ManageEpinsController@usedEpins')->name('epins.used');
        Route::post('epins/update/{id}', 'ManageEpinsController@epinUpdate')->name('epins.update');
        Route::post('epins/store', 'ManageEpinsController@epinStore')->name('epins.store');

        Route::get('hdshares', 'HDSharesController@index')->name('hdshares');
        Route::post('hdshares/lock', 'HDSharesController@lockShares')->name('hdshares.lock');
        Route::post('hdshares/open', 'HDSharesController@openShares')->name('hdshares.open');





        // General Setting
        Route::get('general-setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('general-setting', 'GeneralSettingController@update')->name('setting.update');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo_icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo_icon');

        // mlm plan
        Route::get('plans', 'MlmController@plan')->name('plan');
        Route::post('plan/store', 'MlmController@planStore')->name('plan.store');

        Route::post('plan/update', 'MlmController@planUpdate')->name('plan.update');


        // matching bonus
        Route::post('matching-bonus/update', 'MlmController@matchingUpdate')->name('matching-bonus.update');

        // roi updates
        Route::post('roi/update', 'MlmController@roiUpdate')->name('roi.update');


        // tree
        Route::get('/tree/{id}', 'ManageUsersController@tree')->name('users.single.tree');
        Route::get('/user/tree/{user}', 'ManageUsersController@otherTree')->name('users.other.tree');
        Route::get('/user/tree/search', 'ManageUsersController@otherTree')->name('users.other.tree.search');

        // Report
        Route::get('report/referral-commission', 'ReportController@refCom')->name('report.refCom');
        Route::get('report/binary-commission', 'ReportController@binary')->name('report.binaryCom');
        Route::get('report/invest', 'ReportController@invest')->name('report.invest');

        Route::get('report/pv-log', 'ReportController@pvLog')->name('report.pvLog');
        Route::get('report/pv-log/{id}', 'ReportController@singlePvLog')->name('report.single.pvLog');

        Route::get('report/transaction', 'ReportController@transaction')->name('report.transaction');
        Route::get('report/transaction/search', 'ReportController@transactionSearch')->name('report.transaction.search');


        // Route::get('report/login/history', 'ReportController@loginHistory')->name('report.login.history');
        // Route::get('report/login/ipHistory/{ip}', 'ReportController@loginIpHistory')->name('report.login.ipHistory');

        // DIGITAL ASSETS
        Route::name('digital.assets.')->prefix('digital')->group(function () {
            Route::get('/index', 'DigitalAssetController@index')->name('index');
            Route::post('/store', 'DigitalAssetController@store')->name('store');
            Route::post('/update/{id}', 'DigitalAssetController@update')->name('update');
            Route::get('/delete/{id}', 'DigitalAssetController@delete')->name('delete');
        });


        // WITHDRAW SYSTEM
        Route::name('withdraw.')->prefix('withdraw')->group(function () {
            Route::get('pending', 'WithdrawalController@pending')->name('pending');
            Route::get('approved', 'WithdrawalController@approved')->name('approved');
            Route::get('rejected', 'WithdrawalController@rejected')->name('rejected');
            Route::get('log', 'WithdrawalController@log')->name('log');
            Route::get('shiba/pending', 'WithdrawalController@shibaPending')->name('shiba.pending');
            Route::get('shiba/approved', 'WithdrawalController@shibaApproved')->name('shiba.approved');
            Route::get('shiba/rejected', 'WithdrawalController@shibaRejected')->name('shiba.rejected');
            Route::get('shiba/log', 'WithdrawalController@shibaLog')->name('shiba.log');
            Route::get('via/{method_id}/{type?}', 'WithdrawalController@logViaMethod')->name('method');
            Route::get('{scope}/search', 'WithdrawalController@search')->name('search');
            Route::get('{scope}/shiba/search', 'WithdrawalController@shibaSearch')->name('shiba.search');
            Route::get('date-search/{scope}', 'WithdrawalController@dateSearch')->name('dateSearch');
            Route::get('details/{id}', 'WithdrawalController@details')->name('details');
            Route::get('details/shiba/{id}', 'WithdrawalController@shibaDetails')->name('shiba.details');
            Route::post('approve', 'WithdrawalController@approve')->name('approve');
            Route::post('reject', 'WithdrawalController@reject')->name('reject');
            Route::post('shiba/approve', 'WithdrawalController@shibaApprove')->name('shiba.approve');
            Route::post('shiba/reject', 'WithdrawalController@shibaReject')->name('shiba.reject');


            // Withdraw Method
            Route::get('method/', 'WithdrawMethodController@methods')->name('method.index');
            Route::get('method/create', 'WithdrawMethodController@create')->name('method.create');
            Route::post('method/create', 'WithdrawMethodController@store')->name('method.store');
            Route::get('method/edit/{id}', 'WithdrawMethodController@edit')->name('method.edit');
            Route::post('method/edit/{id}', 'WithdrawMethodController@update')->name('method.update');
            Route::post('method/activate', 'WithdrawMethodController@activate')->name('method.activate');
            Route::post('method/deactivate', 'WithdrawMethodController@deactivate')->name('method.deactivate');
        });

        // Admin Support
        Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');
        Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');
        Route::post('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete');


        // Email Setting
        Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email.template.global');
        Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('email.template.global');
        Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email.template.setting');
        Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('email.template.setting');
        Route::get('email-template/index', 'EmailTemplateController@index')->name('email.template.index');
        Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email.template.edit');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email.template.update');
        Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email.template.sendTestMail');

        // Frontend

        Route::get('seo', 'FrontendController@seoEdit')->name('seo');

        Route::name('frontend.')->prefix('frontend')->group(function () {

            Route::get('templates', 'FrontendController@templates')->name('templates');
            Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');

            Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
            Route::post('remove', 'FrontendController@remove')->name('remove');

            // Page Builder
            Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');
            Route::post('manage-pages', 'PageBuilderController@managePagesSave')->name('manage.pages.save');
            Route::post('manage-pages/update', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
        });
    });
});


/*
|--------------------------------------------------------------------------
| Start User Area
|--------------------------------------------------------------------------
*/
Route::name('user.')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    // Route::post('register', 'Auth\RegisterController@register')->middleware('regStatus');
    Route::post('register', 'Auth\RegisterController@register')->name('registeration');

    // get referral link with query params
    // Route::get('')



    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/code-verify', 'Auth\ForgotPasswordController@codeVerify')->name('password.code_verify');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('password.verify-code');

    // Route::get('/home', 'HomeController@index')->name('home');
    // Route::middleware(['checkStatus'])->group(function () {
    // });
});

Route::name('user.')->prefix('user')->group(
    function () {
        Route::middleware('auth')->group(
            function () {
                Route::get('/dashboard', 'UserController@index')->name('home');
                Route::get('/referral-log', 'UserController@referralCom')->name('referral.log');
                Route::get('profile-setting', 'UserController@profile')->name('profile-setting');
                Route::post('profile-setting', 'UserController@submitProfile');
                Route::get('change-password', 'UserController@changePassword')->name('change-password');
                Route::post('change-password', 'UserController@submitPassword');

                //epins
                Route::get('epins', 'UserController@allEpins')->name('epins');
                Route::get('epins/unused', 'UserController@epinsUnused')->name('epins.unused');
                Route::get('epins/used', 'UserController@epinsUsed')->name('epins.used');
                Route::get('epins/sent', 'UserController@epinsSent')->name('epins.sent');
                Route::post('epins/sent', 'UserController@epinSend')->name('epins.sent.user');


                // plans
                Route::get("/plan", "PlanController@index")->name('plan');
                Route::get("pv-log", "PlanController@pvlog")->name('pv.log');
                Route::post("claimRoi", "PlanController@claimRoi")->name('claim.roi');
                Route::post("claimFixedRoi", "PlanController@claimFixedRoi")->name('claim.fixed.roi');
                Route::post("withdrawFixedRoi", "PlanController@withdrawFixedRoi")->name('withdraw.fixed.roi');
                Route::post('/plan', 'PlanController@planStore')->name('plan.purchase');
                Route::get("/fixed-investment", "PlanController@fixedInvestment")->name('plan.fixed.investment');
                Route::post('/fixed-investment/purchase', 'PlanController@fixedInvestmentStore')->name('plan.fixed.investment.purchase');
                Route::get('/referrals', 'PlanController@myRefLog')->name('my.ref');
                Route::get('/tree', 'PlanController@myTree')->name('my.tree');
                Route::get('/tree/{user}', 'PlanController@otherTree')->name('other.tree');
                Route::get('/tree/search', 'PlanController@otherTree')->name('other.tree.search');
                Route::get('/binary-log', 'PlanController@binaryCom')->name('binary.log');
                Route::get('/binary-summary', 'PlanController@binarySummary')->name('binary.summary');
                // Route::get('placement-list', 'PlanController@placementList')->name('placement.list');

                //Report
                Route::get('report/deposit/log', 'UserReportController@depositHistory')->name('report.deposit');
                Route::get('report/invest/log', 'UserReportController@investLog')->name('report.invest');
                Route::get('report/transactions/log', 'UserReportController@transactions')->name('report.transactions');
                Route::get('report/withdraw/log', 'UserReportController@withdrawLog')->name('report.withdraw');
                Route::get('report/referral/commission', 'UserReportController@refCom')->name('report.refCom');
                Route::get('report/binary/commission', 'UserReportController@binaryCom')->name('report.binaryCom');
                Route::get('h_dshares', 'HDSharesController@index')->name('h_dshares');
                Route::post('h_dshares/buy-shares', 'HDSharesController@buyShares')->name('h_dshares.buy');
                Route::post('h_dshares/sell-shares', 'HDSharesController@sellShares')->name('h_dshares.sell');

                // Withdraw
                Route::get('/withdraw', 'UserController@withdrawMoney')->name('withdraw');
                Route::post('/withdraw', 'UserController@withdrawStore')->name('withdraw.money');
                Route::get('/withdraw/preview', 'UserController@withdrawPreview')->name('withdraw.preview');
                Route::post('/withdraw/preview', 'UserController@withdrawSubmit')->name('withdraw.submit');
                Route::get('/withdraw/history', 'UserController@withdrawLog')->name('withdraw.history');
                Route::post('/withdraw/shiba', 'UserController@withdrawShiba')->name('withdraw.shiba.money');

                //balance transfer
                Route::get('/transfer', 'UserController@indexTransfer')->name('balance.transfer');
                Route::post('/transfer', 'UserController@balanceTransfer')->name('balance.transfer.post');
                Route::post('/search-user', 'UserController@searchUser')->name('search.user');
                Route::post('/check-pin', 'UserController@checkPin')->name('check.pin');

                // claim digital product
                Route::post('/claim', 'UserController@claim')->name('digital.claim');

                // KYC
                Route::get('/kyc', 'UserController@kyc')->name('kyc');
                Route::post('/kyc', 'UserController@kycStore')->name('kyc.store');
            }
        );
    }
);

Route::post('/check/sponsor', 'SiteController@CheckSponsor')->name('check.sponsor');
Route::post('/check/placer', 'SiteController@CheckPlacer')->name('check.placer');
Route::post('/check/epin', 'SiteController@CheckEpin')->name('check.epin');
Route::post('/check/username', 'SiteController@checkUsername')->name('check.username');
Route::post('/get/user/position', 'SiteController@userPosition')->name('get.user.position');
Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholderImage');

Route::get('/', 'SiteController@index')->name('home');
Route::post('subscriber', 'SiteController@subscriberStore')->name('subscriber.store');
// Policy Details
Route::get('policy/{slug}/{id}', 'SiteController@policyDetails')->name('policy.details');

Route::get('/contact', 'SiteController@contact')->name('contact');
Route::post('/contact', 'SiteController@contactSubmit')->name('contact.send');
Route::get('/change/{lang?}', 'SiteController@changeLanguage')->name('lang');

Route::get('/blog', 'SiteController@blog')->name('blog');
Route::get('/blog/details/{slug}/{id}', 'SiteController@singleBlog')->name('singleBlog');

Route::get('/{slug}', 'SiteController@pages')->name('pages');

Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholderImage');
Route::get('links/{slug}', 'SiteController@links')->name('links');


// Auth::routes();


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
