#!/usr/bin/env bash

set -e

docker-compose exec -T php_fpm_debug sh -c "sh runAllTests.sh"


