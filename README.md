# Dotenv editing

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tal7aouy/dotenv.svg?style=flat-square)](https://packagist.org/packages/tal7aouy/dotenv)
[![Total Downloads](https://img.shields.io/packagist/dt/tal7aouy/dotenv.svg?style=flat-square)](https://packagist.org/packages/tal7aouy/dotenv)
![run-tests](https://github.com/tal7aouy/dotenv/workflows/run-tests/badge.svg)

This package provides some basic tools for editing dotenv files.

## Installation
You can install the package via composer:

```bash
composer require tal7aouy/dotenv
```

## Usage

### Add a section
Given we have an existing file at `base_path('.env')`.
We can add a new section to the existing configuration file.
``` php
$dotenv = new Dotenv();

$dotenv->load(base_path('.env'));
$dotenv->heading('DB_CONNECTION');
$dotenv->set('DB_CONNECTION', 'mysql');
$dotenv->set('DB_HOST', '127.0.0.1');
$dotenv->set('DB_PORT', '3306');
$dotenv->set('DB_DATABASE', 'demo');
$dotenv->set('DB_USERNAME', 'root');
$dotenv->set('DB_PASSWORD', '');
$dotenv->getEnv('DB_DATABASE'); // demo
$dotenv->save();
```

This will result in the following changes.
```
APP_KEY=supersecret

# DB_CONNECTION
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=demo
DB_USERNAME=root
DB_PASSWORD=
```

## Testing
```bash
> composer test
```

## Code Style
StyleCI will apply the [Laravel preset](https://docs.styleci.io/presets#laravel).

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security related issues, please email oss@tjmiller.co instead of using the issue tracker.


## Credits
- [Mhammed Talhaouy](https://github.com/tal7aouy)

## License
Please see [License File](LICENSE.md) for more information.
