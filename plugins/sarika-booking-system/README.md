# Sarika Booking System

A multi-step appointment booking WordPress plugin with AJAX form submission, database storage and a full admin management panel.

## Features

### Multi-Step Booking Form
- **Step 1** — Select a service from a visual card grid
- **Step 2** — Pick a date and time slot
- **Step 3** — Enter personal details (name, email, phone, notes)
- **Step 4** — Review and confirm booking summary

### AJAX Submission
- Form submits without page reload
- Real-time success and error messages
- Loading state on submit button prevents double clicks

### Security
- WordPress nonce verification on every request
- All inputs sanitized and validated server-side
- Email format validation
- Past date validation

### Email Notifications
- Admin receives email on every new booking
- Customer receives confirmation email with booking details

### Admin Management Panel
- Stats dashboard — Total, Pending, Confirmed, Cancelled counts
- Full bookings table with all details
- One-click Confirm / Cancel status updates
- Delete bookings with confirmation prompt
- Color-coded status badges

### Frontend
- Animated progress bar showing current step
- Step indicator dots with active and completed states
- Fade-in animation between steps
- Fully responsive — works on mobile

## Shortcode
```
[sarika_booking]
```
Add to any WordPress page to display the booking form.

## Tech Stack
- PHP
- MySQL (via `$wpdb`)
- JavaScript (Vanilla JS, XMLHttpRequest AJAX)
- CSS3 (Animations, Flexbox, Grid)
- WordPress Hooks, Shortcodes, AJAX API

## Plugin Structure
```
sarika-booking-system/
├── sarika-booking-system.php   # Main plugin file
├── includes/
│   ├── database.php            # Creates wp_sbs_bookings table
│   ├── shortcode.php           # Renders the 4-step form
│   ├── ajax-handler.php        # Processes AJAX booking submission
│   └── admin-page.php          # Admin bookings management panel
└── assets/
    ├── booking.css             # All form and UI styles
    └── booking.js              # Step navigation and AJAX logic
```

## Installation
1. Download or clone this repository
2. Upload the `sarika-booking-system` folder to `/wp-content/plugins/`
3. Go to **Plugins → Installed Plugins** in WordPress admin
4. Activate **Sarika Booking System**
5. A new database table `wp_sbs_bookings` is created automatically
6. Create a new page and add shortcode: `[sarika_booking]`
7. Visit the page to see the booking form

## Admin Panel
After activation go to **Bookings** in the WordPress admin sidebar to manage all appointments.

## Requirements
- WordPress 5.0+
- PHP 7.4+
- MySQL 5.6+

## Author
**Sarika Yadav**
- GitHub: [github.com/sarikayadav24](https://github.com/sarikayadav24)
- Email: sarika86.yadav@gmail.com
