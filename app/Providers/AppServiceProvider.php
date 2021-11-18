<?php

namespace App\Providers;

use App\Services\Accounts\Crud as AccountsCrud;
use App\Services\Contacts\Crud as ContactsCrud;
use App\Services\Notes\Crud as NotesCrud;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use App\Services\Accounts\Contracts\CrudInterface as AccountsCrudInterface;
use App\Services\Contacts\Contracts\CrudInterface as ContactsCrudInterface;
use App\Services\Notes\Contracts\CrudInterface as NotesCrudInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AccountsCrudInterface::class, AccountsCrud::class);
        $this->app->bind(ContactsCrudInterface::class, ContactsCrud::class);
        $this->app->bind(NotesCrudInterface::class, NotesCrud::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'account' => 'App\Models\Account',
            'contact' => 'App\Models\Contact',
        ]);
    }
}
