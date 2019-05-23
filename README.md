# GeoKrety Map PHP Client


[![Build Status](https://travis-ci.org/GeoKretyMap/php-client.svg)](https://travis-ci.org/GeoKretyMap/php-client)
[![Latest Stable Version](https://poser.pugx.org/geokretymap/php-client/v/stable.png)](https://packagist.org/packages/geokretymap/php-client)
[![Total Downloads](https://poser.pugx.org/geokretymap/php-client/downloads.png)](https://packagist.org/packages/geokretymap/php-client)


## Introduction

This project embeds a PHP client class for [GeoKrety Map](https://geokretymap.org/) (aka. GKM) service.

 * GKM Api are described [here](https://github.com/GeoKretyMap/gkm/wiki/Api-endpoints).
 * GKM source is also on github [GeoKretyMap](https://github.com/GeoKretyMap) organization.

## How to use

* Installation

- [geokretymap/php-client on Packagist](https://packagist.org/packages/geokretymap/php-client)
- [GeoKretyMap/php-client on GitHub](https://github.com/GeoKretyMap/php-client)

From the command line run

```
$ composer require geokretymap/php-client
```

## How to contribute


### Dependencies
* Install dependencies

```
 composer install
``` 

* Install certificates bundle (used by https call)

   * download the [certificate bundle](https://curl.haxx.se/docs/caextract.html)
   * update your `php.ini` :

```
curl.cainfo="C:\CACERT\cacert-2019-05-15.pem"
openssl.cafile="C:\CACERT\cacert-2019-05-15.pem"
```

### Sample
* Execute sample

```
 php UsageSample.php
``` 

### Testing

* Execute tests

```
 vendor/bin/phpunit
``` 

NB: to activate *test code coverage* you will need to install and enable php [Xdebug extension](https://xdebug.org/docs/install).