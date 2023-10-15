# Hyperf Metric

🔭 Drop-in replacement for the `hyperf/metric` component.

Suited for special needs, especially for OpenTelemetry, New Relic and Dynatrace platforms.

## Getting started

### Install

#### Add OpenCodeCo's Composer repository:
```shell
composer config repositories.opencodeco composer https://composer.opencodeco.dev
```

#### Update your `hyperf/metric`:
```shell
composer update hyperf/metric
```

### Development
| Command                   | Description                                                              |
|---------------------------|--------------------------------------------------------------------------|
| `./run help`              | To display the list of commands                                          |
| `./run build [?args]`     | To build the docker image (`./run build --no-cache`)                     |
| `./run composer [?args]`  | To run Composer commands inside the container (`./run composer install`) |
| `./run coverage [?args]`  | To run the code coverage tests (`./run coverage clover`)                 |
| `./run logs [?args]`      | To view logs of containers                                               |
| `./run sh [?args]`        | To access or run commands in the container shell (`./run sh ls -lha`)    |

#### Helpful commands
| Command                             | Description                                                           |
|-------------------------------------|-----------------------------------------------------------------------|
| `./run composer install`            | To install all Composer dependencies                                  |
| `./run composer update`             | To update all Composer depdendencies                                  |
| `./run composer require [package]`  | To add Composer dependency in project                                 |
| `./run composer test`               | To run all tests of project                                           |
| `./run composer cs-fix`              | To run PHP coding standards tool (`php-cs-fixer`)                      |
| `./run composer analyse`            | To run static analyse tool (`phpstan`)                                |
| `./run composer rector`             | To run instante upgrade and automated refactoring tool (`rector`)     |
| `./run coverage clover`             | To run the code coverage tests in Clover format (`clover.xml`)        |
| `./run coverage html 9999`          | To show the code coverage tests on browser (`http://0.0.0.0:9999`)    |
| `./run sh ls /etc/php82/conf.d`     | To list all extensions `.ini` files into `/etc/php82/conf.d` directory |
| `./run sh cat /etc/php82/php.ini`   | To view content of `php.ini` file into container                       |
