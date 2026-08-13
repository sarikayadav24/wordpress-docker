<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function sbs_render_booking_form( $atts ) {
    ob_start();

    $services = array(
        'wordpress-theme' => 'Custom WordPress Theme',
        'woocommerce'     => 'WooCommerce Store Setup',
        'plugin-dev'      => 'Custom Plugin Development',
        'website-fix'     => 'WordPress Bug Fix',
        'seo-setup'       => 'SEO & Speed Optimization',
    );

    $time_slots = array(
        '09:00 AM', '10:00 AM', '11:00 AM',
        '12:00 PM', '02:00 PM', '03:00 PM',
        '04:00 PM', '05:00 PM',
    );
    ?>

    <div class="sbs-wrapper" id="sbs-wrapper">

        <div class="sbs-progress">
            <div class="sbs-progress-bar" id="sbs-progress-bar"></div>
        </div>

        <div class="sbs-steps-indicator">
            <div class="sbs-step-dot active" data-step="1">
                <span class="dot-number">1</span>
                <span class="dot-label">Service</span>
            </div>
            <div class="sbs-step-dot" data-step="2">
                <span class="dot-number">2</span>
                <span class="dot-label">Date & Time</span>
            </div>
            <div class="sbs-step-dot" data-step="3">
                <span class="dot-number">3</span>
                <span class="dot-label">Your Details</span>
            </div>
            <div class="sbs-step-dot" data-step="4">
                <span class="dot-number">4</span>
                <span class="dot-label">Confirm</span>
            </div>
        </div>

        <!-- STEP 1 -->
        <div class="sbs-step" id="sbs-step-1">
            <h3 class="sbs-step-title">Select a Service</h3>
            <p class="sbs-step-desc">What can I help you with?</p>
            <div class="sbs-service-grid">
                <?php foreach ( $services as $value => $label ) : ?>
                    <div class="sbs-service-card" data-value="<?php echo esc_attr( $value ); ?>">
                        <span class="sbs-service-name"><?php echo esc_html( $label ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <input type="hidden" id="sbs-service" value="">
            <div class="sbs-nav">
                <span></span>
                <button class="sbs-btn sbs-btn-next" id="sbs-next-1">Next →</button>
            </div>
        </div>

        <!-- STEP 2 -->
        <div class="sbs-step hidden" id="sbs-step-2">
            <h3 class="sbs-step-title">Select Date & Time</h3>
            <p class="sbs-step-desc">Choose your preferred appointment slot</p>
            <div class="sbs-field">
                <label for="sbs-date">Preferred Date <span>*</span></label>
                <input type="date" id="sbs-date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>
            <div class="sbs-field">
                <label>Preferred Time <span>*</span></label>
                <div class="sbs-time-grid">
                    <?php foreach ( $time_slots as $time ) : ?>
                        <div class="sbs-time-slot" data-value="<?php echo esc_attr( $time ); ?>">
                            <?php echo esc_html( $time ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" id="sbs-time" value="">
            </div>
            <div class="sbs-nav">
                <button class="sbs-btn sbs-btn-back" id="sbs-back-2">← Back</button>
                <button class="sbs-btn sbs-btn-next" id="sbs-next-2">Next →</button>
            </div>
        </div>

        <!-- STEP 3 -->
        <div class="sbs-step hidden" id="sbs-step-3">
            <h3 class="sbs-step-title">Your Details</h3>
            <p class="sbs-step-desc">Tell me a bit about yourself</p>
            <div class="sbs-field">
                <label for="sbs-name">Full Name <span>*</span></label>
                <input type="text" id="sbs-name" placeholder="Enter your full name">
            </div>
            <div class="sbs-field">
                <label for="sbs-email">Email Address <span>*</span></label>
                <input type="email" id="sbs-email" placeholder="Enter your email">
            </div>
            <div class="sbs-field">
                <label for="sbs-phone">Phone Number <span>*</span></label>
                <input type="tel" id="sbs-phone" placeholder="Enter your phone number">
            </div>
            <div class="sbs-field">
                <label for="sbs-message">Additional Notes (Optional)</label>
                <textarea id="sbs-message" rows="4" placeholder="Any specific requirements?"></textarea>
            </div>
            <div class="sbs-nav">
                <button class="sbs-btn sbs-btn-back" id="sbs-back-3">← Back</button>
                <button class="sbs-btn sbs-btn-next" id="sbs-next-3">Next →</button>
            </div>
        </div>

        <!-- STEP 4 -->
        <div class="sbs-step hidden" id="sbs-step-4">
            <h3 class="sbs-step-title">Confirm Your Booking</h3>
            <p class="sbs-step-desc">Please review your booking details</p>
            <div class="sbs-summary">
                <div class="sbs-summary-row">
                    <span class="sbs-summary-label">Service</span>
                    <span class="sbs-summary-value" id="summary-service">—</span>
                </div>
                <div class="sbs-summary-row">
                    <span class="sbs-summary-label">Date</span>
                    <span class="sbs-summary-value" id="summary-date">—</span>
                </div>
                <div class="sbs-summary-row">
                    <span class="sbs-summary-label">Time</span>
                    <span class="sbs-summary-value" id="summary-time">—</span>
                </div>
                <div class="sbs-summary-row">
                    <span class="sbs-summary-label">Name</span>
                    <span class="sbs-summary-value" id="summary-name">—</span>
                </div>
                <div class="sbs-summary-row">
                    <span class="sbs-summary-label">Email</span>
                    <span class="sbs-summary-value" id="summary-email">—</span>
                </div>
                <div class="sbs-summary-row">
                    <span class="sbs-summary-label">Phone</span>
                    <span class="sbs-summary-value" id="summary-phone">—</span>
                </div>
            </div>
            <div id="sbs-message-box" class="sbs-message-box hidden"></div>
            <div class="sbs-nav">
                <button class="sbs-btn sbs-btn-back" id="sbs-back-4">← Back</button>
                <button class="sbs-btn sbs-btn-submit" id="sbs-submit">✅ Confirm Booking</button>
            </div>
        </div>

        <!-- SUCCESS -->
        <div class="sbs-success hidden" id="sbs-success">
            <div class="sbs-success-icon">✅</div>
            <h3>Booking Confirmed!</h3>
            <p>Thank you! Your appointment has been booked successfully.</p>
            <p>You will receive a confirmation email shortly.</p>
            <button class="sbs-btn sbs-btn-next" id="sbs-book-another">Book Another Appointment</button>
        </div>

    </div>

    <?php
    return ob_get_clean();
}
add_shortcode( 'sarika_booking', 'sbs_render_booking_form' );
