#!/usr/bin/env bash
vendor/bin/phpunit tests/ && php coverage-checker.php clover.xml 50