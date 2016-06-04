<?php namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\Article::class => \App\Policies\ArticlePolicy::class,
        \App\Models\Character::class => \App\Policies\CharacterPolicy::class,
        \App\Models\Comment::class => \App\Policies\CommentPolicy::class,
        \App\Models\Event::class => \App\Policies\EventPolicy::class,
        \App\Models\ImageAlbum::class => \App\Policies\ImageAlbumPolicy::class,
        \App\Models\UserProfile::class => \App\Policies\UserProfilePolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        foreach(['AdminPolicy', 'GeneralPolicy'] as $policy) {
            $gate = $this->defineFromClass($gate, "App\\Policies\\{$policy}");
        }

        $this->registerPolicies($gate);
    }

    /**
     * Define policy methods in the given gate using the given policy class.
     *
     * @param  GateContract  $gate
     * @param  string  $className
     * @return GateContract
     */
    private function defineFromClass(GateContract $gate, $className)
    {
        $class = "\\{$className}";
        foreach (get_class_methods(new $class) as $method) {
            $gate->define($method, "{$className}@{$method}");
        }

        return $gate;
    }
}
