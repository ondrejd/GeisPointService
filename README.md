# GeisPointService

[![Build Status](https://travis-ci.org/ondrejd/GeisPointService.svg)](https://travis-ci.org/ondrejd/GeisPointService)

PHP implementace klienta pro webovou službu [GeisPoint](http://www.geispoint.cz/).

>> __For non-Czech visitors__: Since __GeisPoint__ web service is located in Czech Republic and serves mainly Czech users all documentation is written directly in Czech - anyway code self is commented in English.


## Instalace

__TBD__

## Použití

Nejprve rychlý příklad. Následující skript:

```php
<?php
require 'vendor/autoload.php';

$gpsrv = new \GeisPointService\Service();

// Získáme všechny regiony
$regions = $gpsrv->getRegions();
echo 'Počet regionů: '.count($regions).PHP_EOL;

// Vybereme náhodný region
$region = $regions[rand(0, count($regions) - 1)];
echo 'Města regionu '.$region->name.PHP_EOL;

// Vybereme města zvoleného regionu
$cities = $gpsrv->getCities(null, $region->id_region);
echo 'Počet měst: '.count($cities).PHP_EOL;

// Vybereme náhodné město
$city = $cities[rand(0, count($cities) - 1)];
echo 'Výdejní místa pro město '.$city->city.PHP_EOL;

// Najdeme výdejní místa v daném městě
$points = $gpsrv->searchPoints(null, $city->city, null);
echo 'Počet výdejních míst: '.count($points).PHP_EOL;
```

by měl vypsat následující výstup (konkrétní hodnoty se mohou lišit):

```
Počet regionů: 14
Města regionu Vysočina
Počet měst: 18
Výdejní místa pro město Havlíčkův Brod
Počet výdejních míst: 2
```

### Konfigurace

Konstruktor třídy `\GeisPointService\Service` přijíma jako jedinný argument pole s nastavením klienta. Možnosti konfigurace jsou následující:

#### Přehled nastavení

__TBD__

#### Příklad nastavení

__TBD__