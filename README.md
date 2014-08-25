## Instalation

1. Add `"keltanas/landing-tracking-bundle": "1.0.*@dev"` to your `composer.json`

2. Add bundle to `app/AppKernel.php`

    ``` php
    new keltanas\Bundle\TrackingBundle\keltanasTrackingBundle(),
    ```

3. Add to `app/config/config.yml`

    ``` php
    keltanas_tracking:
        email_from: "%mailer_user%"
        email_to: "%mailer_user%"
    ```

4. Add to `app/config/routing.yml`

    ``` yml
    keltanas_tracking:
        resource: "@keltanasTrackingBundle/Resources/config/routing.yml"
        prefix:   /tracking
    ```

5. Perform `php composer update`

6. Redefine `base.html.twig` as `app/Resources/keltanasTrackingBundle/views/base.html.twig`

7. Perform `app/console doctrine:schema:update --force` or create migration
