# Homeful Common Package

The `Homeful\Common` package is a utility package that contains reusable helpers, constants, enumerations, and abstract types used across the Homeful system. It aims to promote consistency and reduce duplication of logic in other domain-specific packages such as Mortgage, Payment, Property, and Borrower.

---

## 📦 Contents

- **Utilities**
- **Classes**
- **Enumerations**

---

## 🧰 Utilities

### `documents_path(?string $path = null): string`
Returns the path to the `/resources/documents` directory.

```php
documents_path(); // /resources/documents
documents_path('legal/contract.pdf'); // /resources/documents/legal/contract.pdf
```

---

### `formatted_age(DateTime $born, ?DateTime $reference = null): string`
Returns a human-readable age string based on birthdate.

```php
formatted_age(new DateTime('1990-05-23')); // "33 years, 10 months and 3 days old"
```

---

### `doc_stamps(mixed $value): float`
Returns the documentary stamp fee based on property value.

```php
doc_stamps(450000); // 50.0
```

---

### `filter_trim_recursive_array(array $array): array`
Trims strings and filters empty values recursively in nested arrays.

---

### `dot_shift(&$dot_notation): string`
Shifts off the first key in a dot notation string.

```php
$key = dot_shift($dot = "property.name"); // $key = "property", $dot = "name"
```

---

### `titleCase(?string $text, array $exclusions = []): string`
Applies `Str::title()` but preserves Roman numerals and exceptions.

```php
titleCase('juan dela cruz ii'); // Juan Dela Cruz II
```

---

### `validateJson(string $json): bool`
Returns true if a valid JSON string.

---

### `resolveOptionalCollection(DataCollection|Optional|null $collection): Collection`
Handles resolution of Spatie `DataCollection` and `Optional`.

---

### `array_when(array $array, $condition, callable $callback): array`
Conditionally apply a transformation on an array.

```php
array_when([1,2,3], false, fn($arr) => array_map(fn($x) => $x * 2, $arr)); // [1,2,3]
```

---

### `convertNumberToWords(float $value): string`
Converts a float value to words.

```php
convertNumberToWords(1500.75); // ONE THOUSAND FIVE HUNDRED AND 75/100
```

---

## 📚 Core Classes

### `Homeful\Common\Classes\Input`

A collection of constants used for data keys in form input and parameter arrays. Examples include:

- `Input::TCP` - Total Contract Price
- `Input::PERCENT_DP` - Percent Down Payment
- `Input::BP_TERM` - Balance Payment Term

Usage:

```php
$params = [
    Input::TCP => 2500000,
    Input::PERCENT_DP => 0.05,
];
```

---

### `Homeful\Common\Classes\Assert`

A collection of constants used to assert derived or calculated values in computations:

- `Assert::LOAN_AMOUNT`
- `Assert::INCOME_REQUIREMENT`
- `Assert::LOAN_AMORTIZATION`

Used commonly in unit tests:

```php
expect($mortgage->getLoan()->getPrincipal()->inclusive()->compareTo($params[Assert::LOAN_AMOUNT]))->toBe(Amount::EQUAL);
```

---

## 🧮 AmountCollectionItem

Base class representing any item with:

- a name
- a `Price` value
- deductible flag
- a tag

Used as a base for:

- `AddOnFeeToPayment`
- `DeductibleFeeFromPayment`

---

## 📈 Enumerations

### `UploadFile`
Maps file-related attributes to suffixes for Media Library collections.

```php
UploadFile::Image->suffix(); // 'images'
UploadFile::deriveCollectionNameFromAttribute('propertyImage'); // 'property-images'
```

---

### `WorkArea`
Represents whether a user operates in a Highly Urbanized City or Region.

```php
WorkArea::fromRegional(true); // WorkArea::REGION
WorkArea::default(); // WorkArea::HUC
```

---

## ✅ Example Usage

```php
use Homeful\Common\Classes\Input;
use Homeful\Common\Classes\Assert;

$params = [
    Input::TCP => 2500000,
    Input::PERCENT_DP => 0.05,
    Assert::LOAN_AMOUNT => 2375000.0,
];

expect($params[Assert::LOAN_AMOUNT])->toBe(2375000.0);
```

---

## 📂 Path Resolution

```php
documents_path('mortgage/terms.pdf'); 
// => /resources/documents/mortgage/terms.pdf
```

---

## 🧪 Testing Helpers

Used extensively in test scripts to:

- Assert expected results via `Assert`
- Pass parameters using `Input`
- Use `formatted_age`, `doc_stamps`, etc.

---

Behold, a new you awaits. ✨
