# Contributing

Thank you for considering contributing to Filament Viewable!

We accept contributions via pull requests on [GitHub]. Please review these guidelines before submitting any pull
requests.

## Guidelines

* Code style is enforced with [Pint](https://laravel.com/docs/pint); run `make lint` before committing.
* One pull request per feature (send multiple if you want to do more than one thing).
* Add tests if you've added something new (ensure that the current tests pass).
* Send a coherent commit history (make sure each individual commit in your pull request is meaningful).
* Document any change in behaviour (make sure the `README.md` is kept up-to-date).
* Strictly follow our [Git Commit Guidelines](#git-commit-guidelines)!
* Please remember that we follow [SemVer](http://semver.org/).

### Git Commit Guidelines

We follow the [Conventional Commits](https://www.conventionalcommits.org/) specification for our git commit messages. A
consistent format keeps the commit history readable and makes it easy to generate the changelog.

#### Commit Message Format

```html
<type>(<scope>): <subject>
<BLANK LINE>
<body>
<BLANK LINE>
<footer>
```

> Any line of the commit message cannot be longer than 100 characters!
> This allows the message to be easier to read on GitHub as well as in various git tools.

##### Type

Must be one of the following:

* **feat:** a new feature
* **fix:** a bug fix
* **style:** changes that do not affect the meaning of the code (white-space, formatting, missing semi-colons, etc.)
* **refactor:** a code change that neither fixes a bug nor adds a feature
* **test:** adding missing tests
* **chore:** changes to the build process or auxiliary tools and libraries such as documentation generation

##### Scope

The scope could be anything specifying the place of the commit change.

##### Subject

The subject contains a succinct description of the change:

* use the imperative, present tense: "change" not "changed" nor "changes"
* don't capitalize first letter
* no dot (.) at the end

##### Body

Just as in the **subject**, use the imperative, present tense: "change" not "changed" nor "changes" The body should
include the motivation for the change and contrast this with previous behavior.

##### Footer

The footer is optional and may contain one or more footers, each on its own line. Use it to reference GitHub issues
that this commit closes (e.g. `Closes #123`) and to describe breaking changes.

A breaking change must be signalled in one of two ways:

* append a `!` after the type/scope, e.g. `feat(views)!: drop support for Laravel 10`, or
* start a footer line with `BREAKING CHANGE:` followed by a description of what changed.

Both may be combined. The description explains what breaks and what community users must do to adapt, and is
highlighted in the changelog.

```
feat(views)!: drop support for Laravel 10

BREAKING CHANGE: the minimum supported Laravel version is now 11. Upgrade your application before updating.
```

## Local Development

Development runs entirely inside Docker, so you don't need PHP or [Composer](https://getcomposer.org/) installed
locally. Everything is driven through the `Makefile`. Run `make` (or `make help`) at any time to see the available
targets.

Before doing anything else, build the images and install the dependencies:

```bash
make build
make install
```

By default the images use PHP 8.5. To build against a different version, pass it through `ARGS`:

```bash
make build ARGS="--build-arg PHP=8.5"
```

### Common tasks

| Command                   | Description                                                                 |
|---------------------------|-----------------------------------------------------------------------------|
| `make ready`              | Run Rector and Pint, then the static analysis, type coverage and test suite |
| `make lint`               | Fix code style with [Pint](https://laravel.com/docs/pint)                   |
| `make rector`             | Run [Rector](https://getrector.com/)                                        |
| `make test`               | Run the [Pest](https://pestphp.com/) test suite                             |
| `make test-arch`          | Run only the architecture tests                                             |
| `make test-unit`          | Run only the unit tests                                                     |
| `make test-feature`       | Run only the feature tests                                                  |
| `make test-lint`          | Check code style without fixing it                                          |
| `make test-types`         | Run the [PHPStan](https://phpstan.org/) static analysis                     |
| `make test-type-coverage` | Run the type coverage check (fails below 100%)                              |
| `make test-coverage`      | Run the suite with line coverage (fails below 100%)                         |

Every target in that table maps onto the Composer script of the same name, with `-` where the script has `:`, run in
the `composer` container. `make test-coverage` runs `docker compose run --rm composer test:coverage`. If you prefer,
you can invoke those scripts directly:

```bash
docker compose run --rm composer test
```

The suite is split in three. Tests in `tests/Arch` are Pest arch expectations about the source tree. Tests in
`tests/Unit` extend plain PHPUnit and never boot a Laravel application, so they run in well under a second. Tests in
`tests/Feature` extend the Testbench test case and boot the workbench panel on an in-memory SQLite database. Put a
test in `tests/Feature` when it needs the container, a database, a panel or a Livewire component.

The suite runs on SQLite only. The queries behind the columns, filter and widget are the core's, and
[Eloquent Viewable](https://github.com/cyrildewit/eloquent-viewable) runs those against every database driver it
supports.

### Workbench

The `workbench` directory holds a small Laravel application for trying the plugin in a browser: a Filament panel at
`/admin` with the plugin registered, a `Post` resource, and a seeder that spreads views over the past 90 days.

| Command          | Description                                                         |
|------------------|---------------------------------------------------------------------|
| `make serve`     | Rebuild the workbench and serve it on http://localhost:8000/admin   |
| `make workbench` | Rebuild the workbench database and publish Filament's assets        |

Sign in as `admin@example.com` with `password`. Set `SERVE_PORT` to use another port on your machine, for example
`make serve SERVE_PORT=8080`. The feature tests boot the same panel, so a resource or page you add to the workbench to
try something out is also there to test against.

When you make a pull request, the tests will be automatically run again
by [GitHub Actions](https://github.com/cyrildewit/filament-viewable/actions).

[GitHub]: https://github.com/cyrildewit/filament-viewable/pulls
