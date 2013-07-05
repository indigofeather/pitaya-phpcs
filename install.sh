#!/bin/bash

me=`whoami`

if [[ $me != "root" ]]
then
	echo 'Need root privileges, try running : sudo ./install.sh'
	exit 1
fi

DIR=$(cd `dirname $0` && pwd)
PEAR_DIR=`pear config-get php_dir`
SYMLINK="$PEAR_DIR/PHP/CodeSniffer/Standards/Pitaya"

if [[ ! -h $SYMLINK ]]
then
	ln -s $DIR/Standards/Pitaya $SYMLINK
fi

PHP_CMD=`which php`
if [[ -z  `$PHP_CMD -r "print(ini_get('include_path'));" | grep $PEAR_DIR` ]]
then
    echo "The PEAR installation directory : $PEAR_DIR, seems to be not referenced in the default PHP include path."
    echo "You should check your php.ini."
fi
