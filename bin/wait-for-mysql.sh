#!/bin/sh
# https://stackoverflow.com/q/42567475/633864
seconds=1
until docker container exec -it mytheresa-mysql-1 mysqladmin ping -P 3306 -pmytheresa | grep "mysqld is alive" ; do
  >&2 echo "MySQL is unavailable - waiting for it... ($seconds)"
  sleep 5
  seconds=$(expr $seconds + 4)
done
sleep 5