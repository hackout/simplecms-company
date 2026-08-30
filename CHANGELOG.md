# Changelog

All notable changes to this project will be documented in this file.

## [1.1.0] - 2026-08-31

### Added
- Added package bootstrap test scaffold for Laravel service provider verification.
- Added explicit package metadata for development testing and upgrade preparation.
- Added clearer API usage examples in the documentation.

### Changed
- Improved Laravel compatibility constraints for framework and Sanctum.
- Adjusted package requirement to match the actual SimpleCMS v2 stack.
- Hardened company relationship binding so it no longer fails when the application model directory is missing.
- Modernized event dispatch usage to align with Laravel's object-based event system.

### Fixed
- Fixed login error flow to avoid processing null account values during failed authentication events.
- Fixed API login path to emit proper authentication events and return actual token payloads.
- Fixed middleware registration so the logging middleware is safely bound during package boot.
- Fixed guard login flow to authenticate with the actual account name and cleanly reject invalid accounts.

### Notes
- This release focuses on compatibility stability and improved runtime safety for Laravel 11/12-based applications.
