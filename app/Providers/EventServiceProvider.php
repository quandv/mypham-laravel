<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Backend\Order\OrderStatusEvent' => [
            'App\Listeners\Backend\Order\CreateOrderStatusLog',
        ],
        'App\Events\Frontend\Cart\CartAdd' => [
            'App\Listeners\Frontend\Cart\CartAddNotification',
        ],
        'App\Events\Backend\Order\OrderApproved' => [
            'App\Listeners\Backend\Order\OrderApprovedNotification',
        ],
        'App\Events\Backend\Order\OrderDone' => [
            'App\Listeners\Backend\Order\OrderDoneNotification',
        ],
        'App\Events\Backend\Order\OrderDestroy' => [
            'App\Listeners\Backend\Order\OrderDestroyNotification',
        ],
        'App\Events\Backend\Order\OrderPending' => [
            'App\Listeners\Backend\Order\OrderPendingNotification',
        ],
        'App\Events\Backend\CatalogInput\CatalogInputAdd' => [
            'App\Listeners\Backend\CatalogInput\CatalogInputAddLog',
        ],
        'App\Events\Backend\CatalogInput\CatalogInputEdit' => [
            'App\Listeners\Backend\CatalogInput\CatalogInputEditLog',
        ],
        'App\Events\Backend\CatalogInput\CatalogInputDel' => [
            'App\Listeners\Backend\CatalogInput\CatalogInputDelLog',
        ],
        'App\Events\Backend\UnitInput\UnitInputAdd' => [
            'App\Listeners\Backend\UnitInput\UnitInputAddLog',
        ],
        'App\Events\Backend\UnitInput\UnitInputEdit' => [
            'App\Listeners\Backend\UnitInput\UnitInputEditLog',
        ],
        'App\Events\Backend\UnitInput\UnitInputDel' => [
            'App\Listeners\Backend\UnitInput\UnitInputDelLog',
        ],
        'App\Events\Backend\ProductInput\ProductInputAdd' => [
            'App\Listeners\Backend\ProductInput\ProductInputAddLog',
        ],
        'App\Events\Backend\ProductInput\ProductInputEdit' => [
            'App\Listeners\Backend\ProductInput\ProductInputEditLog',
        ],
        'App\Events\Backend\ProductInput\ProductInputDel' => [
            'App\Listeners\Backend\ProductInput\ProductInputDelLog',
        ],
        'App\Events\Backend\OrderInput\OrderInputAdd' => [
            'App\Listeners\Backend\OrderInput\OrderInputAddLog',
        ],
        'App\Events\Backend\OrderInput\OrderInputEdit' => [
            'App\Listeners\Backend\OrderInput\OrderInputEditLog',
        ],
        'App\Events\Backend\Recipe\RecipeAdd' => [
            'App\Listeners\Backend\Recipe\RecipeAddLog',
        ],
        'App\Events\Backend\Recipe\RecipeEdit' => [
            'App\Listeners\Backend\Recipe\RecipeEditLog',
        ],
        'App\Events\Backend\Product\ProductAdd' => [
            'App\Listeners\Backend\Product\ProductAddLog',
        ],
        'App\Events\Backend\Product\ProductEdit' => [
            'App\Listeners\Backend\Product\ProductEditLog',
        ],
        'App\Events\Backend\Product\ProductDel' => [
            'App\Listeners\Backend\Product\ProductDelLog',
        ],
        'App\Events\Backend\Product\ProductUpdateSts' => [
            'App\Listeners\Backend\Product\ProductUpdateStsLog',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot()
    {
        parent::boot();
         //
    }
}
