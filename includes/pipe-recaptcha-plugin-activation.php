<?php

class RcPipeRecaptchaActivator{
    function createTable(){
        global $wpdb;

        $table_name1 = $wpdb->prefix.'rc_pipe_recaptcha_puzzles';
        $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name1 ) );

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        if ( ! $wpdb->get_var( $query ) == $table_name1 ) {

            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE " . $table_name1 ." (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              puzzle text NOT NULL,
              level text NOT NULL,
              puzzle_key text NOT NULL,
              PRIMARY KEY  (id)
            ) $charset_collate;";

            dbDelta( $sql );
        }
        //$this->createPuzzles();

        $table_name2 = $wpdb->prefix.'rc_pipe_recaptcha_logs';
        $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name2 ) );

        if ( ! $wpdb->get_var( $query ) == $table_name2 ) {

            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE " . $table_name2 ." (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              user text NOT NULL,
              ip text NOT NULL,
              verify_id text NOT NULL,
              verified_at DATETIME DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY  (id)
            ) $charset_collate;";

            dbDelta( $sql );
        }

    }

    public function createPuzzles()
    {
        global $wpdb;
        $puzzles_url = PR_Plugin_DIR_URL.'/assets/pp';
        $response = wp_remote_get($puzzles_url);
        $responseBody = wp_remote_retrieve_body( $response );

        if (!empty($responseBody) && !is_wp_error( $response )){
            $puzzles = json_decode($responseBody);
            if (!empty($puzzles)){
                foreach ($puzzles as $puzzle) {
                    $level = $puzzle[1];
                    $wpdb->insert(
                        $wpdb->prefix . 'rc_pipe_recaptcha_puzzles',
                        array(
                            'puzzle' => $puzzle[0],
                            'level' => $level,
                            'puzzle_key' => $this->RandomString(),
                        ),
                        array(
                            '%s',
                            '%s',
                            '%s',
                        )
                    );
                }
            }
        }
    }

    public function RandomString($limit=10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $limit; $i++) {

            $randstring .= substr($characters, rand(0, strlen($characters)), 1);
        }
        return $randstring;
    }

    


}