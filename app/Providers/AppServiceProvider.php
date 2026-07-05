<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\HariLibur;
use App\Models\JadwalMataKuliah;
use App\Models\JadwalSewa;
use App\Models\User;
use App\Policies\ActivityLogPolicy;
use App\Policies\HariLiburPolicy;
use App\Policies\JadwalMataKuliahPolicy;
use App\Policies\JadwalSewaPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        ActivityLog::class => ActivityLogPolicy::class,
        HariLibur::class => HariLiburPolicy::class,
        JadwalMataKuliah::class => JadwalMataKuliahPolicy::class,
        JadwalSewa::class => JadwalSewaPolicy::class,
    ];

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
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            \Illuminate\Support\Facades\Gate::policy($model, $policy);
        }
    }
}
