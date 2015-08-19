# GeisPointService

[![Build Status](https://travis-ci.org/ondrejd/GeisPointService.svg)](https://travis-ci.org/ondrejd/GeisPointService)

PHP implementace klienta pro webovou službu [GeisPoint](http://www.geispoint.cz/).

>> __For non-Czech visitors__: Since __GeisPoint__ web service is located in Czech Republic and serves mainly Czech users all documentation is written directly in Czech - anyway code self is commented in English.


## Instalace

__TBD__

## Použití

Nejprve rychlý příklad:

```php
<?php
require 'vendor/autoload.php';

$gpsrv = new \GeisPointService\Service();
$regions = $gpsrv->getRegions();
var_dump($regions);

// `var_dump` by mel vypsat pole podobne nasledujicimu (zkraceno):
//array(14) {
//  [19] =>
//  class GeisPointService\Region#18 (2) {
//    public $id_region =>
//    int(19)
//    public $name =>
//    string(12) "Hl. m. Praha"
//  }
//  [27] =>
//  class GeisPointService\Region#19 (2) {
//    public $id_region =>
//    int(27)
//    public $name =>
//    string(19) "Středočeský kraj"
//  }
//  ...
//}
```

### Konfigurace

Konstruktor třídy `\GeisPointService\Service` přijíma jako jedinný argument pole s nastavením klienta. Možnosti konfigurace jsou následující:

#### Přehled nastavení

__TBD__

#### Příklad nastavení

__TBD__