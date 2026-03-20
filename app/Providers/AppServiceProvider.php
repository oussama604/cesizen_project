<?php

namespace App\Providers;

use App\Models\Content;
use App\Models\User;
use App\Policies\ContentPolicy;
use App\Policies\UserPolicy;
use App\Support\PasswordPolicy;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(fn (): Password => PasswordPolicy::rule());

        Gate::policy(Content::class, ContentPolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        Gate::define('access-admin-panel', function (User $user): bool {
            return $user->isAdmin();
        });

        Event::listen(Login::class, function (Login $event): void {
            User::query()
                ->whereKey($event->user->getAuthIdentifier())
                ->update(['last_login_at' => now()]);
        });
    }
}
