#!/bin/ksh
find . -type f -exec grep -l "$1" {} \;
