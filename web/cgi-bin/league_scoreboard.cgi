#!/bin/bash

if [[ -f common ]]; then
	source common
fi

htmltableparams=()
scoreboardparams=()

if [[ "${GET[clan]}" ]]; then
	htmltableparams+=(-v mark=2,"${GET[clan]}")
fi

if [[ "${GET[mode]}" == "ongoing" ]]; then
	scoreboardparams+=(--ongoing)
fi

league_scoreboard "${scoreboardparams[@]}" | htmltable "${htmltableparams[@]}"
