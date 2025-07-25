# Contributing to TextProbe

First off, thank you for taking the time to contribute! 🚀  
We appreciate your interest in improving this project.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How to Contribute](#how-to-contribute)
- [Development Setup](#development-setup)
- [Coding Standards](#coding-standards)
- [Running Tests](#running-tests)
- [Reporting Bugs](#reporting-bugs)
- [Proposing Features](#proposing-features)
- [License](#license)

---

## Code of Conduct

This project follows a [Code of Conduct](./CODE_OF_CONDUCT.md).  
Please make sure to read and adhere to it.

## How to Contribute

1. Fork the repository
2. Create a new branch: `git checkout -b feature/my-feature`
3. Make your changes
4. Run tests to verify everything still works
5. Commit your changes: `git commit -m "feat: Add my feature"`
6. Push to your fork: `git push origin feature/my-feature`
7. Submit a pull request (PR)

## Development Setup

```bash
git clone https://github.com/MakarMS/text-probe.git
cd text-probe
composer install
```

## Coding Standards

- Follow PSR-12 coding style.
- Use type hints and PHPDoc where appropriate.
- Keep methods and classes short and focused.
- Include meaningful commit messages.

## Running Tests

```bash
./vendor/bin/phpunit
```
All contributions **must** pass the full test suite. Add tests for any new features or bug fixes.

## Reporting Bugs

If you find a bug:

1. Search [issues](https://github.com/MakarMS/text-probe/issues) to see if it has already been reported.
2. If not, [open a new issue](https://github.com/MakarMS/text-probe/issues/new) with as much detail as possible:
   - Description of the problem
   - Steps to reproduce
   - PHP version, platform, etc.
   - Expected vs. actual behavior

## Proposing Features

We welcome feature suggestions. Please:

- Open an issue titled `Proposal: [feature name]`
- Describe the use case and proposed API
- Optionally include a prototype

## License

By contributing, you agree that your contributions will be licensed under the same license as the project: [MIT](LICENSE).
