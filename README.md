<p align="center">
  <a href="https://www.meanify.co?from=github&lib=laravel-permissions">
    <img src="https://meanify.co/assets/core/img/logo/png/meanify_color_dark_horizontal_02.png" width="200" alt="Meanify Logo" />
  </a>
</p>

# 📘 Meanify Code Review

Meanify Code Review is a reusable package that unifies PHP code quality tools for Laravel and general PHP projects.

It includes:
- [Laravel Pint](https://laravel.com/docs/12.x/pint)
- [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
- [PHPArkitect](https://github.com/phparkitect/arkitect)
- Custom Meanify Sniffs and Architecture rules

---

## 🧩 Installation

```bash
composer require meanify-co/meanify-code-review --dev --prefer-source -W
vendor/bin/phpcs --config-set installed_paths vendor/meanify-co/meanify-code-review/src
vendor/bin/phpcs -i  # confirm "Meanify" is listed
```

---

## 🚀 Usage

```bash
vendor/meanify-co/meanify-code-review/run.sh
```

---

## ✅ Rules and Examples

### 🔡 Variable Naming

- Static properties must use `UPPER_SNAKE_CASE`:

```php
public static $MAX_ATTEMPTS;
```

- Non-static variables must use `lower_snake_case`:

```php
$max_attempts;
```

---

### 🏗 Architecture Rules (PHPArkitect)

- Classes inside `App\Http\Controllers` must end with `Controller`:

```php
namespace App\Http\Controllers;

class UserController {}
```

- Classes inside `App\Http\Locators` must end with `Locator`:

```php
namespace App\Http\Locators;

class AdminLocator {}
```

- Classes inside `App\Services` must end with `Service`:

```php
namespace App\Services;

class UserService {}
```

- Classes inside `App\Jobs` must end with `Job`:

```php
namespace App\Jobs;

class SendEmailJob {}
```

- Classes inside `App\Console\Commands` must end with `Command`:

```php
namespace App\Console\Commands;

class SyncDataCommand {}
```

---

### ✅ Code Style Rules (Pint + PHPCS)

- Indentation must use tabs.
- Arrays must use short syntax:

```php
$array = ['a', 'b'];
```

- Binary operators must be aligned:

```php
$total   = 100;
$tax     = 25;
$grand   = $total + $tax;
```

- No trailing commas in multi-line arrays:

```php
[
    'first',
    'second'
]
```

- Enforced order and no unused imports:

```php
use App\Service;
use Illuminate\Support\Str;
```

- Always single quotes for strings unless interpolation or escaping required:

```php
$message = 'Welcome back';
```

- Add blank lines before statements (except `return` if configured).
- Braces are compact:

```php
if ($x) {
    doSomething();
}
```

- Multiline function args:

```php
function example(
    string $a,
    int $b
) {}
```

- PHPDoc is ordered, aligned, indented and trimmed:

```php
/**
 * @param string $name
 * @param int    $age
 */
```

- No superfluous PHPDoc tags:

```php
/** @return void */ // ← Removed if redundant
```

- Single space after semicolon:

```php
for ($i = 0; $i < 10; $i++) {}
```

- `cast` spacing:

```php
(string) $value;
```

- One attribute per line:

```php
private string $name;
private int $age;
```

- One trait per statement:

```php
use HasUuid;
```

- Namespace must be separated by a blank line before and after:

```php
<?php

namespace App\Example;

class Something {}
```

- Use `self::` instead of `$this->` when calling static.

- Use `!=` instead of `<>`.

- Avoid:
    - redundant `else`
    - empty `return`
    - unnecessary `elseif` and curly braces
    - null property initialization
    - unnecessary control structure parentheses

- Always use explicit visibility (`public`, `protected`, `private`).
- Force one class per file.

---


## 🧠 About

Developed and maintained by [Meanify](https://meanify.co) — Software with Purpose.