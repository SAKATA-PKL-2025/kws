# Family Tree Management System

## Overview

A comprehensive web-based family tree management system developed for genealogical data organization and family history preservation. This application provides robust tools for managing family member records, genealogical branches, photo galleries, and family relationships across multiple generations.

## Key Features

### Family Management

- Complete family member profile management with biographical information
- Multi-generational relationship tracking (parents, spouses, children)
- Family branch organization and hierarchy management
- Support for living and deceased member records
- Advanced search and filtering capabilities

### Genealogical Features

- Interactive family tree visualization
- Generation-based member categorization
- Comprehensive relationship mapping (father, mother, spouse connections)
- Photo gallery management for family memories
- Privacy controls and access management

### E-Commerce Integration

- Product catalog management
- Category-based product organization
- Inventory and stock management
- Price and promotional pricing support
- SKU-based product tracking

### Administrative Interface

- Filament-powered admin panel for streamlined management
- Role-based access control using Spatie Permissions
- User authentication and authorization
- Profile management capabilities
- Dashboard with analytics and insights

### Public Features

- Public family tree browsing
- Member search functionality
- Photo gallery viewing
- Privacy policy and information pages
- Responsive design for all devices

## Technical Architecture

### Technology Stack

**Backend Framework**

- Laravel 10.x (PHP 8.1+)
- MySQL/MariaDB database
- Repository pattern implementation
- Service-oriented architecture

**Frontend Technologies**

- Livewire for dynamic components
- Alpine.js for interactive elements
- Tailwind CSS for responsive styling
- Bootstrap 5 (legacy support)
- Vite for asset bundling

**Admin Panel**

- Filament 3.2 administration framework
- Custom resource management
- Policy-based authorization

**Key Dependencies**

- Spatie Laravel Permission for role management
- Laravel Sanctum for API authentication
- Laravel Breeze for authentication scaffolding
- Guzzle HTTP client
- UUID trait for unique identifiers

### Design Patterns

**Repository Pattern**

- `CategoryRepository` for category data access
- `ProductRepository` for product operations
- Interface-based contracts for flexibility

**Traits**

- `HasPagination` for consistent pagination
- `HasSearch` for search functionality
- `HasSort` for sorting capabilities
- `HasPriceRange` for price filtering
- `UuidTrait` for UUID primary keys

**Policies**

- `FamilyBranchPolicy` for branch access control
- `FamilyMemberPolicy` for member data authorization

## System Requirements

### Server Requirements

- PHP >= 8.1
- MySQL >= 5.7 or MariaDB >= 10.3
- Composer 2.x
- Node.js >= 16.x
- NPM or Yarn

### PHP Extensions

- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD or Imagick (for image processing)

## Installation Guide

### 1. Clone Repository

```bash
git clone https://github.com/SAKATA-PKL-2025/kws.git
cd kws
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies

```bash
npm install
```

### 4. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Database Configuration

Edit `.env` file with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 6. Database Migration and Seeding

```bash
php artisan migrate
php artisan db:seed
```

### 7. Storage Linking

```bash
php artisan storage:link
```

### 8. Build Frontend Assets

```bash
npm run build
```

For development:

```bash
npm run dev
```

### 9. Run Application

```bash
php artisan serve
```

Access the application at `http://localhost:8000`

## Configuration

### Admin Panel Access

Create an admin user:

```bash
php artisan make:filament-user
```

Access admin panel at: `http://localhost:8000/admin`

### Permission Setup

The system uses Spatie Laravel Permission. Configure roles and permissions:

```bash
php artisan permission:cache-reset
```

### File Storage

Configure storage disk in `config/filesystems.php`:

- Public disk for accessible files
- Private disk for protected content

## Development

### Code Standards

- PSR-12 coding standard
- Laravel best practices
- Repository pattern for data access
- Service classes for business logic

### Testing

Run PHPUnit tests:

```bash
php artisan test
```

Or using Maven wrapper (if configured):

```bash
mvn test
```

### Code Quality

Run Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

## Project Structure

```
app/
├── Console/         # Artisan commands
├── Exceptions/      # Exception handling
├── Filament/        # Admin panel resources and pages
├── Http/
│   ├── Controllers/ # Request controllers
│   ├── Middleware/  # HTTP middleware
│   └── Requests/    # Form request validation
├── Interfaces/      # Repository contracts
├── Models/          # Eloquent models
├── Policies/        # Authorization policies
├── Providers/       # Service providers
├── Repositories/    # Data access layer
├── Traits/          # Reusable traits
└── View/            # View components

config/              # Application configuration
database/
├── migrations/      # Database migrations
├── seeders/         # Database seeders
└── factories/       # Model factories

resources/
├── css/             # Stylesheets
├── js/              # JavaScript files
└── views/           # Blade templates

routes/              # Application routes
├── web.php          # Web routes
├── api.php          # API routes
└── auth.php         # Authentication routes
```

## API Documentation

The application provides RESTful API endpoints for integration. API authentication is handled via Laravel Sanctum.

### Authentication

- Token-based authentication
- Sanctum middleware protection
- CORS configuration available in `config/cors.php`

## Security

### Security Features

- CSRF protection on all forms
- XSS protection via Blade templating
- SQL injection prevention through Eloquent ORM
- Password hashing using bcrypt
- Role-based access control
- Policy-based authorization

### Best Practices

- Regular dependency updates
- Environment variable usage for sensitive data
- HTTPS enforcement in production
- Database query optimization
- Input validation and sanitization

## Deployment

### Production Checklist

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Configure proper `APP_URL`
4. Optimize configuration: `php artisan config:cache`
5. Optimize routes: `php artisan route:cache`
6. Optimize views: `php artisan view:cache`
7. Run migrations: `php artisan migrate --force`
8. Build assets: `npm run build`
9. Set proper file permissions
10. Configure queue workers for background jobs
11. Set up scheduled tasks via cron

### Queue Configuration

For production environments, configure queue workers:

```bash
php artisan queue:work --tries=3
```

### Task Scheduling

Add to crontab:

```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## Troubleshooting

### Common Issues

**Storage Permission Errors**

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Cache Issues**

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

**Database Connection Errors**

- Verify database credentials in `.env`
- Check MySQL service status
- Verify database exists

**Asset Build Failures**

```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```

## Performance Optimization

### Database Optimization

- Use eager loading to prevent N+1 queries
- Index frequently queried columns
- Use database query caching
- Implement pagination for large datasets

### Application Optimization

- Enable OPcache in production
- Use Redis for session and cache storage
- Implement CDN for static assets
- Enable Gzip compression

## Contributing

Contributions are managed internally by Sakata Innovation Centre development team.

### Development Workflow

1. Create feature branch from `development`
2. Implement changes following code standards
3. Write tests for new functionality
4. Submit pull request for review
5. Merge after approval

## Support

For technical support and inquiries, contact the development team at Sakata Innovation Centre.

## License

Copyright (c) 2026 Sakata Innovation Centre. All rights reserved.

This software is proprietary and confidential. See LICENSE file for complete terms and conditions.

## Credits

Developed and maintained by Sakata Innovation Centre.

### Third-Party Packages

- Laravel Framework (MIT License)
- Filament Admin Panel (MIT License)
- Spatie Laravel Permission (MIT License)
- Livewire (MIT License)
- Alpine.js (MIT License)
- Tailwind CSS (MIT License)

## Changelog

### Version 1.0.0

- Initial release
- Family tree management system
- Product catalog integration
- Admin panel implementation
- Public family tree browsing
- Member search functionality
- Photo gallery management

---

**Built with dedication by Sakata Innovation Centre**
