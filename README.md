Lullaby
------

Install
-------
```bash
composer require sergiors/lullaby "dev-master"
```

How to use
----------

Something like this
```php
namespace Acme\Acme\Apps\Fluffy;

use Sergiors\Lullaby\Application\Application;

class Fluffy extends Application
{
}
```

```php
namespace Acme\Acme;

use Sergiors\Lullaby\Kernel;

class AppKernel extends Kernel
{
    public function registerApps()
    {
        return [
            new Fluffy()
        ];
    }
    
    public function registerProviders()
    {
        return [];
    }
}
```

In your index file
```php
$env = 'dev';
$debug = false;
$rootDir = __DIR__;

$app = new Acme\Acme\AppKernel($env, $debug, $rootDir);
$app->run();
```

License
------
MIT
