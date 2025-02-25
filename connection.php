<?php
    $c = oci_pconnect("BIKE", "BIKE", "localhost/ORCL");
    if (!$c) {
        $e = oci_error();
        trigger_error('Could not connect to database: '. $e['message'], E_USER_ERROR);
    }