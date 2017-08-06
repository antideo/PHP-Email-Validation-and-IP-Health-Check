# Antideo PHP Library
PHP library that makes querying Antideo's REST API easy.

How to use:

## Import Antideo and create new instance

``` php
include_once('Antideo.class.php');
$antideo = new Antideo();
```

## Get email address info
Query any email address and get its SPAM & SCAM scores. You will also be able to determine if given email is comming from free provider like Yahoo and GMAIL, or is part of disposable/temporary email addres network/providers.

More details: [Email endpoint](http://antideo.com/documentation/#email-address-queries)

``` php
try {
    $emailResult = $antideo->email('john.doe@example.com');
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage(), "\n";
}
```


## Get IP address WHOIS info and category
Query any IP address to see its WHOIS details.
* Organisation name
* Organisation ASN
* Organisation country
* IP Registry (arin, afrinic, apnic, ripe, lacnic) 
* Category - (Mobile, Hosting, Bank, Government, Education)

More details: [IP Info endpoint](http://antideo.com/documentation/#ip-info)

``` php
try {
    $ipInfo = $antideo->ipInfo('1.2.3.4');
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage(), "\n";
}
```

## Get IP address health details
Queries IP address health and returns the following:
* Toxic
* Spam
* Proxy (if is know TOR project exit node, Anonimous or Open proxy etc.)

More details: [IP Info endpoint](http://antideo.com/documentation/#health)

``` php
try {
    $ipHealth = $antideo->ipHealth('1.2.3.4');
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage(), "\n";
}
```

## Get IP address location
Provides the following geolocation details for any IP address.
* Latitude
* Longitude
* Accuracy (from 1 to 1000)
* City
* Country
* Country code ([ISO code])(https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2))

More details: [IP Info endpoint](http://antideo.com/documentation/#location)

``` php
try {
    $ipLocation = $antideo->ipLocation('1.2.3.4');
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage(), "\n";
}
```


## Exception handling
If for any reason the API query fails you will get an exception, so it's very important to handle them in order to prevent unecpected behaviour. As demonstrated in the examples above all exceptions are catched. To grab the HTTP response code from the exceptions use `$e->getCode()`
