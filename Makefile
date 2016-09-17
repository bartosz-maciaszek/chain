# install composer (for development)
composer:
	composer install

# update composer (for development)
composer_update:
	composer update

# Run tests, linters and any other quality assurance tool.
qa: composer test lint

# Run tests.
test: phpspec phpunit

# Lint the code.
lint: phpcs phpmd

# Build reports about the code / the project / the app.
report: phpspec_report phpunit_report
	php ./vendor/bin/phpcov merge --text tests/coverage/coverage.txt --html tests/coverage/html tests/coverage

# run the PHPUnit tests
phpunit:
	php ./vendor/bin/phpunit

phpunit_report:
	php ./vendor/bin/phpunit --coverage-php tests/coverage/phpunit.cov

# run the PHPSpec tests
phpspec:
	php ./vendor/bin/phpspec run --no-code-generation

phpspec_report:
	php ./vendor/bin/phpspec run --no-code-generation --config phpspec.report.yml

# run PHPCS on the source code and show any style violations
phpcs:
	php ./vendor/bin/phpcs --standard="ruleset.xml" src

# run PHPCBF to auto-fix code style violations
phpcs_fix:
	php ./vendor/bin/phpcbf --standard="ruleset.xml" src

# Run PHP Mess Detector on the source code
phpmd:
	php ./vendor/bin/phpmd src text ./phpmd.xml
