#!/bin/bash

MYSQL_HOME="$PWD/mysql"
MYSQL_DATADIR="$MYSQL_HOME/data"
MYSQL_SOCKET="$MYSQL_HOME/mysql.sock"
MYSQL_PID="$MYSQL_HOME/mysql.pid"
MYSQL_LOG="$MYSQL_HOME/error.log"

mkdir -p "$MYSQL_DATADIR"

if [ ! -d "$MYSQL_DATADIR/mysql" ]; then
    echo "Initializing MariaDB database..."
    mysql_install_db --no-defaults --auth-root-authentication-method=normal \
        --datadir="$MYSQL_DATADIR" \
        --basedir="$(which mysql | sed 's|/bin/mysql||')"
fi

if [ -f "$MYSQL_PID" ] && kill -0 $(cat "$MYSQL_PID") 2>/dev/null; then
    echo "MariaDB is already running"
else
    echo "Starting MariaDB server..."
    mysqld_safe --no-defaults \
        --datadir="$MYSQL_DATADIR" \
        --pid-file="$MYSQL_PID" \
        --socket="$MYSQL_SOCKET" \
        --skip-networking \
        --skip-grant-tables \
        --log-error="$MYSQL_LOG" &
    
    echo "Waiting for MariaDB to start..."
    for i in {1..30}; do
        if [ -S "$MYSQL_SOCKET" ]; then
            echo "MariaDB started successfully!"
            
            sleep 2
            
            if ! mysql --socket="$MYSQL_SOCKET" -e "USE u649349862_dev;" 2>/dev/null; then
                echo "Creating database u649349862_dev..."
                mysql --socket="$MYSQL_SOCKET" -e "CREATE DATABASE IF NOT EXISTS u649349862_dev CHARACTER SET utf8 COLLATE utf8_general_ci;" 2>/dev/null || true
            fi
            
            break
        fi
        sleep 1
    done
fi
