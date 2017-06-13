<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected static $repositories = [
        'user' => [
            \App\Repositories\Contracts\UserInterface::class,
            \App\Repositories\Eloquent\UserRepository::class,
        ],
        'role' => [
            \App\Repositories\Contracts\RoleInterface::class,
            \App\Repositories\Eloquent\RoleRepository::class,
        ],
        'type' => [
            \App\Repositories\Contracts\TypeInterface::class,
            \App\Repositories\Eloquent\TypeRepository::class,
        ],
        'campaign' => [
            \App\Repositories\Contracts\CampaignInterface::class,
            \App\Repositories\Eloquent\CampaignRepository::class,
        ],
        'tag' => [
            \App\Repositories\Contracts\TagInterface::class,
            \App\Repositories\Eloquent\TagRepository::class,
        ],
        'event' => [
            \App\Repositories\Contracts\EventInterface::class,
            \App\Repositories\Eloquent\EventRepository::class,
        ],
        'quality' => [
            \App\Repositories\Contracts\QualityInterface::class,
            \App\Repositories\Eloquent\QualityRepository::class,
        ],
        'social_account' => [
            \App\Repositories\Contracts\SocialAccountInterface::class,
            \App\Repositories\Eloquent\SocialAccountRepository::class,
        ],
        'action' => [
            \App\Repositories\Contracts\ActionInterface::class,
            \App\Repositories\Eloquent\ActionRepository::class,
        ],
        'media' => [
            \App\Repositories\Contracts\MediaInterface::class,
            \App\Repositories\Eloquent\MediaRepository::class,
        ],
        'comment' => [
            \App\Repositories\Contracts\CommentInterface::class,
            \App\Repositories\Eloquent\CommentRepository::class,
        ],
        'donation' => [
            \App\Repositories\Contracts\DonationInterface::class,
            \App\Repositories\Eloquent\DonationRepository::class,
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (static::$repositories as $repository) {
            $this->app->singleton(
                $repository[0],
                $repository[1]
            );
        }
    }
}
