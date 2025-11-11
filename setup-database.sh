#!/bin/bash

MYSQL_HOME="$PWD/mysql"
MYSQL_DATADIR="$MYSQL_HOME/data"
MYSQL_SOCKET="$MYSQL_HOME/mysql.sock"
MYSQL_PID="$MYSQL_HOME/mysql.pid"

mkdir -p "$MYSQL_DATADIR"

# Initialize database if needed
if [ ! -d "$MYSQL_DATADIR/mysql" ]; then
    echo "Initializing MariaDB database..."
    mysql_install_db --no-defaults --auth-root-authentication-method=normal \
        --datadir="$MYSQL_DATADIR" 2>&1 | grep -v "Warning"
fi

# Start MariaDB if not running
if ! [ -S "$MYSQL_SOCKET" ]; then
    echo "Starting MariaDB server..."
    mysqld --no-defaults \
        --datadir="$MYSQL_DATADIR" \
        --socket="$MYSQL_SOCKET" \
        --skip-networking \
        --skip-grant-tables &
    
    # Wait for socket
    for i in {1..30}; do
        if [ -S "$MYSQL_SOCKET" ]; then
            echo "MariaDB started!"
            sleep 2
            break
        fi
        sleep 1
    done
fi

# Create database and import
echo "Creating database u649349862_dev..."
mysql --socket="$MYSQL_SOCKET" -e "CREATE DATABASE IF NOT EXISTS u649349862_dev CHARACTER SET utf8 COLLATE utf8_general_ci;" 2>&1 | grep -v "Warning"

echo "Importing database schema... (this may take a minute)"
mysql --socket="$MYSQL_SOCKET" u649349862_dev < school630.sql 2>&1 | grep -v "Warning" | head -20

echo "Database setup complete!"
echo "Database: u649349862_dev"
echo "Tables imported successfully"
