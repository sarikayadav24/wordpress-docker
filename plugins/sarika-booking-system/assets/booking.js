document.addEventListener('DOMContentLoaded', function () {

    // ===========================
    // GET ALL ELEMENTS WE NEED
    // ===========================
    // Store references to all elements once at the top
    // This is faster than searching the DOM every time

    var currentStep = 1;   // track which step we're on
    var totalSteps  = 4;

    // All step panels
    var steps = document.querySelectorAll('.sbs-step');

    // Progress bar fill
    var progressBar = document.getElementById('sbs-progress-bar');

    // Step indicator dots
    var stepDots = document.querySelectorAll('.sbs-step-dot');

    // ===========================
    // HELPER FUNCTIONS
    // ===========================

    /**
     * Show a specific step, hide all others
     * @param {number} stepNum - which step to show (1-4)
     */
    function showStep( stepNum ) {
        // Loop through all steps
        steps.forEach(function( step, index ) {
            if ( index + 1 === stepNum ) {
                step.classList.remove('hidden');  // show this step
            } else {
                step.classList.add('hidden');     // hide others
            }
        });

        // Update progress bar width
        // Step 1 = 25%, Step 2 = 50%, Step 3 = 75%, Step 4 = 100%
        var progress = ( stepNum / totalSteps ) * 100;
        progressBar.style.width = progress + '%';

        // Update step indicator dots
        stepDots.forEach(function( dot, index ) {
            var dotStep = index + 1;

            dot.classList.remove('active', 'completed');

            if ( dotStep === stepNum ) {
                dot.classList.add('active');       // current step
            } else if ( dotStep < stepNum ) {
                dot.classList.add('completed');    // past step
            }
        });

        currentStep = stepNum;
    }

    /**
     * Show an error message box
     * @param {string} message - error text to show
     */
    function showError( message ) {
        var box = document.getElementById('sbs-message-box');
        box.innerText    = '❌ ' + message;
        box.className    = 'sbs-message-box error';  // reset classes then add error
        box.classList.remove('hidden');
    }

    /**
     * Hide the message box
     */
    function hideError() {
        var box = document.getElementById('sbs-message-box');
        box.classList.add('hidden');
    }

    // ===========================
    // STEP 1 — SERVICE SELECTION
    // ===========================
    var serviceCards  = document.querySelectorAll('.sbs-service-card');
    var serviceInput  = document.getElementById('sbs-service');
    var nextBtn1      = document.getElementById('sbs-next-1');

    // When user clicks a service card
    serviceCards.forEach(function( card ) {
        card.addEventListener('click', function() {

            // Remove selected from all cards
            serviceCards.forEach(function(c) {
                c.classList.remove('selected');
            });

            // Add selected to clicked card
            card.classList.add('selected');

            // Store the value in hidden input
            // data-value attribute was set by PHP
            serviceInput.value = card.getAttribute('data-value');
        });
    });

    // When user clicks Next on step 1
    nextBtn1.addEventListener('click', function() {

        // Validate — must select a service
        if ( serviceInput.value === '' ) {
            alert('Please select a service to continue.');
            return;   // stop here, don't go to next step
        }

        showStep(2);  // go to step 2
    });

    // ===========================
    // STEP 2 — DATE & TIME
    // ===========================
    var timeSlots = document.querySelectorAll('.sbs-time-slot');
    var timeInput = document.getElementById('sbs-time');
    var dateInput = document.getElementById('sbs-date');
    var nextBtn2  = document.getElementById('sbs-next-2');
    var backBtn2  = document.getElementById('sbs-back-2');

    // When user clicks a time slot
    timeSlots.forEach(function( slot ) {
        slot.addEventListener('click', function() {

            // Remove selected from all slots
            timeSlots.forEach(function(s) {
                s.classList.remove('selected');
            });

            // Add selected to clicked slot
            slot.classList.add('selected');

            // Store value in hidden input
            timeInput.value = slot.getAttribute('data-value');
        });
    });

    // Next button on step 2
    nextBtn2.addEventListener('click', function() {

        // Validate date is selected
        if ( dateInput.value === '' ) {
            alert('Please select a date.');
            return;
        }

        // Validate time is selected
        if ( timeInput.value === '' ) {
            alert('Please select a time slot.');
            return;
        }

        showStep(3);
    });

    // Back button on step 2
    backBtn2.addEventListener('click', function() {
        showStep(1);
    });

    // ===========================
    // STEP 3 — PERSONAL DETAILS
    // ===========================
    var nameInput  = document.getElementById('sbs-name');
    var emailInput = document.getElementById('sbs-email');
    var phoneInput = document.getElementById('sbs-phone');
    var nextBtn3   = document.getElementById('sbs-next-3');
    var backBtn3   = document.getElementById('sbs-back-3');

    // Next button on step 3
    nextBtn3.addEventListener('click', function() {

        // Validate all fields
        if ( nameInput.value.trim() === '' ) {
            alert('Please enter your name.');
            return;
        }

        if ( emailInput.value.trim() === '' ) {
            alert('Please enter your email.');
            return;
        }

        // Basic email format check using regex
        // /pattern/  = regex in JavaScript
        // .test()    = returns true if pattern matches
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if ( ! emailPattern.test( emailInput.value ) ) {
            alert('Please enter a valid email address.');
            return;
        }

        if ( phoneInput.value.trim() === '' ) {
            alert('Please enter your phone number.');
            return;
        }

        // All valid — fill in the summary and go to step 4
        fillSummary();
        showStep(4);
    });

    // Back button on step 3
    backBtn3.addEventListener('click', function() {
        showStep(2);
    });

    // ===========================
    // FILL SUMMARY (Step 4)
    // ===========================

    /**
     * Fill the confirmation summary with user's selections
     * Gets the service label from the selected card's text
     */
    function fillSummary() {
        var selectedCard = document.querySelector('.sbs-service-card.selected');

        // .innerText gets the visible text of the element
        document.getElementById('summary-service').innerText =
            selectedCard ? selectedCard.innerText.trim() : serviceInput.value;

        document.getElementById('summary-date').innerText  = dateInput.value;
        document.getElementById('summary-time').innerText  = timeInput.value;
        document.getElementById('summary-name').innerText  = nameInput.value;
        document.getElementById('summary-email').innerText = emailInput.value;
        document.getElementById('summary-phone').innerText = phoneInput.value;
    }

    // ===========================
    // STEP 4 — SUBMIT BOOKING
    // ===========================
    var submitBtn = document.getElementById('sbs-submit');
    var backBtn4  = document.getElementById('sbs-back-4');
    var successEl = document.getElementById('sbs-success');
    var wrapper   = document.getElementById('sbs-wrapper');

    // Back button on step 4
    backBtn4.addEventListener('click', function() {
        hideError();
        showStep(3);
    });

    // Submit button — sends data via AJAX
    submitBtn.addEventListener('click', function() {

        // Disable button to prevent double clicks
        submitBtn.classList.add('loading');
        submitBtn.innerText = '⏳ Sending...';
        hideError();

        // ===========================
        // AJAX REQUEST
        // ===========================
        // XMLHttpRequest = built-in browser object for sending HTTP requests
        var xhr = new XMLHttpRequest();

        // 'POST' = sending data (not just fetching)
        // sbsData.ajaxUrl was set by wp_localize_script in PHP
        xhr.open( 'POST', sbsData.ajaxUrl, true );

        // Set header so server knows it's a form submission
        xhr.setRequestHeader(
            'Content-Type',
            'application/x-www-form-urlencoded'
        );

        // This function runs when response comes back from server
        xhr.onload = function() {

            // Re-enable button
            submitBtn.classList.remove('loading');
            submitBtn.innerText = '✅ Confirm Booking';

            if ( xhr.status === 200 ) {

                // Parse the JSON response from PHP
                var response = JSON.parse( xhr.responseText );

                if ( response.success ) {
                    // Hide the whole form and show success message
                    wrapper.querySelector('.sbs-progress').classList.add('hidden');
                    wrapper.querySelector('.sbs-steps-indicator').classList.add('hidden');
                    document.getElementById('sbs-step-4').classList.add('hidden');
                    successEl.classList.remove('hidden');

                } else {
                    // Show error message
                    showError( response.data.message );
                }

            } else {
                showError( 'Server error. Please try again.' );
            }
        };

        // Build the data string to send
        // encodeURIComponent makes values URL-safe
        var data = 'action=sbs_book'
            + '&nonce='   + encodeURIComponent( sbsData.nonce )
            + '&service=' + encodeURIComponent( serviceInput.value )
            + '&date='    + encodeURIComponent( dateInput.value )
            + '&time='    + encodeURIComponent( timeInput.value )
            + '&name='    + encodeURIComponent( nameInput.value )
            + '&email='   + encodeURIComponent( emailInput.value )
            + '&phone='   + encodeURIComponent( phoneInput.value )
            + '&message=' + encodeURIComponent(
                document.getElementById('sbs-message').value
            );

        // Send the request!
        xhr.send( data );
    });

    // ===========================
    // BOOK ANOTHER APPOINTMENT
    // ===========================
    var bookAnotherBtn = document.getElementById('sbs-book-another');

    bookAnotherBtn.addEventListener('click', function() {

        // Reset everything back to step 1

        // Clear all selections
        serviceCards.forEach(function(c) { c.classList.remove('selected'); });
        timeSlots.forEach(function(s) { s.classList.remove('selected'); });

        // Clear all input values
        serviceInput.value = '';
        dateInput.value    = '';
        timeInput.value    = '';
        nameInput.value    = '';
        emailInput.value   = '';
        phoneInput.value   = '';
        document.getElementById('sbs-message').value = '';

        // Show progress and indicators again
        wrapper.querySelector('.sbs-progress').classList.remove('hidden');
        wrapper.querySelector('.sbs-steps-indicator').classList.remove('hidden');

        // Hide success screen
        successEl.classList.add('hidden');

        // Go back to step 1
        showStep(1);
    });

});
