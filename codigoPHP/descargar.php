<?php

header('Content-Disposition: attachment;filename="SQL.xml"');
header('Content-Type: text/xml');
readfile("../tmp/SQL.xml");