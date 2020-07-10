<?php

namespace Zaengle\SentryReleaseNotifier\Facades;

/**
 * Class EnvoyerSentryReleaseNotifier.
 */
class Facade extends Illuminate\Support\Facades\Facade
{
    /**
     * @method static getCommitHash(): string
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'envoyer-sentry-release-notifier';
    }
}
