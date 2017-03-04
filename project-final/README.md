# Set Up for Project

Clone this repo.

## PHP Connection

1. Get [MAMP](https://www.mamp.info/en/downloads/), or anything that can test `PHP` websites with local server. Following steps are for MAMP.
2. Go to Preferences —> Web Server —> Document Root. Set it to `project-final/src/public`.
3. Make sure to use `PHP 7.1`. Go to Preferences —> PHP and check `7.1.1`.
4. Go to any web browser and to `localhost:8888`. Port number can be different, you can check it from Preferences —> Ports —> Apache Port.

## Dependencies and Packages

Everything is under `vendor` so we don't need to do anything. If you need to update packages you will need to install Composer.

## Testing

Tests are located in `tests` and can be run with PHPUnit. You can think of this as the same general system as JUnit.
You can run the tests with `composer test` or `vendor/bin/phpunit --colors=always tests`.

## Logging

During development it is useful to monitor the application log stored id `logs/airbc.log`. It is useful to tail the log in terminal with `tail -f logs/airbc.log`.
