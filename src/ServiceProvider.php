<?php

namespace Zaengle\EnvoyerSentryReleaseNotifier;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('envoyer-sentry-release-notifier', function () {
            return new EnvoyerSentryReleaseNotifier();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['envoyer-sentry-release-notifier'];
    }
}
