# Sarika Portfolio Manager

A custom WordPress plugin that manages portfolio projects using a Custom Post Type (CPT) with meta boxes, admin columns and shortcode display.

## Features

### Custom Post Type
- Registers a **Portfolio** post type with its own admin menu
- Supports title, content editor and featured image
- Custom URL structure: `/portfolio/project-name`
- Archive page at `/portfolio/`

### Portfolio Categories
- Custom taxonomy for grouping projects by category
- Hierarchical like standard WordPress categories

### Custom Meta Boxes
- **Live Project URL** — link to the live site
- **GitHub URL** — link to the repository
- **Technologies Used** — comma separated e.g. PHP, WordPress, CSS
- **Project Type** — Theme, Plugin, WooCommerce, Website, Other
- All data saved securely with nonce verification and sanitization

### Custom Admin Columns
- **Thumbnail** — featured image preview (60x60)
- **Type** — colored badge (purple=Theme, green=Plugin, etc.)
- **Technologies** — tag pills for each technology
- **GitHub** — clickable View link
- **Live URL** — clickable View link
- Sortable by Type and Date

### Frontend Shortcode
- Shortcode: `[sarika_portfolio]`
- Displays all projects in a responsive grid
- Supports count and type filter attributes
- Shows featured image, type badge, title, excerpt, tech tags, GitHub and Live links

## Shortcode Usage

Basic usage — shows all projects:
```
[sarika_portfolio]
```

Show only 3 projects:
```
[sarika_portfolio count="3"]
```

Filter by type:
```
[sarika_portfolio type="plugin"]
[sarika_portfolio type="theme"]
[sarika_portfolio type="woocommerce"]
```

## Tech Stack
- PHP
- WordPress CPT API
- WordPress Meta Boxes API
- WP_Query
- CSS3 (Grid, Flexbox, Animations)

## Plugin Structure
```
sarika-portfolio-manager/
├── sarika-portfolio-manager.php   # Main plugin file
├── includes/
│   ├── cpt.php                    # Register CPT and taxonomy
│   ├── meta-boxes.php             # Custom fields (add, render, save)
│   ├── shortcode.php              # Frontend grid display
│   └── admin-columns.php         # Custom admin list columns
└── assets/
    └── portfolio.css              # Frontend styles
```

## Installation
1. Download or clone this repository
2. Upload `sarika-portfolio-manager` folder to `/wp-content/plugins/`
3. Go to **Plugins → Installed Plugins** in WordPress admin
4. Activate **Sarika Portfolio Manager**
5. Go to **Settings → Permalinks → Save Changes** to flush rewrite rules
6. A **Portfolio** menu will appear in the admin sidebar

## Adding Projects
1. Go to **Portfolio → Add New Project**
2. Enter project title and description
3. Set a featured image (screenshot of the project)
4. Fill in the **Project Details** meta box:
   - Live URL, GitHub URL, Technologies, Project Type
5. Click **Publish**

## Displaying Projects
Add the shortcode to any page:
```
[sarika_portfolio]
```

## Requirements
- WordPress 5.0+
- PHP 7.4+

## Author
**Sarika Yadav**
- GitHub: [github.com/sarikayadav24](https://github.com/sarikayadav24)
- Email: sarika86.yadav@gmail.com
