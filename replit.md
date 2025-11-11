# Smart School Management System

## Overview
This is a PHP CodeIgniter-based school management system. The project was imported from GitHub and configured to run in the Replit environment.

## Recent Changes
- **November 11, 2025**: Initial Replit setup
  - Configured database credentials to use environment variables (DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE)
  - Updated base URL to automatically detect Replit environment
  - Set up PHP development server workflow on port 5000
  - Enhanced .gitignore for security and cleanliness

## Project Architecture

### Framework
- **Backend**: CodeIgniter 3.x (PHP framework)
- **PHP Version**: 8.2.23
- **Database**: MySQL/MariaDB (using mysqli driver)

### Directory Structure
- `index.php` - Main application entry point
- `application/` - CodeIgniter application files
  - `config/` - Configuration files (database, routes, etc.)
  - `controllers/` - MVC Controllers
  - `models/` - Database models
  - `views/` - View templates
  - `third_party/` - Third-party libraries (Stripe, PayPal, etc.)
- `system/` - CodeIgniter core framework files
- `smart_school_api_src/` - Separate API application for mobile/external access
- `backend/` - Backend assets (CSS, JS, images)
- `uploads/` - User uploaded files

### Key Features
Based on the structure, this system includes:
- Payment integrations (Stripe, PayPal, Razorpay, etc.)
- Course management
- Fee management
- Multiple payment gateway support
- Mobile API support

## Configuration

### Environment Variables
Set these in Replit Secrets for production:
- `DB_HOSTNAME` - Database host (default: localhost)
- `DB_USERNAME` - Database username (default: u649349862_dev)
- `DB_PASSWORD` - Database password (default: Amelitian@123)
- `DB_DATABASE` - Database name (default: u649349862_dev)

### Base URL
The base URL is automatically configured:
- In Replit: Uses `https://{REPL_SLUG}.{REPL_OWNER}.repl.co/`
- Locally: Uses `http://localhost:5000/`

### Database Setup
**IMPORTANT**: This application requires a MySQL database to function properly. Currently, the application is configured but will show database connection errors until a database is set up.

To complete the setup, you need to:
1. **Set up a MySQL database** - This can be an external MySQL service or database
2. **Configure credentials** - Update the environment variables in Replit Secrets:
   - `DB_HOSTNAME` - Your MySQL server hostname
   - `DB_USERNAME` - Your MySQL username
   - `DB_PASSWORD` - Your MySQL password  
   - `DB_DATABASE` - Your MySQL database name
3. **Import database schema** - You'll need to obtain and import the SQL schema for this Smart School system from the original source

**Current Status**: The web server is running but database connectivity needs to be configured.

## Development

### Running Locally
The project runs automatically via the configured workflow:
```
php -S 0.0.0.0:5000 -t .
```

### URL Rewriting
The `.htaccess` file handles URL rewriting to route all requests through `index.php`.

## User Preferences
None specified yet.

## Notes
- The application uses CodeIgniter's ENVIRONMENT constant (set to 'development' in index.php)
- Database debugging is enabled in development mode
- The system supports multiple payment gateways through modular integration
- There's a separate API in `smart_school_api_src/` for mobile app integration
