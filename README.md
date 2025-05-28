# Drupal admin message

Show message on admin routes.

![Admin message](images/message.png "Admin message")

## Installation

```shell
composer require itk-dev/drupal_admin_message
vendor/bin/drush pm:install drupal_admin_message
```

Exclude the module from the configuration synchronization (cf.
<https://www.drupal.org/node/3079028>):

```php
# settings.local.php
$settings['config_exclude_modules'][] = 'drupal_admin_message';
```

## Configuration

```php
# settings.local.php

# Define one or more message blocks:
$settings['drupal_admin_message']['blocks'][] = 'This is a message';
$settings['drupal_admin_message']['blocks'][] = 'Some more info';

# Optionally override style (CSS)
$settings['drupal_admin_message']['css']['background-color'] = 'orange';
$settings['drupal_admin_message']['css']['color'] = 'white;';
```

The message can optionally be shown on _all_ pages:

```php
# settings.local.php
$settings['drupal_admin_message']['show_on_all_pages'] = TRUE;
```

## Coding standards

```shell
docker compose run --rm phpfpm composer install
docker compose run --rm phpfpm vendor/bin/phpcbf
docker compose run --rm phpfpm vendor/bin/phpcs
```

```shell
docker compose run --rm markdownlint markdownlint '**/*.md'
```

## Code analysis

Running static analyses on a Drupal module (may) require a full Drupal installation. Therefore we run code analysis
using [the official Drupal docker image](https://hub.docker.com/_/drupal/) (see [scripts/base](scripts/base) for
details).

```shell
./scripts/phpstan
./scripts/rector
 ```
