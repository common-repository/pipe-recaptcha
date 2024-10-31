<style>
    #wpwrap {
        background-color: #fff;
    }
    #pipe-recaptcha-settings-container .label {
        font-size: 16px;
        color: #555;
        text-transform: capitalize;
        display: block;
        margin-bottom: 5px;
    }

    #pipe-recaptcha-settings-container .radio-container, #pipe-recaptcha-settings-container .checkbox-container {
        display: inline-block;
        position: relative;
        padding-left: 26px;
        cursor: pointer;
        font-size: 16px;
        color: #666;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        margin-right: 10px;
    }

    #pipe-recaptcha-settings-container .radio-container input, #pipe-recaptcha-settings-container .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    #pipe-recaptcha-settings-container .radio-container input:checked ~ .checkmark {
        background-color: #e5e5e5;
    }

    #pipe-recaptcha-settings-container .radio-container input:checked ~ .checkmark:after, #pipe-recaptcha-settings-container .checkbox-container input:checked ~ .checkmark:after {
        display: block;
    }

    #pipe-recaptcha-settings-container .radio-container .checkmark:after {
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        width: 12px;
        height: 12px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        background: #57b846;
    }

    #pipe-recaptcha-settings-container .checkmark {
        position: absolute;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        transform: translateY(-50%);
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #e5e5e5;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        -webkit-box-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.08);
        -moz-box-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.08);
        box-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.08);
    }

    #pipe-recaptcha-settings-container .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    #pipe-recaptcha-settings-container .checkbox-container input:checked ~ .checkmark::after {
        display: block;
        border: solid #57b846;
        border-width: 0 3px 3px 0;
        display: inline-block;
        padding: 3px;
        transform: rotate(45deg);
        -webkit-transform: rotate(40deg);
        height: 8px;
        position: relative;
        left: 5px;
    }
    #pipe-recaptcha-settings-container .checkbox-container .checkmark {
        position: absolute;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        transform: translateY(-50%);
        left: 0px;
        height: 20px;
        width: 20px;
        background-color: #e5e5e5;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 4px;
        -webkit-box-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.08);
        -moz-box-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.08);
        box-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.08);
    }

    #pipe-recaptcha-settings-container .input-group {
        position: relative;
        margin-bottom: 30px;
    }

    #pipe-recaptcha-settings-container .input-group-icon {
        position: relative;
    }

    #pipe-recaptcha-settings-container .input-icon {
        position: absolute;
        font-size: 18px;
        color: #999;
        right: 18px;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        transform: translateY(-50%);
        cursor: pointer;
    }
    #pipe-recaptcha-settings-container .title {
        font-size: 27px;
        color: #525252;
        font-weight: 500;
        margin-bottom: 30px;
        line-height: 1.3;
    }

    #pipe-recaptcha-settings-container .badge{
        display:inline-block;padding:.25em .4em;font-size:75%;font-weight:700;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out
    }

    @media (prefers-reduced-motion:reduce){
        #pipe-recaptcha-settings-container .badge{
            transition:none
        }
    }
    #pipe-recaptcha-settings-container .badge-dark{
        color:#fff;background-color:#343a40
    }

    #pipe-recaptcha-settings-container a.badge-dark:focus,a.badge-dark:hover{
        color:#fff;background-color:#1d2124
    }

    #pipe-recaptcha-settings-container a.badge-dark.focus,a.badge-dark:focus{
        outline:0;box-shadow:0 0 0 .2rem rgba(52,58,64,.5)
    }
    #pipe-recaptcha-settings-container .badge.badge-dark.version {
        font-size: 14px;
        margin-left: 10px;
        position: relative;
        top: -4px;
    }
    #pipe-recaptcha-settings-container .label.input-label {
        font-size: 17px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    #save-pipe-recaptcha-settings {
        background: #1a73e8;
        border: 0;
        border-radius: 2px;
        color: #fff;
        cursor: pointer;
        font-family: Roboto,helvetica,arial,sans-serif;
        font-size: 14px;
        font-weight: 500;
        height: 36px;
        line-height: 37px;
        min-width: 90px;
        padding: 0 10px 0 10px;
        text-align: center;
        text-transform: uppercase;
        transition: all 0.5s ease;
    }

    @keyframes spinner {
        to {transform: rotate(360deg);}
    }

    .rcpr_spinner::before {
        content: '';
        box-sizing: border-box;
        position: absolute;
        /* top: 50%; */
        /* left: 50%; */
        width: 27px;
        height: 27px;
        margin-top: 4px;
        margin-left: 10px;
        border-radius: 50%;
        border: 2px solid #fff;
        border-top-color: #4272d7;
        animation: spinner 0.7s linear infinite;
        border-right-color: #4272d7;
    }

    .rcpr_spinner{
        display: none;
    }
    .rcpr_saved_badge {
        font-size: 15px !important;
        background-color: #23aa23;
        color: #fff;
        margin-left: 10px;
        display: none;
    }
    .badgeHidden{
        display: none !important;
    }
    #pipe-recaptcha-settings-container .inside {
        margin-bottom: 30px;
    }
    #pipe-recaptcha-settings-container #rcpr-shortcode {
        width: 350px;
        display: block;
    }


</style>
<?php
    $defaults = array('contactForm7', 'loginForm', 'registrationForm', 'commentsForm');
    $difficultyDefaults = array('normal');
?>
<div id="pipe-recaptcha-settings-container">
    <div class="pipe-recaptcha-settings-title">
        <h2 class="title"><?php _e('Pipe ReCaptcha', 'pipe-recaptcha'); ?><span class="badge badge-dark version">v<?php echo Pipe_Recaptcha_Version; ?></span></h2>
    </div>

    <div class="inside">
        <p class="description">
            <label for="rcpr-shortcode"><?php _e('Copy this shortcode and paste it into your contact form 7:', 'pipe-recaptcha'); ?></label>
            <span class="shortcode wp-ui-highlight"><input type="text" id="rcpr-shortcode" onfocus="this.select();" readonly="readonly" class="large-text code" value="[pipe_recaptcha]"></span>
        </p>
    </div>
    <div class="input-group">
        <label class="label input-label"><?php _e('Pipe ReCaptcha status', 'pipe-recaptcha'); ?></label>
        <div class="p-t-10">
            <label class="radio-container m-r-45"><?php _e('Enabled', 'pipe-recaptcha'); ?>
                <input type="radio" <?php echo get_option('pipeRecaptchaStatus', 'enabled')=="enabled" ? 'checked="checked"' : ''; ?>  name="pipeRecaptchaStatus" value="enabled">
                <span class="checkmark"></span>
            </label>
            <label class="radio-container"><?php _e('Disabled', 'pipe-recaptcha'); ?>
                <input type="radio" <?php echo get_option('pipeRecaptchaStatus', 'enabled')=="disabled" ? 'checked="checked"' : ''; ?> name="pipeRecaptchaStatus" value="disabled">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>

    <div class="input-group">
        <label class="label input-label"><?php _e('Activate Pipe ReCaptcha in', 'pipe-recaptcha'); ?></label>
        <div class="p-t-10">
            <label class="checkbox-container m-r-45"><?php _e('Contact form 7', 'pipe-recaptcha'); ?>
                <input type="checkbox" name="contactForm7" <?php echo in_array('contactForm7', get_option('PR_activated_in', $defaults)) ? 'checked="checked"' : ''; ?>>
                <span class="checkmark"></span>
            </label>
            <label class="checkbox-container"><?php _e('Login form', 'pipe-recaptcha'); ?>
                <input type="checkbox" name="loginForm" <?php echo in_array('loginForm', get_option('PR_activated_in', $defaults)) ? 'checked="checked"' : ''; ?>>
                <span class="checkmark"></span>
            </label>
            <label class="checkbox-container"><?php _e('Registration form', 'pipe-recaptcha'); ?>
                <input type="checkbox" name="registrationForm" <?php echo in_array('registrationForm', get_option('PR_activated_in', $defaults)) ? 'checked="checked"' : ''; ?>>
                <span class="checkmark"></span>
            </label>
            <label class="checkbox-container"><?php _e('Comments form', 'pipe-recaptcha'); ?>
                <input type="checkbox" name="commentsForm" <?php echo in_array('commentsForm', get_option('PR_activated_in', $defaults)) ? 'checked="checked"' : ''; ?>>
                <span class="checkmark"></span>
            </label>
            <label class="checkbox-container"><?php _e('Logged-in Comments form', 'pipe-recaptcha'); ?>
                <input type="checkbox" name="loggedInCommentsForm" <?php echo in_array('loggedInCommentsForm', get_option('PR_activated_in', $defaults)) ? 'checked="checked"' : ''; ?>>
                <span class="checkmark"></span>
            </label>
        </div>
    </div>

    <div class="input-group">
        <label class="label input-label"><?php _e('ReCaptcha Difficulty', 'pipe-recaptcha'); ?></label>
        <div class="p-t-10">
            <label class="checkbox-container m-r-45"><?php _e('Normal', 'pipe-recaptcha'); ?>
                <input type="checkbox" checked="checked" name="level_normal" <?php echo in_array('normal', get_option('pipeRecaptchaDifficulty', $difficultyDefaults)) ? 'checked="checked"' : ''; ?>>
                <span class="checkmark"></span>
            </label>
            <label class="checkbox-container"><?php _e('Medium', 'pipe-recaptcha'); ?>
                <input type="checkbox" name="level_medium" <?php echo in_array('medium', get_option('pipeRecaptchaDifficulty', $difficultyDefaults)) ? 'checked="checked"' : ''; ?>>
                <span class="checkmark"></span>
            </label>
            <label class="checkbox-container"><?php _e('Hard', 'pipe-recaptcha'); ?>
                <input type="checkbox" name="level_hard" <?php echo in_array('hard', get_option('pipeRecaptchaDifficulty', $difficultyDefaults)) ? 'checked="checked"' : ''; ?>>
                <span class="checkmark"></span>
            </label>
        </div>
    </div>


    <button class="save-pipe-recaptcha-settings" id="save-pipe-recaptcha-settings"><?php _e('Save', 'pipe-recaptcha'); ?></button><span class="rcpr_spinner"></span><span class="badge badge-green rcpr_saved_badge badgeHidden"><?php _e('Saved!', 'pipe-recaptcha'); ?></span>

</div>

<script>
    (function ($) {
        'use strict';

        $(document).on("click", "#save-pipe-recaptcha-settings", function () {
            var recaptchaStatus = $('[name="pipeRecaptchaStatus"]:checked').val();
            var recaptchaIn = [];
            var recaptchaDifficulty = [];
            if ($('[name="contactForm7"]').is(':checked')){
                recaptchaIn.push('contactForm7');
            }
            if ($('[name="loginForm"]').is(':checked')){
                recaptchaIn.push('loginForm');
            }
            if ($('[name="registrationForm"]').is(':checked')){
                recaptchaIn.push('registrationForm');
            }
            if ($('[name="commentsForm"]').is(':checked')){
                recaptchaIn.push('commentsForm');
            }
            if ($('[name="loggedInCommentsForm"]').is(':checked')){
                recaptchaIn.push('loggedInCommentsForm');
            }

            if ($('[name="level_normal"]').is(':checked')){
                recaptchaDifficulty.push('normal');
            }
            if ($('[name="level_medium"]').is(':checked')){
                recaptchaDifficulty.push('medium');
            }
            if ($('[name="level_hard"]').is(':checked')){
                recaptchaDifficulty.push('hard');
            }

            var datas = {
                'action': 'save_pipe_recaptcha_settings',
                'recaptchaStatus': recaptchaStatus,
                'recaptchaIn': recaptchaIn,
                'recaptchaDifficulty': recaptchaDifficulty,
                'rc_nonce': rcpr.nonce,
            };

            $.ajax({
                url: rcpr.ajax_url,
                data: datas,
                type: 'post',
                dataType: 'json',

                beforeSend: function () {
                    $('.rcpr_spinner').show()
                },
                success: function (r) {
                    if (r.success) {
                        $('.rcpr_spinner').hide()
                        $('.rcpr_saved_badge').removeClass('badgeHidden')

                        setTimeout(function(){
                            $('.rcpr_saved_badge').addClass('badgeHidden')
                        }, 5000);


                    } else {
                        console.log('Something went wrong, please try again!');
                    }

                }, error: function () {

                }
            });


        });
    })(jQuery);
</script>
