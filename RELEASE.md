# Release Notes

## Version 1.1.0

This release improves compatibility, runtime safety, and package usability for Laravel 11/12 applications.

### Highlights
- Updated framework and package compatibility constraints.
- Fixed authentication event handling for failed login attempts.
- Improved service provider boot flow for middleware and relationship binding.
- Added a package test scaffold and refreshed docs.

### Upgrade Notes
- Review any custom listeners that depend on the legacy event dispatch style.
- Ensure your application uses the same Laravel and SimpleCMS compatibility range declared in the package metadata.

### Typical installation

```bash
composer require simplecms/company
```

### Example usage

```php
use SimpleCMS\Company\Facades\CompanyAuthenticatable;

$auth = CompanyAuthenticatable::apiLogin('company-admin', 'secret123');
```
