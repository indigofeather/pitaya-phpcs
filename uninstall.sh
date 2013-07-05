#!/bin/bash

me=`whoami`

if [[ $me != "root" ]]
then
	echo 'Need root privileges, try running : sudo ./install.sh'
	exit 1
fi

PEAR_DIR=`pear config-get php_dir`
SYMLINK="$PEAR_DIR/PHP/CodeSniffer/Standards/Pitaya"

if [[ -h $SYMLINK ]]
then
	rm $SYMLINK
fi
