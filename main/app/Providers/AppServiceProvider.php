<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Page;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Paginator::useBootstrap();

        $activeTemplate = activeTemplate();

        $general = GeneralSetting::first();
        $viewShare['general'] = $general;
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['pages'] = Page::where('tempname', $activeTemplate)->where('slug', '!=', 'home')->where('slug', '!=', 'blog')->where('slug', '!=', 'contact')->get();
        view()->share($viewShare);

        view()->composer('admin.partials.sidebar', function ($view) {
            $view->with([
                'banned_users_count'           => User::banned()->count(),
                'email_unverified_users_count' => User::emailUnverified()->count(),
                'sms_unverified_users_count'   => User::smsUnverified()->count(),
                'pending_ticket_count'         => SupportTicket::whereIN('status', [0, 2])->count(),
                'pending_withdraw_count'        => Withdraw::pending()->count(),
            ]);
        });

        view()->composer('admin.partials.header', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('read_status', 0)->orderBy('id', 'desc')->get(),
            ]);
        });

        view()->composer($activeTemplate . 'layouts.master', function ($view) {
            $view->with([
                'contact' => Frontend::where('data_keys', 'contact_us.content')->first(),
                'footer' => Frontend::where('data_keys', 'footer_section.content')->first(),
                'socials' => Frontend::where('data_keys', 'social_icon.element')->get(),
            ]);
        });
   

        if ($general->force_ssl) {
            \URL::forceScheme('https');
        }

        // Enable pagination
        if (!Collection::hasMacro('paginate')) {

            Collection::macro(
                'paginate',
                function ($perPage = 15, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage)->values()->all(),
                        $this->count(),
                        $perPage,
                        $page,
                        $options
                    ))
                        ->withPath('');
                }
            );
        }
    }
}
