<div align="center">
  <h3 align="center">Filament Viewable</h3>
  <p align="center">
    View statistics for your Filament panel, built on Eloquent Viewable
  </p>
  <br/>
  <p align="center">
      <a href="https://packagist.org/packages/cyrildewit/filament-viewable"><img alt="Latest Version" src="https://img.shields.io/packagist/v/cyrildewit/filament-viewable"/></a>
      <a href="https://packagist.org/packages/cyrildewit/filament-viewable"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/cyrildewit/filament-viewable"/></a>
      <a href="https://github.com/cyrildewit/filament-viewable/actions"><img alt="GitHub Actions Workflow Status" src="https://img.shields.io/github/actions/workflow/status/cyrildewit/filament-viewable/tests.yml?label=Tests"/></a>
      <a href="https://packagist.org/packages/cyrildewit/filament-viewable"><img alt="License" src="https://img.shields.io/packagist/l/cyrildewit/filament-viewable"/></a>
      <a href="https://codecov.io/gh/cyrildewit/filament-viewable"><img alt="Coverage" src="https://img.shields.io/codecov/c/github/cyrildewit/filament-viewable.svg"/></a>
  </p>
</div>
<hr/>
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li><a href="#introduction">Introduction</a></li>
    <li><a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#version-compatibility">Version Compatibility</a></li>
        <li><a href="#installation">Installation</a></li>
        <li><a href="#preparing-your-models">Preparing your models</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a>
      <ul>
        <li><a href="#registering-the-plugin">Registering the plugin</a></li>
        <li><a href="#translations">Translations</a></li>
      </ul>
    </li>
    <li><a href="#changelog">Changelog</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#credits">Credits</a></li>
  </ol>
</details>

## Introduction

**Filament Viewable** brings the view statistics of [Eloquent Viewable](https://github.com/cyrildewit/eloquent-viewable)
into your [Filament](https://filamentphp.com) panel. You spend a few minutes setting it up, and the people who use the
panel can see which records get viewed, without asking you for numbers.

The plugin reads views through the core package. Whatever the core is configured with, such as rollups or caching,
applies to the panel as well, so a large `views` table stays fast to read.

### Quick Example

```php
use CyrildeWit\FilamentViewable\ViewablePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(ViewablePlugin::make());
}
```

### Key Features

The plugin is in development towards its first release. These are planned for 1.0:

- An **install command** that makes your models viewable and shows where to record views
- A sortable **views column** with total or unique views over any period
- A sortable **trending column** that ranks records by views weighed by their age
- A **views filter** for records viewed in the last days, or never viewed
- A **views overview widget** for a record's view or edit page
- **English and Dutch** translations

## Getting Started

### Version Compatibility

| Package Version                                                              | Filament | Eloquent Viewable | Laravel | PHP  |
|------------------------------------------------------------------------------|----------|-------------------|---------|------|
| [1.x](https://packagist.org/packages/cyrildewit/filament-viewable#1.x-dev)   | 5.x      | 9.x               | 13.x    | 8.5+ |

Older Filament majors are not supported. Each plugin major supports one Filament major.

### Installation

Install the plugin via Composer. It pulls in Eloquent Viewable as well:

```bash
composer require cyrildewit/filament-viewable
```

Then publish and run the migration of Eloquent Viewable, if your application does not have its `views` table yet:

```bash
php artisan vendor:publish --provider="CyrildeWit\EloquentViewable\EloquentViewableServiceProvider" --tag="migrations"
php artisan migrate
```

### Preparing your models

A model shows up in the panel once it implements `Viewable` and uses the `InteractsWithViews` trait. Views are
recorded on your public site, not in the panel, through `views($model)->record()`, the `views` route middleware or
the `@viewsBeacon` directive. The
[Eloquent Viewable documentation](https://github.com/cyrildewit/eloquent-viewable#usage) explains each of them.

## Usage

### Registering the plugin

Register the plugin in your panel provider:

```php
use CyrildeWit\FilamentViewable\ViewablePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(ViewablePlugin::make());
}
```

### Translations

The plugin ships with English and Dutch translations. To change them, or to add another language, publish them to
`lang/vendor/filament-viewable`:

```bash
php artisan vendor:publish --provider="CyrildeWit\FilamentViewable\FilamentViewableServiceProvider" --tag="translations"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- **Cyril de Wit** - _Author_ - [cyrildewit](https://github.com/cyrildewit)

See also the list of [contributors](https://github.com/cyrildewit/filament-viewable/graphs/contributors) who
participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
