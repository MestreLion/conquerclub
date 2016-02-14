#!/bin/bash

if [[ -f common ]]; then
	source common
fi

clanplayerrank -q | htmltable -v mark=4,MestreLion
