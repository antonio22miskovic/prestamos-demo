# Prestamos Demo - Loan Management System

A comprehensive loan management system built with Laravel 10, featuring multi-step loan applications, automated evaluation, and contract management.

## Quick Start

### 1. Setup with Docker Sail

```bash
# Clone and setup
git clone <repository-url> prestamos-demo
cd prestamos-demo

# Start containers
./vendor/bin/sail up -d

# Install dependencies and run migrations
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed

# Install and compile frontend assets
npm install
npm run build
```

### 2. Access the Application

- **Application**: http://localhost
- **Mailpit (Email Testing)**: http://localhost:8025

### 3. Default Users

- **Admin**: admin@prestamos-demo.com / admin123
- **Client**: client@prestamos-demo.com / client123

## Features

### For Clients
- Multi-step loan application (4 steps)
- Secure document upload
- Real-time application status
- Digital contract signing
- Payment history tracking

### For Administrators  
- Application review and approval
- Automated evaluation engine
- Document verification
- Loan management
- Analytics dashboard
- Export capabilities

## Technology Stack

- Laravel 10.x + PHP 8.1+
- MySQL 8.0
- Livewire 3.x + TailwindCSS
- Docker (Laravel Sail)
- DomPDF for contracts
- Redis for caching/queues

## Project Structure

- `app/Models/` - Eloquent models
- `app/Http/Livewire/` - Livewire components  
- `database/migrations/` - Database schema
- `resources/views/` - Blade templates
- `tests/` - PHPUnit tests

## Development

```bash
# Run tests
./vendor/bin/sail artisan test

# Code formatting
./vendor/bin/pint

# Watch assets
npm run dev
```

## License

MIT License
