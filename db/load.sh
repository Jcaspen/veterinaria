#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U veterinaria -d veterinaria < $BASE_DIR/veterinaria.sql
fi
psql -h localhost -U veterinaria -d veterinaria_test < $BASE_DIR/veterinaria.sql
