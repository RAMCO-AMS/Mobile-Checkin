LOAD DATA LOCAL INFILE 'ramco-guids-4-11-15.txt'
INTO TABLE contacts
FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r'
ignore 1 lines
(guid, nrds, first_name, last_name);
