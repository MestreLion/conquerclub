#!/bin/bash

if [[ -f common ]]; then
	source common
fi

printf "<h4>Finished matches only:</h4>\n"

league_scoreboard | htmltable

printf "<h4>Including ongoing matches:</h4>\n"

league_scoreboard --ongoing | htmltable
