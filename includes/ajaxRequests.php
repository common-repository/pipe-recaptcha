<?php

namespace RcPipeRecaptcha;

class ajaxRequests{

    /**
     * ajaxRequests constructor.
     */

    private $pr;
    private $pipeRecaptchaDifficulty;

    public function __construct()
    {


        add_action('wp_ajax_rc_pipe_puzzle_verify', [$this, 'rc_pipe_puzzle_verify']);
        add_action('wp_ajax_nopriv_rc_pipe_puzzle_verify', [$this, 'rc_pipe_puzzle_verify']);


        add_action('wp_ajax_prepare_for_recaptcha', [$this, 'prepare_for_recaptcha']);
        add_action('wp_ajax_nopriv_prepare_for_recaptcha', [$this, 'prepare_for_recaptcha']);

        add_action('wp_ajax_save_pipe_recaptcha_settings', [$this, 'save_pipe_recaptcha_settings']);

        $this->pipeRecaptchaDifficulty = get_option('pipeRecaptchaDifficulty', array('normal'));


        require 'class-pipe-recaptcha.php';
        $this->pr = new \pipeRecaptcha($this->getDifficultyRandomely());
    }


    function rc_pipe_puzzle_verify()
    {
        $puzzle = isset($_POST['puzzle']) ? sanitize_textarea_field($_POST['puzzle']) : "";
        $puzzle_key = isset($_POST['key']) ? sanitize_key($_POST['key']) : "";

        $this->nonceCheck();

        global $wpdb;
        $puzzles = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rc_pipe_recaptcha_puzzles WHERE puzzle_key='{$puzzle_key}'");
        if (!empty($puzzles)){

            $p = str_replace('i', '', $puzzles[0]->puzzle);
            if ($puzzle==$p){
                $rand = $this->pr->RandomString(15);

                $this->addUserToRecaptchaLog($rand);

                echo json_encode(array('success' => true, 'status' => 'success', 'response' => "matched", "verify_id"=>$rand));
                die();
            }
        }

        echo json_encode(array('success' => false, 'status' => 'failed', 'response' => 'not matched'));

        die();
    }

    public function getDifficultyRandomely()
    {
        $c = count($this->pipeRecaptchaDifficulty)-1;
        $rand = rand(0, $c);
        if (isset($this->pipeRecaptchaDifficulty[$rand])){
            return $this->pipeRecaptchaDifficulty[$rand];
        }
        return "normal";
    }

    function save_pipe_recaptcha_settings()
    {
        $recaptchaStatus = isset($_POST['recaptchaStatus']) ? sanitize_key($_POST['recaptchaStatus']) : "";
        $recaptchaIn = isset($_POST['recaptchaIn']) ? (array) $_POST['recaptchaIn'] : array();
        $recaptchaIn = array_map( 'sanitize_text_field', $recaptchaIn );

        $recaptchaDifficulty = isset($_POST['recaptchaDifficulty']) ? (array) $_POST['recaptchaDifficulty'] : array();
        $recaptchaDifficulty = array_map( 'sanitize_text_field', $recaptchaDifficulty );

        $this->nonceCheck();

        update_option('pipeRecaptchaStatus', $recaptchaStatus);
        update_option('PR_activated_in', $recaptchaIn);
        update_option('pipeRecaptchaDifficulty', $recaptchaDifficulty);


        echo json_encode(array('success' => true, 'status' => 'success'));

        die();
    }

    public function addUserToRecaptchaLog($verify)
    {
        $user_id = $this->pr->setCookie();
        $user_ip = $this->pr->get_client_ip();

        $this->nonceCheck();

        global $wpdb;
        $user = $wpdb->get_results("SELECT id FROM {$wpdb->prefix}rc_pipe_recaptcha_logs WHERE user='{$user_id}' OR ip LIKE '{$user_ip}' ");
        if (!empty($user)){
            $wpdb->update(
                "{$wpdb->prefix}rc_pipe_recaptcha_logs",
                array(
                    'user' => $user_id,
                    'verify_id' => $verify,
                    'verified_at' => date("Y-m-d H:i:s"),
                ),
                array( 'id' => $user[0]->id ),
                array(
                    '%s',
                    '%s',
                    '%s',
                ),
                array( '%d' )
            );
        }
        else{
            $wpdb->insert(
                $wpdb->prefix . 'rc_pipe_recaptcha_logs',
                array(
                    'user' => $user_id,
                    'ip' => $user_ip,
                    'verify_id' => $verify,
                    'verified_at' => date("Y-m-d H:i:s"),
                ),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                )
            );
        }
    }


    function prepare_for_recaptcha()
    {
        $this->nonceCheck();
        echo json_encode(array('success' => true, 'status' => 'success', 'html' => wp_kses_post($this->pr->getRecaptcha()), 'key'=> $this->pr->getPuzzleKey()));
        die();
    }

    public function nonceCheck()
    {
        $nonce = isset($_POST['rc_nonce']) ? sanitize_key($_POST['rc_nonce']) : "";

        if (!empty($nonce)) {
            if (!wp_verify_nonce($nonce, "rc-nonce")) {
                echo json_encode(array('success' => false, 'status' => 'nonce_verify_error', 'response' => ''));

                die();
            }
        }
    }



}