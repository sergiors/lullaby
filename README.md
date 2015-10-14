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
namespace Acme\Acme;

use Sergiors\Lullaby\Applcation as BaseApplication;
use Symfony\Component\Config\Loader\LoaderInterface;

class Application extends BaseApplication
{
    public function registerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->rootDir.'/app/config_'.$this->environment.'.yml');
    }
}
```

In your index file
```php
$app = new Acme\Acme\Application('dev', __DIR__);
$app->run();
```

License
------
MIT