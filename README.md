<h1 align="center">
  <br>
  <a href="https://semver.madewithlove.com">
    <img src="https://static.madewithlove.com/logo/red/full.png" alt="madewithlove" width="400">
  </a>
  <br><br>
  SemVer
  <br>
</h1>

<h4 align="center">
A SemVer checker tool for Packagist.
</h4>

<div align="center">

![ci](https://github.com/madewithlove/semver/actions/workflows/ci.yml/badge.svg)
[![issues](https://img.shields.io/github/issues/madewithlove/semver)](https://github.com/madewithlove/semver/issues)
[![pull requests](https://img.shields.io/github/issues-pr/madewithlove/semver)](https://github.com/madewithlove/semver/pulls)
[![contributors](https://img.shields.io/github/contributors/madewithlove/semver)](https://github.com/madewithlove/semver/graphs/contributors)
[![contributions](https://img.shields.io/badge/contributions-welcome-brightgreen)](#contributing)

</div>

<div align="center">
  <a href="#about">About</a> •
  <a href="#prerequisites">Prerequisites</a> •
  <a href="#installation">Installation</a> •
  <a href="#tests">Tests</a> •
  <a href="#contributing">Contributing</a>
</div>

<div align="center">
  <sub>Built with :heart:︎ and :coffee: by heroes at <a href="https://madewithlove.com">madewithlove</a>.</sub>
</div>

## About

This is the repository for the SemVer checker tool hosted at [semver.madewithlove.com](https://semver.madewithlove.com).

### Tech Stack

- [Laravel](https://laravel.com)
- [Laravel Livewire](https://laravel-livewire.com)
- [PHPUnit](https://phpunit.de)
- [Tailwind CSS](https://tailwindcss.com)

## Prerequisites

- [Git](https://git-scm.com)
- [PHP 8.0+](https://www.php.net)
- [Composer](https://getcomposer.org)

## Installation

**1. Clone the repository:**

```bash
git clone git@github.com:madewithlove/semver.git
```

**2. Go to the project folder:**

```bash
cd semver
```

**3. Install the dependencies:**

```bash
composer install
```

**4. Create a copy of `.env.example`:**

```bash
cp .env.example .env
```

**5. Set the application key:**

```bash
php artisan key:generate
```

**6. Start the PHP development server:**

```bash
php artisan serve
```

## Tests

Run the following command:

```bash
php artisan test
```

## Contributing

Contributing to this repository is both appreciated and encouraged. If you have any specific questions, we're happy to help out.
