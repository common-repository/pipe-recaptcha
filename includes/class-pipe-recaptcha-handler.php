<?php

class pipeRecaptchaHandler{

    private $pipeRecaptchaStatus;
    private $PR_activated_in;
    /**
     * pipeRecaptchaHandler constructor.
     */
    public function __construct()
    {
        $this->pipeRecaptchaStatus = get_option('pipeRecaptchaStatus', 'enabled');
        $this->PR_activated_in = get_option('PR_activated_in', array('contactForm7', 'loginForm', 'registrationForm', 'commentsForm'));

        if ($this->pipeRecaptchaStatus=="enabled"){
            if (class_exists('WPCF7') && in_array('contactForm7', $this->PR_activated_in)){
                add_action( 'wpcf7_init', [$this, 'custom_add_shortcode_pipe_recaptcha'] );
                add_action("wpcf7_before_send_mail", [$this, 'check_is_cf7_pipe_recaptcha_verified'], 10, 3);
            }

            if (in_array('loginForm', $this->PR_activated_in)){
                add_action('login_form', [$this, 'pipe_recaptcha_html']);
                add_filter('wp_authenticate_user',[$this, 'pipe_recaptcha_validation_on_login'],10);
            }

            if (in_array('registrationForm', $this->PR_activated_in)){
                add_action('register_form', [$this, 'pipe_recaptcha_html']);
                add_action( 'register_post', [$this, 'verify_pipe_recaptcha'], 10, 3 );
            }

            if (in_array('commentsForm', $this->PR_activated_in)){
                add_action('comment_form_after_fields', [$this, 'pipe_recaptcha_html']);
            }
            if (in_array('loggedInCommentsForm', $this->PR_activated_in)){
                add_action('comment_form_logged_in_after', [$this, 'pipe_recaptcha_html']);
            }
            if (in_array('commentsForm', $this->PR_activated_in)||in_array('loggedInCommentsForm', $this->PR_activated_in)){
                add_filter( 'preprocess_comment', [$this, 'verify_comment_meta_data'] );
            }

            add_action("wp_enqueue_scripts", [$this, 'wp_enqueue_scripts']);

            add_action("login_enqueue_scripts", [$this, 'wp_enqueue_scripts']);
            add_action('login_print_scripts', [$this, 'cdata']);


            add_action('wp_footer', [$this, 'recaptcha_container']);
            add_action('login_footer', [$this, 'recaptcha_container']);

    }



        add_action("admin_enqueue_scripts", [$this, 'admin_enqueue_scripts']);
        add_action('wp_print_scripts', [$this, 'cdata']);
        add_action( 'admin_menu', array($this,'add_pipe_recaptcha_options_page') );

    }

    public function wp_enqueue_scripts()
    {
        wp_enqueue_script('pipe-recaptcha-js', PR_Plugin_DIR_URL . '/assets/js/pipe-recaptcha.js', array('jquery'), Pipe_Recaptcha_Version, true);
        wp_enqueue_style('pipe-recaptcha-css', PR_Plugin_DIR_URL . '/assets/css/pipe-recaptcha.css', Pipe_Recaptcha_Version);
    }

    public function admin_enqueue_scripts()
    {
        wp_enqueue_script('jquery');
    }

    public function cdata()
    {
        ?>
        <script>
            /* <![CDATA[ */
            var rcpr = {
                "ajax_url": "<?php echo admin_url('admin-ajax.php'); ?>",
                "nonce": "<?php echo wp_create_nonce('rc-nonce'); ?>",
                "home_url": "<?php echo home_url(); ?>"
            };
            /* ]]\> */
        </script>
        <?php
    }
    public function custom_add_shortcode_pipe_recaptcha() {
        wpcf7_add_form_tag( 'pipe_recaptcha', [$this, 'rc_pipe_recaptcha_shortcode_handler'] );
    }

    public function rc_pipe_recaptcha_shortcode_handler() {
        ob_start();
        require 'recaptcha.php';
        return ob_get_clean();
    }

    public function check_is_cf7_pipe_recaptcha_verified($cf7, &$abort, $submission) {

        $pipe_recaptcha_verify_id = $submission->get_posted_data('pipe-recaptcha-verify-id');
        $properties = $cf7->get_properties();

        if (empty($pipe_recaptcha_verify_id)||(strpos($properties['form'], 'pipe_recaptcha')!==false&&!$this->is_user_or_user_ip_matched_with_verify_id($pipe_recaptcha_verify_id))) {
            $cf7->skip_mail = true;
            $abort = true;
            $submission->set_status( 'validation_failed' );
            $submission->set_response( $cf7->message( 'validation_error' ) ); //msg from admin settings;
            $submission->set_response( $cf7->filter_message(__('ReCaptcha verification failed, please try again!', 'pipe-recaptcha')) ); //custom msg;
        }

        return $cf7;
    }

    public function is_user_or_user_ip_matched_with_verify_id($verify_id)
    {
        $pr = new pipeRecaptcha();
        $user = $pr->getCookie();
        $user_ip = $pr->get_client_ip();

        global $wpdb;
        $verification = $wpdb->get_results("SELECT verify_id, verified_at FROM {$wpdb->prefix}rc_pipe_recaptcha_logs WHERE user='{$user}' OR ip='{$user_ip}'");
        if (!empty($verification)&&isset($verification[0])){
            $verified_at = $verification[0]->verified_at;
            if ( (strtotime("now")- strtotime($verified_at)) < 30 && $verification[0]->verify_id==$verify_id){
                $wpdb->update(
                    "{$wpdb->prefix}rc_pipe_recaptcha_logs",
                    array(
                        'verify_id' => '',
                    ),
                    array( 'user' => $user, 'ip' => $user_ip ),
                    array(
                        '%s',
                    ),
                    array( '%s', '%s' )
                );
                return true;
            }
        }

        return false;

    }


    public function pipe_recaptcha_html(){
        echo $this->rc_pipe_recaptcha_shortcode_handler();
    }

    public function pipe_recaptcha_validation_on_login($user)
    {
        if (isset($_POST['pipe-recaptcha-verify-id'])) {
            $verify_id = isset($_POST['pipe-recaptcha-verify-id']) ? sanitize_text_field($_POST['pipe-recaptcha-verify-id']) : "";
            if (empty($verify_id) || !$this->is_user_or_user_ip_matched_with_verify_id($verify_id)) {
                $user = new WP_Error('loginCaptchaError2', __('ReCaptcha verification failed, please try again!', 'pipe-recaptcha'));
            }
        }

        return $user;
    }

    public function verify_pipe_recaptcha( $user_login, $user_email, $errors ) {
        if (isset($_POST['pipe-recaptcha-verify-id'])){
            $verify_id = isset($_POST['pipe-recaptcha-verify-id']) ? sanitize_text_field($_POST['pipe-recaptcha-verify-id']) : "";
            if (empty($verify_id)||!$this->is_user_or_user_ip_matched_with_verify_id($verify_id)) {
                $errors->add('loginCaptchaError', __('ReCaptcha verification failed, please try again!', 'pipe-recaptcha'));
            }
        }
    }


    public function verify_comment_meta_data( $commentdata ) {
        if (isset($_POST['pipe-recaptcha-verify-id'])){
            $verify_id = isset($_POST['pipe-recaptcha-verify-id']) ? sanitize_text_field($_POST['pipe-recaptcha-verify-id']) : "";
            if (empty($verify_id)||!$this->is_user_or_user_ip_matched_with_verify_id($verify_id)) {
                wp_die(__('ReCaptcha verification failed, please try again!', 'pipe-recaptcha'));
            }
        }


        return $commentdata;
    }

    public function settings_page() {
        require PR_Plugin_DIR_Path . '/includes/settings-page.php';
    }

    public function add_pipe_recaptcha_options_page() {
        add_options_page(
            'Pipe ReCaptcha',
            __('Pipe ReCaptcha', "pipe-recaptcha"),
            'manage_options',
            'pipe_recaptcha',
            array($this, 'settings_page')
        );
    }

    
    public function recaptcha_container()
    {
        ?>
        <div class="pipe-recaptcha-section">
            <div class="rc-pipe-recaptcha" style="display: none;">
                <div class="rc-pipe-recaptcha-arrow"></div>
                <div class="rc-pipe-recaptcha-arrow-bubble"></div>
                <div class="rc-pipe-recaptcha-container" style="background-image: url(<?php echo PR_Plugin_DIR_URL;?>/assets/images/bg.png); background-size: 90px; background-repeat: repeat;">
                    <div class="rc-pipe-recaptcha-city">
                        <img src="<?php echo PR_Plugin_DIR_URL;?>/assets/images/city.png" alt="city">
                    </div>
                    <div class="pipe-rc-puzzle-canvas"></div>
                    <div class="rc-pipe-recaptcha-water">
                        <img src="<?php echo PR_Plugin_DIR_URL;?>/assets/images/water.png" alt="water">
                    </div>
                </div>
                <div class="verify-button-holder">
                    <div class="pipe-rc-verify-error"><?php _e('Please place all pipes correctly', 'pipe-recaptcha'); ?></div>
                    <button class="pipe-rc-button-default" id="pipe-rc-verify-button"><?php _e('Verify', 'pipe-recaptcha'); ?></button>
                    <a class="pipe-recaptcha-button pipe-rc-tutorial-info" id="pipe-rc-tutorial-info" data-pr-tooltip="<?php _e('Rotate and place the pipes correctly to help the city\'s water supply.', 'pipe-recaptcha'); ?>" style="background-image: url(<?php echo PR_Plugin_DIR_URL;?>assets/images/question.svg);" data-flow="bottom" href="#"></a>
                    <button class="pipe-recaptcha-button pipe-rc-button-new-challenge" id="pipe-rc-new-challenge-button" title="Get a new puzzle" style="background-image: url(<?php echo PR_Plugin_DIR_URL;?>assets/images/reload.png);"></button>
                </div>
            </div>
        </div>
        <?php
    }
}