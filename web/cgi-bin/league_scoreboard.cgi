#!/bin/bash

if [[ -f common ]]; then
	source common
fi

printf "<h2>Finished matches only:</h2>\n"

league_scoreboard | htmltable

printf "<h2>Including ongoing matches:</h2>\n"

league_scoreboard --ongoing | htmltable
