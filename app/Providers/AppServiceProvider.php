<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider AS ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Models\User;
use App\Policies\DashboardPolicy;
use App\Models\Produk;
use App\Policies\ProdukPolicy;
use APP\Models\Penjualan;
use App\Policies\PenjualanPolicy;
use App\Models\ItemPenjualan;
use App\Policies\ItemPenjualanPolicy;

class AppServiceProvider extends ServiceProvider
{
   protected $policies = [
    User::class => DashboardPolicy::class,
    Produk::class => ProdukPolicy::class,
    Penjualan::class => PenjualanPolicy::class,
    ItemPenjualan::class => ItemPenjualanPolicy::class
   ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Carbon::setLocale('id');
        $this->registerPolicies();
    }
}
