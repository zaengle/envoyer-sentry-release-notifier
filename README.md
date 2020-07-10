# Envoyer Sentry Release Notifier
This tool helps with the process of collecting commits and sending them to Sentry as a new release.

## Sentry Config

```php
<?php

use Zaengle\EnvoyerSentryReleaseNotifier\EnvoyerSentryReleaseNotifier;

return [
    // capture release as git sha
    'release' => (new EnvoyerSentryReleaseNotifier())->getCommitHash(),
    
    // rest of config...
];
```

## Envoyer Hooks

These commands should be added as Deployment Hooks in the Envoyer control panel:

## Clone New Release : AFTER
```shell script
yes | cp -f {{project}}/current/.commit_hash {{release}}/.commit_hash_previous
echo "{{ sha }}" > {{release}}/.commit_hash
```

## Activate New Release : AFTER
```shell script
echo "{{ sha }}" > {{release}}/.commit_hash
```
**NOTE** - This command may need to be run one time before activating any of the other hooks so the initial `.commit_hash` file is created for subsequent steps.

## Purge Old Releases : AFTER

```shell script
export SENTRY_BEARER_TOKEN="MyBearerToken"
export SENTRY_PROJECT="my-sentry-project-name"
export ENVIRONMENT="develop"
export PREVIOUS_SHA=`tail {{release}}/.commit_hash_previous`

cd {{ release }}
curl https://sentry.io/api/0/organizations/zaengle/releases/ \
-H "Authorization: Bearer ${SENTRY_BEARER_TOKEN}" \
-X POST \
-H "Content-Type:application/json" \
-d "{
    \"environment\":\"${ENVIRONMENT}\",
    \"version\":\"{{sha}}\",
    \"refs\":[{
        \"repository\":\"zaengle/my-repository-name\",
        \"commit\":\"{{sha}}\",
        \"previousCommit\": \"${PREVIOUS_SHA}\"
    }],
    \"projects\": [\"my-sentry-project-name\"]
}"

curl https://sentry.io/api/0/organizations/zaengle/releases/{{sha}}/deploys/ \
-X POST \
-H "Authorization: Bearer ${SENTRY_BEARER_TOKEN}" \
-H 'Content-Type: application/json' \
-d "
{
    \"environment\": \"${ENVIRONMENT}\",
    \"name\": \"{{release}}\"
}"
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- [Original blog article](https://humaan.com/blog/tracking-envoyer-releases-in-sentry/)
- [Discussion forum post](https://forum.sentry.io/t/sentry-io-all-commits-associated-to-all-releases/3892)
