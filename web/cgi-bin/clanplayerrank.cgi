#!/bin/bash

if [[ -f common ]]; then
	source common
fi

htmltableparams=()

if [[ "${GET[player]}" ]]; then
	htmltableparams+=(-v mark=4,"${GET[player]}")
fi

clanplayerrank -q | htmltable "${htmltableparams[@]}"
