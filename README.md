# Laravel Password Policies

## Installation

Use composer to install the package:

```bash
composer require stobys/laravel-password-policies
```

## Configuration

In order to start, you have to publish the config file, and the migration:

```bash
php artisan vendor:publish --provider="SylveK\LaravelPasswordPolicies\LaravelPasswordPoliciesServiceProvider"
```

Modify the config file according to your project, then migrate the database

```bash
php artisan migrate
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

I was inspired, and take some from those packages :
- [infinitypaul/laravel-password-history-validation](https://github.com/infinitypaul/laravel-password-history-validation)
- [imanghafoori1/laravel-password-history](https://github.com/imanghafoori1/laravel-password-history)
- [ircmaxell/password-policy](https://github.com/ircmaxell/password-policy)
