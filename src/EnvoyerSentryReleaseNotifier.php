<?php

namespace Zaengle\EnvoyerSentryReleaseNotifier;

/**
 * Class SentryReleaseNotifier.
 */
class EnvoyerSentryReleaseNotifier {
    /**
     * @return string
     * @throws \Exception
     */
    public function getCommitHash(): string
    {
        $latestCommitHash = base_path('.commit_hash');

        if (file_exists($latestCommitHash)) {
            return trim(exec(sprintf('cat %s', $latestCommitHash)));
        }

        if (is_dir(base_path('.git'))) {
            return trim(exec('git log --pretty="%h" -n1 HEAD'));
        }

        throw new \Exception('Could not retrieve a commit hash.');
    }
}
