Lullaby
------

Install
-------
```bash
composer require sergiors/lullaby
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
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerApps()
    {
        return [
            new Fluffy()
        ];
    }
}
```

In your index file
```php
$app = new Acme\Acme\AppKernel('dev', __DIR__);
$app->run();
```

License
------
MIT
