<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Bill;
use App\Repositories\user\Account\AccountInterface;
use App\Repositories\user\Account\AccountRepository;
use App\Repositories\user\Bill\BillInterface;
use App\Repositories\user\Bill\BillRepository;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AccountInterface::class, function () {
            return new AccountRepository(new Container(), new Request(), new Account());
        });

        $this->app->bind(BillInterface::class, function () {
            return new BillRepository(new Container(), new Request(), new Bill());
        });
    }



    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
