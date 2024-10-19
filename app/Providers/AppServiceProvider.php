<?php

namespace App\Providers;

use App\Http\Interfaces\ListBookingsRepositoryInterface;
use App\Http\Interfaces\ListBookingsServiceInterface;
use App\Http\Interfaces\ListRoomsRepositoryInterface;
use App\Http\Interfaces\ListRoomsServiceInterface;
use App\Http\Interfaces\ShowCustomerRepositoryInterface;
use App\Http\Interfaces\ShowCustomerServiceInterface;
use App\Http\Interfaces\ShowRoomRepositoryInterface;
use App\Http\Interfaces\ShowRoomServiceInterface;
use App\Http\Interfaces\StoreBookingRepositoryInterface;
use App\Http\Interfaces\StoreBookingServiceInterface;
use App\Http\Interfaces\StoreCustomerRepositoryInterface;
use App\Http\Interfaces\StoreCustomerServiceInterface;
use App\Http\Interfaces\StorePaymentRepositoryInterface;
use App\Http\Interfaces\StorePaymentServiceInterface;
use App\Http\Interfaces\StoreRoomRepositoryInterface;
use App\Http\Interfaces\StoreRoomServiceInterface;
use App\Http\Repositories\ListBookingsRepository;
use App\Http\Repositories\ListRoomsRepository;
use App\Http\Repositories\ShowCustomerRepository;
use App\Http\Repositories\ShowRoomRepository;
use App\Http\Repositories\StoreBookingRepository;
use App\Http\Repositories\StoreCustomerRepository;
use App\Http\Repositories\StorePaymentRepository;
use App\Http\Repositories\StoreRoomRepository;
use App\Http\Services\ListBookingsService;
use App\Http\Services\ListRoomsService;
use App\Http\Services\ShowCustomerService;
use App\Http\Services\ShowRoomService;
use App\Http\Services\StoreBookingService;
use App\Http\Services\StoreCustomerService;
use App\Http\Services\StorePaymentService;
use App\Http\Services\StoreRoomService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ListBookingsRepositoryInterface::class, ListBookingsRepository::class);
        $this->app->singleton(ListBookingsServiceInterface::class, ListBookingsService::class);
        $this->app->singleton(ListRoomsRepositoryInterface::class, ListRoomsRepository::class);
        $this->app->singleton(ListRoomsServiceInterface::class, ListRoomsService::class);
        $this->app->singleton(ShowCustomerRepositoryInterface::class, ShowCustomerRepository::class);
        $this->app->singleton(ShowCustomerServiceInterface::class, ShowCustomerService::class);
        $this->app->singleton(ShowRoomRepositoryInterface::class, ShowRoomRepository::class);
        $this->app->singleton(ShowRoomServiceInterface::class, ShowRoomService::class);
        $this->app->singleton(StoreBookingRepositoryInterface::class, StoreBookingRepository::class);
        $this->app->singleton(StoreBookingServiceInterface::class, StoreBookingService::class);
        $this->app->singleton(StoreCustomerRepositoryInterface::class, StoreCustomerRepository::class);
        $this->app->singleton(StoreCustomerServiceInterface::class, StoreCustomerService::class);
        $this->app->singleton(StorePaymentRepositoryInterface::class, StorePaymentRepository::class);
        $this->app->singleton(StorePaymentServiceInterface::class, StorePaymentService::class);
        $this->app->singleton(StoreRoomRepositoryInterface::class, StoreRoomRepository::class);
        $this->app->singleton(StoreRoomServiceInterface::class, StoreRoomService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('auth-api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('public-api', function (Request $request) {
            return Limit::perMinute(120)->response(function (Request $request, array $headers) {
                return response()->json(['message' => 'Too Many Attempts'], 429, $headers);
            });
        });
    }
}
