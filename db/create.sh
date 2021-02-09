#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE veterinaria_test;"
    psql -U postgres -c "CREATE USER veterinaria PASSWORD 'veterinaria' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists veterinaria
    sudo -u postgres dropdb --if-exists veterinaria_test
    sudo -u postgres dropuser --if-exists veterinaria
    sudo -u postgres psql -c "CREATE USER veterinaria PASSWORD 'veterinaria' SUPERUSER;"
    sudo -u postgres createdb -O veterinaria veterinaria
    sudo -u postgres psql -d veterinaria -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O veterinaria veterinaria_test
    sudo -u postgres psql -d veterinaria_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:veterinaria:veterinaria"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
