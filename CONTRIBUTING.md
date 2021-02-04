# Contributing

:+1::tada: First off, thanks for taking the time to contribute! :tada::+1:

This repository is open for contribution. Please submit new features and fixes by creating a Pull Request.

## GIT Commit Messages

Please keep the following in mind while creating commit messages:

- Reference issue number
- Keep the description short and clear
- Try to use the present tense ("Add feature" not "Added feature")

## Creating a Pull Request

Code can be added/modified by creating a Pull Request.  

The code must meet the following requirements:
- `declare(strict_types=1)` must be used
- Only use PHP language features above the minimum supported version (see `composer.json`)
- Add type hints for everything (including: return types, nullable types and `void`)
- Provide PHP DocBlocks for all methods
- Declare visibility on methods, variables and properties
- Add and update PHPUnit testcases

## Code testing with PHPUnit

Run PHPUnit tests with `composer test`.  
When a code coverage report is needed you can run `composer test-coverage`. The code coverage report will be placed in the `coverage` folder in the root of the project.
