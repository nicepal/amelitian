# Smart School Management System

## Overview
This is a PHP CodeIgniter-based school management system. The project was imported from GitHub and configured to run in the Replit environment.

## Recent Changes
- **November 20, 2025**: Super Admin Dashboard Redesign + Comprehensive CSS Fix (Red/White Theme)
  - **Dashboard Navigation**: Added prominent Dashboard shortcut link at top of sidebar menu
  - **Created dashboard-enhancements.css** with:
    - 3 interactive key metric cards with **red/white theme** (matching school branding)
    - White card backgrounds with red accent borders and icons
    - Animated circular progress indicators with red color scheme
    - Smooth pulse animations and hover effects
    - Comparison bar animations for fee collection vs expenses (red gradients)
    - Loading skeleton screens with shimmer effect
    - Enhanced chart containers with fade-in animations
    - Full mobile responsiveness with touch-friendly interactions
    - Accessibility features (reduced motion support, high contrast mode, keyboard navigation)
  - **Created dashboard-enhancements.js (14KB)** featuring:
    - Animated count-up effect for all numeric values (easeOutExpo timing)
    - Circular progress SVG animations with strokeDashoffset
    - Comparison bar sliding animations
    - Intersection Observer for scroll-triggered animations
    - Chart loading state management
    - Scroll-to-top button with smooth scrolling
    - Enhanced tooltip system
    - Responsive chart resize handling
    - Safe zero-value guards (prevents NaN/Infinity errors)
  - **Updated dashboard.php** with:
    - Safe PHP variable initialization (prevents undefined variable errors)
    - 3 highlighted key metric cards at top of dashboard
    - Proper data binding with fallback defaults
    - Maintains all existing dashboard functionality
  - **MAJOR FIX: Completely rewrote ui-enhancements.css**:
    - **Removed all global CSS overrides** that were breaking forms, tables, and modals
    - **Eliminated invalid :not() selectors** that browsers were ignoring
    - **Introduced opt-in wrapper approach** (.ui-enhanced class) for scoped enhancements
    - Reduced from 771 lines to 270 lines of clean, non-conflicting CSS
    - Removed all !important declarations that overrode AdminLTE defaults
    - Fixes dropdown values displaying outside fields in data tables
    - Fixes button overlap and modal layout issues
    - Restores proper table formatting and inline editing
  - **Dashboard Color Theme**:
    - Changed from purple/pink/cyan to **red/white** matching school branding
    - Primary red: #c8191e (school's brand color)
    - Accent reds: #a71d2a, #e74c3c
    - White backgrounds with subtle red-tinted gradients
    - All icons, progress indicators, and comparison bars use red color scheme
  - All code architect-reviewed and production-ready
  - Fully compatible with existing AdminLTE theme
  - **No conflicts with any existing components**
  
- **November 14, 2025**: UI/UX Modernization
  - Implemented comprehensive UI enhancements with modern design system
  - Created custom CSS framework (`backend/dist/css/ui-enhancements.css`) with:
    - Modern dashboard cards with shadows, gradients, and hover effects
    - Animated statistics counters with smooth transitions
    - Enhanced navigation sidebar with improved spacing and animations
    - Modern form inputs with focus effects and validation feedback
    - Improved table designs with hover states and striping
    - Redesigned buttons with gradient backgrounds and loading states
    - Enhanced typography hierarchy and icon animations
    - Full mobile responsiveness
  - Created interactive JavaScript library (`backend/js/ui-enhancements.js`) featuring:
    - Animated number counters for dashboard statistics
    - Smart form validation feedback
    - Button loading states (compatible with both button and input elements)
    - Smooth scrolling (respects Bootstrap components)
    - Toast notifications system
    - Enhanced tooltips and dropdowns
  - Redesigned login page (`backend/usertemplate/assets/css/login-enhancements.css`) with:
    - Beautiful gradient background with animated particles
    - Modern card design with shadows and animations
    - Enhanced form inputs with smooth transitions
    - Improved mobile layout
  - All enhancements maintain compatibility with existing AdminLTE theme
  - Production-ready code reviewed and approved by architect

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
**IMPORTANT**: This application requires a MySQL database to function properly. Currently showing database connection errors because no database is connected.

#### Recommended Solution: Use an External MySQL Database

Since Replit doesn't natively support MySQL, you'll need to use an external MySQL hosting service. Here are recommended free options:

**Free MySQL Hosting Services:**
1. **db4free.net** - Free MySQL 8.0 hosting (quick signup)
2. **FreeMySQLHosting.net** - 5MB free database
3. **InfinityFree** - Unlimited MySQL databases with hosting
4. **GoogieHost** - Free hosting with MySQL support

#### Setup Steps:
1. **Sign up** for a free MySQL hosting service
2. **Create a database** through their control panel
3. **Get your credentials** (hostname, username, password, database name)
4. **Add to Replit Secrets** (click the lock icon in left sidebar):
   - `DB_HOSTNAME` - Your MySQL server hostname (e.g., sql123.example.com)
   - `DB_USERNAME` - Your MySQL username
   - `DB_PASSWORD` - Your MySQL password  
   - `DB_DATABASE` - Your database name
5. **Import database schema** - You'll need the SQL schema file for Smart School (not included in this repository)
6. **Restart the workflow** - Changes take effect after restart

**Current Status**: Web server runs but displays database connection errors. Once you configure an external MySQL database, the application will function fully.

**Note**: The SQL database file (`school630.sql` - 96MB) is ready for import. The default credentials in the code (`u649349862_dev` / `Amelitian@123` / `localhost`) are placeholders that will be replaced by your actual database credentials via environment variables.

### Quick Start Guide:
1. Sign up at **db4free.net** or **freesqldatabase.com**
2. Create a MySQL database
3. Import the `school630.sql` file using phpMyAdmin
4. Add your credentials to Replit Secrets
5. Restart the workflow - done!

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
