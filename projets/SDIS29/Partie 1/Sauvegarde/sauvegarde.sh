#!/bin/bash
DAT=$(date "+%u")

ssh root@ap32-test "mysqldump -u admin -padmin sdis2022 | gzip"  > sdis2022-dump-$DAT.sql.gz 
cp sdis2022-dump-$DAT.sql.gz dump.latest.gz
