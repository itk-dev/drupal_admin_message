# Drupal admin message

Show message on admin routes.

![Admin message](images/message.png "Admin message")

## Installation

```shell
composer require itk-dev/drupal_admin_message
vendor/bin/drush pm:enable drupal_admin_message
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

## Coding standards

```shell
docker run --rm --volume ${PWD}:/app --workdir /app itkdev/php8.2-fpm:latest composer install
docker run --rm --volume ${PWD}:/app --workdir /app itkdev/php8.2-fpm:latest composer coding-standards-check
```

```shell
docker run --rm --volume ${PWD}:/app --workdir /app node:20 yarn install
docker run --rm --volume ${PWD}:/app --workdir /app node:20 yarn coding-standards-check
```

## Code analysis

```shell
docker run --rm --volume ${PWD}:/app --workdir /app itkdev/php8.2-fpm:latest scripts/code-analysis
```
