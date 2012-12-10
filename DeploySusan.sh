#!/bin/sh

scp * $1@susan.mines.edu:/csci445f12/team10/social/$1
ssh $1@susan.mines.edu chown -R :team10 /csci445f12/team10/social/$1
ssh $1@susan.mines.edu chmod -R g+wrx /csci445f12/team10/social/$1
