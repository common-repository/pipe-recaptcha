<?php

class RcPipeRecaptchaDectivator{
    function removeTable(){
        global $wpdb;
        $tableArray = [
            $wpdb->prefix . "rc_pipe_recaptcha_puzzles",
            $wpdb->prefix . "rc_pipe_recaptcha_logs",
        ];

        foreach ($tableArray as $tablename) {
            $wpdb->query("DROP TABLE IF EXISTS $tablename");
        }
    }

}