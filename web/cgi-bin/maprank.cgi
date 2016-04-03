#!/bin/bash

if [[ -f common ]]; then
	source common
fi

[[ "${GET[player]}" ]] &&
[[ "${GET[types]}"  ]] &&
{
	mapargs=(--game-type "${GET[types]}" -- "${GET[player]}")

	if [[ "${GET[info]}" ]]; then
		TERM=dumb maprank --only-info "${mapargs[@]}" |
		sed 's/$/<br>/;s/* //'
	else
		maprank -q "${mapargs[@]}" | htmltable
	fi
}
