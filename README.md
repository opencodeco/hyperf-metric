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
| `./run test [?args]`      | To run the tests                                                         |
| `./run coverage [?args]`  | To run the code coverage tests (`./run coverage clover`)                 |
| `./run fixer [?args]`      | To run the php-cs-fixer (`./run fixer [file_path]`)                         |
| `./run analyse`           | To run the static code analysis tests                                    |
| `./run rector`            | To run the rector tests                                                  |
| `./run logs [?args]`      | To view logs of containers                                               |
| `./run sh [?args]`        | To access or run commands in the container shell (`./run sh ls -lha`)    |

#### Helpful commands
| Command                             | Description                                                        |
|-------------------------------------|--------------------------------------------------------------------|
| `./run composer install`            | To install all Composer dependencies                               |
| `./run composer update`             | To update all Composer depdendencies                               |
| `./run composer require [package]`  | To add Composer dependency in project                              |
| `./run coverage`                    | To run the code coverage tests in Clover format (`clover.xml`)     |
| `./run coverage html 9999`          | To show the code coverage tests on browser (`http://0.0.0.0:9999`) |
