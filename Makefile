cs:
	vendor/squizlabs/php_codesniffer/bin/phpcs app --standard=phpcs.xml -v

fixer:
	vendor/bin/php-cs-fixer fix --verbose --allow-risky yes --show-progress=estimating

run:
	clear
	php console.php getMenus example_input.ebnf 25/07/18 21:00 NW42QA 24

test:
	clear
	vendor/bin/phpunit tests

coverages:
	clear
	vendor/bin/phpunit tests --coverage-html coverage --whitelist app src
