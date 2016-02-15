#!/bin/bash

if [[ -f common ]]; then
	source common
fi

[[ "${GET[player]}" ]] &&
[[ "${GET[types]}"  ]] &&
maprank -q --game-type "${GET[types]}" -- "${GET[player]}" | htmltable
