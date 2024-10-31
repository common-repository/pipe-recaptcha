<div class="pipe-recaptcha-section">
    <input type="hidden" id="pipe-recaptcha-verify-id" name="pipe-recaptcha-verify-id">
    <div class="checkbox-container">
        <div class="rc-pipe-recaptcha-row checkbox-section">
            <div class="pipe-rc-verify-timeout"><?php _e('Verification expired! Please check the checkbox again!', 'pipe-recaptcha'); ?></div>
            <div class="rc-pipe-recaptcha-checkbox">
                <span class="rc-pipe-recaptcha-checkbox-rect"></span>
                <div class="loading-quarter-circle" style="display: none;"></div>
                <svg class="checkmark" style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"> <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/> <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
                <label class="rc-pipe-recaptcha-check-label" for="rc-pipe-recaptcha-check"><?php _e('I\'m not a auto bot', 'pipe-recaptcha'); ?></label>
            </div>
        </div>
    </div>
</div>

