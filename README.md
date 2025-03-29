<p align="center">
  <a href="https://www.meanify.co?from=github&lib=laravel-permissions">
    <img src="https://meanify.co/assets/core/img/logo/png/meanify_color_dark_horizontal_02.png" width="200" alt="Meanify Logo" />
  </a>
</p>

# Meanify Code Review

This package provides a centralized code review standard for all Meanify projects. It includes:

- ✅ Laravel Pint
- ✅ PHP_CodeSniffer (PHPCS)
- ✅ PHPStan
- ✅ PHPArkitect

---

## 🚀 Installation

In your project:

1. Add the repository to `composer.json`:

```json
"repositories": [
  {
    "type": "vcs",
    "url": "git@github.com:meanify/code-review.git"
  }
]
```

2. Require it as dev dependency:

```bash
composer require meanify/code-review --dev
```

---

## 🛠 Usage

From your project root, run:

```bash
/vendor/meanify-co/meanify-code-review/run.sh
```

---

## ✅ Rules Included

### 🔹 Laravel Pint

| Rule                             | Description                                      | Example (✅ Good / ❌ Bad)                              |
|----------------------------------|--------------------------------------------------|--------------------------------------------------------|
| `indent`                         | Use tab indentation                              | ✅ `\tfoo()`<br>❌ `    foo()`                          |
| `array_syntax`                   | Short syntax arrays                              | ✅ `[1, 2]`<br>❌ `array(1, 2)`                         |
| `binary_operator_spaces`         | Align equals/operators                           | ✅ `foo  = 1;`<br>❌ `foo =  1;`                        |
| `trailing_comma_in_multiline`   | No trailing comma in multi-line                  | ✅ `[1, 2]`<br>❌ `[1, 2, ]`                            |
| `ordered_imports`               | Sort `use` statements alphabetically             | ✅ `use A; use B;`<br>❌ `use B; use A;`               |
| `single_quote`                  | Use single quotes                                | ✅ `'text'`<br>❌ `"text"`                             |
| `braces`                        | Compact braces style                             | ✅ `if ($x) {}`<br>❌ `if ($x) 
| `method_argument_space`         | One arg per line in multi-line calls             | ✅ `foo(
| `phpdoc_trim`                   | Remove empty lines in PHPDoc                     | ✅ `/** Foo */`<br>❌ `/**\n * Foo\n */`              |

### 🔹 PHP_CodeSniffer

| Rule                                        | Description                                            | Example (✅ Good / ❌ Bad)                              |
|---------------------------------------------|--------------------------------------------------------|--------------------------------------------------------|
| Static property naming                     | Must be UPPER_SNAKE_CASE                               | ✅ `static $MAX_SIZE`<br>❌ `static $maxSize`          |
| Variable naming                            | Must be lower_snake_case                               | ✅ `$user_name`<br>❌ `$userName`                      |
| One class per file                         | Only one class/interface/trait per file                | ✅ `class A {}`<br>❌ `class A {} class B {}`          |
| Disallowed functions                       | Ban `sizeof`, `print`, `die`, etc.                     | ✅ `count()`<br>❌ `sizeof()`                          |
| Max line length                            | Max 120 characters per line                            | ✅ `echo "text";`<br>❌ very long line exceeding limit |
| Short array syntax                         | Enforce `[]` instead of `array()`                      | ✅ `[1, 2]`<br>❌ `array(1, 2)`                         |
| Cast/Operator spacing                      | Enforce space after cast and around operators          | ✅ `(int) $a + 1`<br>❌ `(int)$a+1`                    |
| One argument per line                      | For multi-line function calls                          | ✅ `foo(
| No underscore prefix for private members   | No `_` for private props or methods                    | ✅ `$value`<br>❌ `$_value`                            |

### 🔹 PHPArkitect

| Rule                         | Description                                                   |
|------------------------------|---------------------------------------------------------------|
| Controllers naming           | Must reside in `App\Http\Controllers` and end with `Controller` |
| Locators naming              | Must reside in `App\Http\Locators` and end with `Locator`       |
| Services naming              | Must reside in `App\Services` and end with `Service`            |
| Jobs naming                  | Must reside in `App\Jobs` and end with `Job`                    |
| Commands naming              | Must reside in `App\Console\Commands` and end with `Command`    |
| Domain isolation             | `App\Domain` classes must not depend on external namespaces     |

---

## 👨‍💻 Contributing

You can extend this package by:
- Adding new sniffs in `src/Review/Sniffs/`
- Updating Pint or PHPStan config files
- Proposing new architectural rules

---

## 📄 License

MIT