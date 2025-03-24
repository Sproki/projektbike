<?php
    $c = oci_pconnect("BIKEDB", "BIKEDB", "localhost/orcl");
    if (!$c) {
        $e = oci_error();
        trigger_error('Could not connect to database: '. $e['message'], E_USER_ERROR);
    }