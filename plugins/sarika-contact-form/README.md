# Sarika Contact Form

A custom WordPress contact form plugin that saves messages to the database and sends email notifications — built without any third-party libraries.

## Features
- Shortcode `[sarika_contact_form]` — add form to any page
- Saves all submissions to a custom database table
- Email notification sent to admin on every new message
- Reply-To header set to the sender's email
- Success and error messages after submission
- Security — nonce verification on every submission
- Input sanitization and validation
- Admin panel to view, mark as read and delete messages
- Unread message count displayed in admin
- Fully styled dark form matching portfolio theme

## Tech Stack
- PHP
- MySQL (via `$wpdb`)
- WordPress Hooks and Shortcodes
- HTML5 / CSS3

## Plugin Structure
```
sarika-contact-form/
├── sarika-contact-form.php     # Main plugin file
├── includes/
│   ├── shortcode.php           # Renders the contact form
│   ├── form-handler.php        # Processes form submission
│   └── admin-page.php          # Admin messages panel
└── assets/
    └── contact-form.css        # Form styles
```

## Installation
1. Download or clone this repository
2. Upload the `sarika-contact-form` folder to `/wp-content/plugins/`
3. Go to **Plugins → Installed Plugins** in WordPress admin
4. Activate **Sarika Contact Form**
5. Create a new page and add shortcode: `[sarika_contact_form]`
6. Visit the page to see the form

## Usage
Add this shortcode to any WordPress page or post:
```
[sarika_contact_form]
```

## Admin Panel
After activation go to **Contact Messages** in the WordPress admin sidebar to:
- View all submitted messages
- Mark messages as read
- Delete messages

## Author
**Sarika Yadav**
- GitHub: [github.com/sarikayadav24](https://github.com/sarikayadav24)
- Email: sarika86.yadav@gmail.com
