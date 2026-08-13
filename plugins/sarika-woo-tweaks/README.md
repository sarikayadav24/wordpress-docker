# Sarika WooCommerce Tweaks

A custom WooCommerce plugin that enhances the default WooCommerce behaviour using WordPress hooks and filters — without modifying any core files.

## Features

### Sale Badge
- Replaces the default "Sale!" text with a calculated percentage e.g. `-25% OFF`
- Works for both simple and variable products

### Custom Add to Cart Button Text
- Changes button text based on product type
- Simple product → `🛒 Add to Cart`
- Variable product → `🔍 Select Options`
- Out of stock → `⚠️ Out of Stock`
- External product → `🔗 Buy Now`

### Low Stock Warning
- Shows `🔥 Only X left in stock — order soon!` on product pages
- Triggers when stock quantity is 5 or fewer

### Delivery Notice
- Displays a delivery info box on all single product pages
- Free shipping, easy returns, secure checkout, fast dispatch

### Cart Free Shipping Notice
- Shows how much more the customer needs to spend to get free shipping
- Turns green with a success message when threshold is reached

### Login to See Price
- Hides product prices for non-logged-in users
- Replaces Add to Cart button with a login prompt for guests

## Tech Stack
- PHP
- WordPress Hooks (`add_action`, `add_filter`)
- WooCommerce API
- CSS3

## Plugin Structure
```
sarika-woo-tweaks/
├── sarika-woo-tweaks.php       # Main plugin file
├── includes/
│   ├── sale-badge.php          # Custom % OFF sale badge
│   ├── cart-button.php         # Custom button text + low stock
│   ├── product-notice.php      # Delivery notice + cart notice
│   └── price-login.php         # Login to see price
└── assets/
    └── woo-tweaks.css          # All styles
```

## Installation
1. Download or clone this repository
2. Upload the `sarika-woo-tweaks` folder to `/wp-content/plugins/`
3. Make sure **WooCommerce** is installed and active
4. Go to **Plugins → Installed Plugins** in WordPress admin
5. Activate **Sarika WooCommerce Tweaks**
6. All tweaks are applied automatically — no configuration needed

## Requirements
- WordPress 5.0+
- WooCommerce 5.0+
- PHP 7.4+

## Author
**Sarika Yadav**
- GitHub: [github.com/sarikayadav24](https://github.com/sarikayadav24)
- Email: sarika86.yadav@gmail.com
