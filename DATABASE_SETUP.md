# Database Setup Guide

Your Smart School application is ready to run! You just need to connect it to a MySQL database.

## What You Have

✅ Complete SQL database dump: `school630.sql` (96MB)  
✅ Web server configured and running on port 5000  
✅ Database credentials configured to use environment variables  
✅ All application files ready

## What You Need

A MySQL database to import your SQL file into.

---

## Quick Setup (10 minutes)

### Step 1: Choose a MySQL Hosting Service

Pick one of these free options:

**Option A: db4free.net** (Recommended)
- URL: https://www.db4free.net/
- Features: MySQL 8.0, instant activation, phpMyAdmin included
- Signup: https://www.db4free.net/signup.php

**Option B: FreeSQLDatabase.com**
- URL: https://www.freesqldatabase.com/
- Features: Easy setup, good for larger databases
- Direct phpMyAdmin access

**Option C: InfinityFree**
- URL: https://www.infinityfree.com/
- Features: Unlimited databases, more storage
- Includes hosting panel

### Step 2: Create Your Database

1. Sign up for your chosen service
2. Create a new MySQL database
3. Note down these credentials:
   - **Hostname** (e.g., `db4free.net` or `sql123.freesqldatabase.com`)
   - **Username** (e.g., `yourusername`)
   - **Password** (e.g., `yourpassword`)
   - **Database Name** (e.g., `school630_db`)

### Step 3: Import the SQL File

1. Download `school630.sql` from this Repl (click the 3 dots next to the file → Download)
2. Access phpMyAdmin (provided by your hosting service)
3. Select your database
4. Click "Import" tab
5. Choose the `school630.sql` file
6. Click "Go" to import (may take 1-2 minutes for 96MB)

### Step 4: Configure Replit

1. In your Repl, click the **🔒 Lock icon** in the left sidebar (Secrets)
2. Add these four secrets:

```
DB_HOSTNAME = your.mysql.host.com
DB_USERNAME = your_username
DB_PASSWORD = your_password
DB_DATABASE = your_database_name
```

**Example:**
```
DB_HOSTNAME = db4free.net
DB_USERNAME = school_user
DB_PASSWORD = MySecurePass123
DB_DATABASE = school630_db
```

### Step 5: Restart and Test

1. Go to the "Tools" panel in Replit
2. Find "Smart School Web Server" workflow
3. Click "Restart"
4. Open the preview - errors should be gone!

---

## Troubleshooting

### Import Failed - File Too Large
- Try compressing the SQL file (gzip)
- Use command line import if phpMyAdmin times out
- Split the file into smaller parts

### Connection Errors After Setup
- Double-check all 4 secrets are set correctly
- Verify hostname doesn't include `http://` or port
- Make sure database name matches exactly
- Restart the workflow after changing secrets

### Can't Access phpMyAdmin
- Check your email for activation link
- Look for control panel or database management section
- Contact hosting support if needed

---

## Database Info

Your database contains:
- **Student Management**: Student records, admissions, alumni
- **Academic**: Classes, sections, subjects, attendance
- **Finance**: Fees, payments, invoices
- **Library**: Books, book issues
- **HR**: Staff, payroll
- **Communication**: Messages, notifications
- **And much more!**

Total tables: 200+  
Database size: ~96MB

---

## Security Notes

⚠️ Never share your database credentials  
⚠️ Don't commit credentials to Git  
⚠️ Use Replit Secrets (environment variables) only  
⚠️ Regularly backup your database

---

## Need Help?

If you encounter issues:
1. Check the workflow logs for error details
2. Verify database credentials are correct
3. Test database connection using phpMyAdmin
4. Make sure the SQL import completed successfully

The application is fully configured and ready - it just needs the database connection!
