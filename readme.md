# Firebird for Laravel

This package adds support for the Firebird PDO Database Driver in Laravel applications.
Originally it was created by Harry Gulliford. Unfortunately, the original package is no longer maintained (doesn't support Laravel 12).
Thank you, Harry, for your work!

## Version Support

- **PHP:** 8.4
- **Laravel:** 12.x
- **Firebird:** 2.5, 3.0, 4.0, 5.0

## Installation

You can install the source package via composer:

```bash
composer require xgrz/firebird-support
```

but at the present time I am fighting to get lsces/firebird-support to actually load.

_The package will automatically register itself._
Is not something I have actually seen happening, and it seems that this may be down to the fact that
webtrees is ONLY using illuminate/database and no the laravel wrapper. 
The quick hack to load the driver is to replace ConnectionFactory.php in vendor/illuminate/database/Connectors with the copy in the extra folder here.
This adds
```
use Xgrz\Firebird\FirebirdConnection;
use Xgrz\Firebird\FirebirdConnector;
```
to the use list and then adds
`'firebird' => new FirebirdConnector,`
to createConnector list and
`'firebird' => new FirebirdConnection($connection, $database, $prefix, $config),`
to createConnection

Declare the connection as you would normally by using `firebird` as the
driver: 
```php
'connections' => [

    'firebird' => [
        'driver'   => 'firebird',
        'host'     => env('DB_HOST', 'localhost'),
        'port'     => env('DB_PORT', '3050'),
        'database' => env('DB_DATABASE', '/path_to/database.fdb'),
        'username' => env('DB_USERNAME', 'sysdba'),
        'password' => env('DB_PASSWORD', 'masterkey'),
        'charset'  => env('DB_CHARSET', 'UTF8'),
        'role'     => null,
    ],

],
```
The location of these settings varies based on the higher level application.

## TODO
I am thinking this is worth moving to FirebirdSQL repo to live with the other firebird extra drivers. 
There are still a few holes that need to be plugged, but so far I have a working webtrees site to replace the phpgedview one and I now I'm ready to hit some of the finer detail.
Testing on older versions of Firebird I will leave to others, and the current autoincrement fields rely on FB5's magic paired with RETURNING to emulate the lastIdentId() in PDO. I think this is the right aproach although I do miss being able to check the generator values, and my ADOdb approach was to create the generator and trigger. Something I've not investigated in illuminate ... yet.

## Limitations
The limitation that the v1.0.x package did not intend to support database migrations has been addresssed and the current build is happily handling the Migration trail for webtrees. The debate on whether this is an improvement over using an update trail which simply builds a clean current schema is ongoing.

## Credits
- [Harry Gulliford](https://github.com/harrygulliford) original laravel-firebird build
- [xGrz](https://github.com/xGrz) V1.0.x of the firebird-support fork

## License
Licensed under the [MIT](https://choosealicense.com/licenses/mit/) license.
