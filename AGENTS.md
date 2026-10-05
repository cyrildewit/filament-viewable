# Agent instructions

This is the free Filament plugin on top of [`cyrildewit/eloquent-viewable`](https://github.com/cyrildewit/eloquent-viewable),
the core package. The plugin reads views through the core and never queries the `views` table itself.

## Nothing runs on the host

There is no PHP or Composer on the host machine. `php`, `composer`, `vendor/bin/pest` and
`vendor/bin/phpstan` will all fail with "command not found". Do not install them, and do not fall back
to reading config files to work out what a command would have done.

Every command goes through `make`, which runs it in the `composer` container:

```bash
make install            # install dependencies (run once, or after composer.json changes)
make ready              # rector, pint, phpstan, type coverage, tests
make lint               # pint, fixes style in place
make rector             # rector
make test               # the full Pest suite, in parallel and without Xdebug
make test-unit          # tests/Unit
make test-feature       # tests/Feature
make test-arch          # tests/Arch
make test-lint          # pint --test, checks style without fixing
make test-types         # phpstan
make test-type-coverage # type coverage, fails below 100%
make test-coverage      # the suite with coverage, fails below 100%
make workbench          # rebuild the workbench database and publish Filament's assets
make serve              # serve the workbench on http://localhost:8000/admin
```

If `docker compose` complains that the image is missing, run `make build` first.

## Running a subset

The Make targets take no arguments. To pass flags to Pest, call the Composer script directly:

```bash
docker compose run --rm composer test -- --filter=ViewablePlugin
```

## Before you hand work back

Run `make ready`.

CI also enforces 100% line coverage, which `make ready` does not check. New code needs tests covering it;
`make test-coverage` runs the same check locally.

## Where a test belongs

Put a test in `tests/Unit` unless it needs something only a booted application provides: the
container, the database, a panel or a Livewire component. Those go in `tests/Feature`. `tests/Arch`
holds Pest arch expectations about the shape of `src/`.

## The workbench

`workbench/` is a Laravel application that Testbench boots, configured in `testbench.yaml`. It is both
the panel `make serve` opens and the one every feature test runs against, through
`tests/Feature/TestCase.php`. Code in `src/` must never depend on it; an arch test checks that.

The `views` table comes from the core's migration stub, which
`workbench/database/migrations/2026_01_01_000001_create_views_table.php` runs, so a change to the core's
schema reaches the workbench without a copy to keep in step.

## Things that will bite you

The suite runs on SQLite only, by choice. The core already runs its queries against MySQL, MariaDB and
Postgres. Do not add driver legs here to test the core again.

Feature tests share one database per process. `RefreshDatabase` rolls each test back, which does not
reset auto-increment counters, so ids keep climbing from one test to the next. Never assert on a literal
primary key; read the key off the model instead.

Docker Compose reads a root `.env` for variable interpolation. It is gitignored, but do not create one.

Fix PHPStan errors rather than ignoring them.

## Conventions

Commit messages and pull request titles follow Conventional Commits. `CONTRIBUTING.md` has the format, the
allowed types and how to signal a breaking change.

Document behaviour changes in `README.md`, and add an entry to `CHANGELOG.md` under Unreleased.

A feature belongs in this plugin when a developer needs it to wire things up or to work on a resource.
When it answers a question a client asks, it belongs in Pro, which lives in its own private repository.
