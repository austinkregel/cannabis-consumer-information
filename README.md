# Michigan Cannabis Club

This project aims to make information about cannabis products in Michigan more accessible.

### How do I set this up?

#### What exactly is required to run the app?

PHP 8.1, Redis, a Google Maps API key, and your OS's installation of pdftk

#### Docker
The best way to set it up and hack it would be to use Laravel Sail!

```
# Install composer
docker run --rm -v "$(pwd)":/opt -w /opt austinkregel/base:latest bash -c "composer install"
# Start the app using Laravel Sail
vendor/bin/sail up -d
```

#### How is it deployed?

Laravel Forge!

[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2F4a3f6ede-fe3e-4839-b2ed-3dfcd88484ce%3Fdate%3D1%26commit%3D1&style=for-the-badge)](https://forge.laravel.com)

### Security Concerns?
Please email me directly at [security@kregel.email](mailto:security@kregel.email)

### Found a bug?

Please create an issue, and describe! If you're able to a fix is always appreciated but not expected.
