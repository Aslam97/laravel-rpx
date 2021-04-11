# Laravel Bank RPX

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/aslam/laravel-rpx.svg?style=flat-square)](https://packagist.org/packages/aslam/laravel-rpx)

The Laravel RPX package is meant to integrate your Application with RPX Courier API. For clearer and more complete documentation, please visit the official website [API PPX](http://api.rpxholding.com/)

## Features

This package provides tools for the following, and more:

- Public Customer
- Customer Account Number

## Intallation

You can install the package via composer.

```bash
composer require aslam/laravel-rpx
```

## Configuration

To get started. you should publish the `config/rpx.php` config file with:

```bash
php artisan vendor:publish --provider="Aslam\Rpx\Providers\RpxServiceProvider"
```

## Response

The API method returns an instance of `\Aslam\Response\Response`, which provides a variety of methods that may be used to inspect the response:

```php
method()->body() : string;
method()->toJson() : array|mixed;
method()->collect() : "\Illuminate\Support\Collection";
method()->status() : int;
method()->ok() : bool;
method()->successful() : bool;
method()->failed() : bool;
method()->serverError() : bool;
method()->clientError() : bool;
method()->header($header) : string;
method()->headers() : array;
```

## Usage

#### Public Customer

```php
/**
 * Get all province
*/
$getProvince = rpx()->getProvince()->toJson();

/**
 * Get city
 *
 * @param string|null $province
*/
$getCity = rpx()->getCity()->toJson();

$getService = rpx()->getService()->toJson();

$getOrigin = rpx()->getOrigin()->toJson();

$getDestination = rpx()->getDestination()->toJson();

/**
 * @param string origin
 * @param string destination
 * @param string|null service type
 * @param string|float|null weight
 * @param string|float|null discount
 */
$getRates = rpx()->getRates('JAK', 'DPS', 'PSR', '1', '50')->toJson();

/**
 * @param string origin postal code
 * @param string destination postal code
 * @param string|null service type
 * @param string|float|null weight
 * @param string|float|null discount
 */
$getRatesPostalCode = rpx()->getRatesPostalCode('12310', '12310')->toJson();

/**
 * @param string awb
 */
$getTrackingAWB = rpx()->getTrackingAWB('100055295410')->toJson();

/**
 * @param string|null city_id
 * @param string|null cod area
 * @param string|null service type
 */
$getPostalCode = rpx()->getPostalCode('JAK', null, 'RGP')->toJson();

/**
 * @param string awb
 */
$getAWBbyReference = rpx()->getAWBbyReference('123456789')->toJson();
```

### Customer Account Number

```php
/**
 * @param string trackdate from
 * @param string trackdate to
 */
$getRevenue = rpx()->withAccountNumber('234098705')->getRevenue('2018-01-01', '2018-02-01')->toJson();

/**
 * @param string service type
 * @param string origin
 * @param string destination
 * @param float|null weight
 * @param float|null disc
 */
$getCustumerRates = rpx()->getCustumerRates(null, 'JAK', 'JAK', 1, 20)->toJson();

$sendShipmentData = rpx()->sendShipmentData([
    'awb' => '',
    'package_id' => '56849',
    'order_type' => 'MP',
    'order_number' => '101010',
    'service_type_id' => 'RGP',
    'shipper_account' => '234098705',
    'shipper_name' => 'Mahkotababy',
    'shipper_company' => 'Mahkotababy',
    'shipper_address1' => 'Jl. RS Fatmawati No. 17',
    'shipper_address2' => '',
    'shipper_kelurahan' => 'Kemayoran',
    'shipper_kecamatan' => 'Gandaria Selatan',
    'shipper_city' => 'CILANDAK',
    'shipper_state' => 'DKI Jakarta',
    'shipper_zip' => '12420',
    'shipper_phone' => '+6285314855952',
    'identity_no' => '',
    'shipper_mobile_no' => '+6281297773820',
    'shipper_email' => '',
    'consignee_account' => '',
    'consignee_name' => 'dedeh',
    'consignee_company' => '',
    'consignee_address1' => 'apotek marga mulyaAlamat kp pasarRtx2Frw 0502 Dssindangkerta',
    'consignee_address2' => '',
    'consignee_kelurahan' => 'Sukamaju',
    'consignee_kecamatan' => 'PAGELARAN',
    'consignee_city' => 'Cianjur',
    'consignee_state' => 'Jawa Barat',
    'consignee_zip' => '43266',
    'consignee_phone' => '+6285314855952',
    'consignee_mobile_no' => '6285314855952',
    'consignee_email' => 'dimas.seputro@gmail.com',
    'desc_of_goods' => 'Oblong panjang isi 4 9-12bln kode 3',
    'tot_package' => '1',
    'actual_weight' => '1',
    'tot_weight' => '1',
    'tot_declare_value' => '1',
    'tot_dimensi' => '1',
    'flag_mp_spec_handling' => 'N',
    'insurance' => 'N',
    'surcharge' => 'N',
    'high_value' => 'N',
    'high_docs' => 'N',
    'electronic' => 'N',
    'flag_dangerous_goods' => 'N',
    'flag_birdnest' => 'N',
    'declare_value' => '91500',
    'dest_store_id' => '',
    'dest_dc_id' => '',
    'widhtx' => '',
    'lengthx' => '',
    'heightx' => '',
    'flight_date' => '',
    'flight_no' => '',
    'remarks' => 'TEST API jangan Dipuckup',
])->toJson();
```
