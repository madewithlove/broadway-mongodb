# madewithlove/broadway-mongodb

[![Build Status](http://img.shields.io/travis/madewithlove/broadway-mongodb.svg?style=flat-square)](https://travis-ci.org/madewithlove/broadway-mongodb)
[![Latest Stable Version](http://img.shields.io/packagist/v/madewithlove/broadway-mongodb.svg?style=flat-square)](https://packagist.org/packages/madewithlove/broadway-mongodb)
[![Total Downloads](http://img.shields.io/packagist/dt/madewithlove/broadway-mongodb.svg?style=flat-square)](https://packagist.org/packages/madewithlove/broadway-mongodb)
[![Scrutinizer Quality Score](http://img.shields.io/scrutinizer/g/madewithlove/broadway-mongodb.svg?style=flat-square)](https://scrutinizer-ci.com/g/madewithlove/broadway-mongodb/)
[![Code Coverage](http://img.shields.io/scrutinizer/coverage/g/madewithlove/broadway-mongodb.svg?style=flat-square)](https://scrutinizer-ci.com/g/madewithlove/broadway-mongodb/)

A [MongoDB](https://www.mongodb.org/) driver for [Broadway](https://github.com/qandidate-labs/broadway) based on [`mongodb/mongodb`](https://github.com/mongodb/mongo-php-library).

## Goals

## Install

This package has the same requirements as [`mongodb/mongodb`](https://github.com/mongodb/mongo-php-library).

```bash
$ pecl install mongodb
$ echo "extension=mongodb.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`
```

Via Composer

``` bash
$ composer require madewithlove/broadway-mongodb
```

## Usage

### `MongoDBClientFactory`

This package ships with a factory to build a `MongoDB\Client`.

#### Using default values

```php
$factory = new MongoDBClientFactory();
$client = $factory->create(['database' => 'foobar']);
```

#### Creating a client for a specific host and port

```php
$factory = new MongoDBClientFactory();
$client = $factory->create([
     'database' => 'foobar',
     'host' => 'my_host',
     'port' => 3000,
]);

// Or alternatively

$client = $factory->create([
     'database' => 'foobar',
     'host' => 'my_host:3000',
]);
```
#### Creating a client for multiple hosts

The `hosts` option can also be an array for multiple hosts

```php
$factory = new MongoDBClientFactory();
$client = $factory->create([
     'database' => 'foobar',
     'host' => ['my_host_1', 'my_host_2'],
]);
```

#### Creating a client for with username and password

If you have to authenticate to your MongoDB database you can pass the username and password

```php
$factory = new MongoDBClientFactory();
$client = $factory->create([
     'database' => 'foobar',
     'username' => 'foo',
     'password' => 'bar',
]);
```

#### Creating a client using a dsn string

Alternatively you can pass a dsn string and it will be used to connect

```php
$factory = new MongoDBClientFactory();
$client = $factory->create([
     'dsn' => 'mongodb://foo:200/foo',
]);
```

### `ReadModel`

This package ships with a basic `MongoDBRepository` class you can either use directly or extend to build your own repositories.

The easiest way to create a repository for your model is by using the `ReadModel\Factory`:

 ```php

 $mongDBClientFactory = new MongoDBClientFactory();
 $client = $factory->create(['database' => 'testing']);

 $factory = new ReadModel\Factory(
    new SimpleInterfaceSerializer(),
    $client
);

// 'my_projection' is the collection that will be used.
$repository = $factory->create('testing', 'my_projection');
 ```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
