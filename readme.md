# Firebird for Laravel

This package adds support for the Firebird PDO Database in the illuminate package of the Laravel framework. It has been renamed to use illuminate, since it is not necessary to use laravel in order to use the illuminate database module.
Originally it was created by Harry Gulliford. Unfortunately, the original package is no longer maintained (doesn't support Laravel 12).
Thank you, Harry, for your work!
It was forked to firebird-support under xGrz who brought it up to work with Laravel 12 and I could ask to push the later changes back into that fork, but it seemed easier to follow the annoying composer fashion and rename the driver again if only so that it can be registered with https://packagist.org/ ... so that we can actually use it going forward

## Version Support

- **PHP:** Only currently tested with 8.4, but should work back to 8.2.
- **Laravel:** 12.x
- **Firebird:** Only tested with 5.0 and currently it does rely on the automagic incremental fields that appeared with 5.0

## Installation

You can install the source package via composer:

```bash
composer require lsces/illuminate-firebird
```
but at some point I would like to see it migrate under the FirebirdSQL umberella.

_The package will automatically register itself._
And that is the basis on which this switch of name is being undertaken! Initial problems with loading the driver into illuminate have now been sorted and https://github.com/lsces/webtrees/blob/main/app/DB.php#L126 shows how to use illuminate's resolverFor function to to add it directly rather than relying on the automatic registration that FirebirdServiceProvider should action if the application is using the whole laravel frameowrk.

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

The current testing has been carried out in [webtrees](https://dev.webtrees.net/) which is not using Laravel, and only the illuminate/database package (having upgraded from ADOdb previously). 

## TODO
I am thinking this is worth moving to FirebirdSQL repo to live with the other firebird extra drivers. 
There are still a few holes that need to be plugged, but so far I have a working webtrees site to replace the phpgedview one and I now I'm ready to hit some of the finer detail.
Testing on older versions of Firebird I will leave to others, and the current autoincrement fields rely on FB5's magic paired with RETURNING to emulate the lastIdentId() in PDO. I think this is the right aproach although I do miss being able to check the generator values, and my ADOdb approach was to create the generator and trigger. Something I've not investigated in illuminate ... yet.

## Limitations
The limitation that the v1.0.x firebird-support package did not intend to support database migrations has been addresssed and the current build is happily handling the Migration trail for webtrees. The debate on whether this is an improvement over using an update trail which simply builds a clean current schema is ongoing.

## Credits
- [Harry Gulliford](https://github.com/harrygulliford) original laravel-firebird build
- [xGrz](https://github.com/xGrz) V1.0.x of the firebird-support fork
- [lsces](https://github.com/lsces) V1.1.x fork of firebird-support ported to here and tested in webtrees.

## License
Licensed under the [MIT](https://choosealicense.com/licenses/mit/) license.
