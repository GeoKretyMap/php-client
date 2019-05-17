#!/bin/bash
# git tag x.y.z a& git push --tags
# https://jameshfisher.com/2017/11/06/how-to-release-a-composer-package/
curl \
  -X POST \
  -H 'Content-Type: application/json' \
  -d '{"repository":{"url":"https://github.com/GeoKretyMap/php-client"}}' \
  "https://packagist.org/api/update-package?username=boly38&apiToken=${PACKAGIST_API_TOKEN}"