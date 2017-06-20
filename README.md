# WP Deprecated Code Scanner [![Build Status](https://travis-ci.org/JDGrimes/wp-deprecated-code-scanner.svg?branch=master)](https://travis-ci.org/JDGrimes/wp-deprecated-code-scanner)

Scans for all deprecated functions in a WordPress plugin, theme, or WordPress core.
Note that it scans for the functions themselves, *not* usages.

## Requirements

- PHP 5.5+

## Usage

```bash
wpdcs run /path/to/scan
```

Example output:

```markdown
## 1.2.3
- `A::b()`

## 4.5
- `c()` (use `d()` instead)

## 4.8.0
- `a()`
```
