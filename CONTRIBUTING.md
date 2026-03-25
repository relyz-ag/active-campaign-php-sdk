# Contributing

Thank you for considering a contribution to the ActiveCampaign PHP SDK.

## Development Setup

1. Fork and clone the repository
2. Install dependencies: `composer install`
3. Verify the test suite passes: `vendor/bin/phpunit`

## Running Quality Checks

```bash
# Tests
vendor/bin/phpunit

# Static analysis (level 8)
vendor/bin/phpstan analyse

# Code style (PSR-12)
vendor/bin/php-cs-fixer fix --dry-run --diff

# Fix code style automatically
vendor/bin/php-cs-fixer fix
```

## Pull Request Guidelines

- **Branch from `main`** and target `main` with your PR.
- **Write tests** for every new feature or bug fix.
- **Run the full suite** before submitting: tests, PHPStan, and PHP-CS-Fixer must all pass.
- **One logical change per PR.** Split unrelated changes into separate pull requests.
- **Follow PSR-12** coding standards. The `.php-cs-fixer.php` configuration enforces this.

## Code Conventions

- All files must declare `strict_types=1`.
- Models are immutable (`readonly` properties) with a `fromArray()` factory method.
- Resource methods must return typed models, never raw arrays.
- Method names use camelCase (PSR-12). The `Raw` suffix indicates methods accepting unstructured arrays (e.g., `createRaw()`).
- Use named arguments for readability.

## Commit Messages

Follow [Conventional Commits](https://www.conventionalcommits.org/):

- `feat:` new feature
- `fix:` bug fix
- `refactor:` code change that neither fixes a bug nor adds a feature
- `docs:` documentation only
- `test:` adding or updating tests
- `chore:` maintenance (CI, dependencies, tooling)

## Reporting Bugs

Open an issue with:

1. PHP version and SDK version
2. Minimal code to reproduce the problem
3. Expected vs. actual behavior
