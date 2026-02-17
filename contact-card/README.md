# Contact Card WordPress Plugin

A professional WordPress plugin for displaying customizable contact cards with QR codes and vCard downloads.

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![WordPress](https://img.shields.io/badge/wordpress-5.8%2B-blue.svg)
![PHP](https://img.shields.io/badge/php-7.4%2B-purple.svg)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)

## Features

- **Multiple Display Methods:** Shortcode, Widget, and Gutenberg Block
- **QR Code Generation:** Local, privacy-focused QR code generation
- **vCard Download:** One-click contact download in VCF format
- **Theme Customization:** Colors, fonts, and border radius
- **Logo Upload:** WordPress Media Library integration
- **Responsive Design:** Mobile-friendly out of the box
- **Multilingual:** Translation-ready with Polish included
- **Security First:** All inputs sanitized, all outputs escaped

## Installation

### From ZIP File

1. Download the plugin ZIP file
2. Go to WordPress Admin > Plugins > Add New > Upload Plugin
3. Choose the ZIP file and click "Install Now"
4. Activate the plugin
5. Go to Settings > Contact Card to configure

### Manual Installation

1. Upload the `contact-card` folder to `/wp-content/plugins/`
2. Activate the plugin through the Plugins menu
3. Configure in Settings > Contact Card

### Building from Source

If you're developing or need to build the Gutenberg block:

```bash
cd contact-card/blocks
npm install
npm run build
```

## Usage

### Shortcode

Add the contact card to any page or post:

```
[contact_card]
```

### Widget

1. Go to Appearance > Widgets
2. Add "Contact Card" widget to desired sidebar
3. Optionally set a title
4. Save

### Gutenberg Block

1. In the block editor, click the "+" button
2. Search for "Contact Card"
3. Insert the block
4. Use the sidebar panel to toggle display options

## Configuration

### Contact Information

Navigate to **Settings > Contact Card > Contact Information** to set:

- Full name (with first, middle, last breakdown)
- Job title and company
- Phone number (with country code)
- Email address
- Website (display text and URL)
- Full address
- Social media links

### Logo Upload

Navigate to **Settings > Contact Card > Logo** to:

- Upload logo via WordPress Media Library
- Set fallback text when no logo is present
- Preview logo display

### Theme Customization

Navigate to **Settings > Contact Card > Theme** to customize:

- **Primary Color:** Main accent color (default: gold #ffd700)
- **Secondary Color:** Background color (default: dark #121212)
- **Accent Color:** Card background (default: #1a1a1a)
- **Text Color:** Main text (default: white #ffffff)
- **Font Family:** Choose from 6 standard web fonts
- **Border Radius:** Rounded corners (default: 10px)

### Display Options

Navigate to **Settings > Contact Card > Display Options** to toggle:

- Show/hide logo
- Show/hide QR code
- Show/hide vCard download button
- Show/hide social media links

## Technical Details

### Requirements

- WordPress 5.8 or higher
- PHP 7.4 or higher
- Modern browser with JavaScript enabled

### File Structure

```
contact-card/
├── contact-card.php           # Main plugin file
├── uninstall.php             # Cleanup on deletion
├── readme.txt                # WordPress.org readme
├── README.md                 # This file
├── includes/
│   ├── class-contact-card.php      # Main orchestration
│   ├── class-settings.php          # Settings management
│   └── class-vcard-generator.php   # vCard generation
├── admin/
│   ├── class-admin.php             # Admin coordinator
│   ├── class-settings-page.php     # Settings UI
│   ├── css/admin-style.css
│   └── js/admin-script.js
├── public/
│   ├── class-renderer.php          # HTML rendering
│   ├── class-shortcode.php         # Shortcode handler
│   ├── class-widget.php            # Widget class
│   ├── css/contact-card.css
│   └── js/
│       ├── qrcode.min.js          # QR library
│       └── contact-card.js        # Frontend logic
├── blocks/
│   ├── class-blocks.php            # Block registration
│   ├── contact-card-block/
│   │   ├── index.js               # Block entry
│   │   ├── edit.js                # Editor component
│   │   └── block.json             # Block metadata
│   ├── package.json
│   └── build/                     # Compiled assets
└── languages/
    ├── contact-card.pot           # Translation template
    └── contact-card-pl_PL.po      # Polish translation
```

### Security Features

- All user inputs are sanitized using WordPress functions
- All outputs are escaped to prevent XSS
- Nonce verification on all forms
- Capability checks on admin pages
- No direct file access (ABSPATH checks)
- No SQL queries (uses Options API)
- Local QR code generation (no external services)

### Data Storage

All settings are stored in a single WordPress option: `contact_card_settings`

The option contains:
- Contact information array
- Logo settings array
- Theme settings array
- Display options array

Data is completely removed when the plugin is uninstalled.

## Translation

The plugin is translation-ready and includes Polish translation.

### Adding New Languages

1. Use a tool like Poedit or Loco Translate
2. Create a new PO file from `languages/contact-card.pot`
3. Translate all strings
4. Compile to MO file
5. Place in `languages/` directory

## Development

### Coding Standards

- Follows WordPress Coding Standards
- PHPDoc comments on all classes and methods
- Semantic HTML5
- Modern JavaScript (ES6+)
- CSS with custom properties for theming

### Hooks & Filters

The plugin is designed to be extensible. Future versions may add filters for:
- Contact card HTML output
- vCard content
- QR code settings
- Display options

## Changelog

### 1.0.0 - 2026-02-17

- Initial release
- Shortcode support: `[contact_card]`
- WordPress widget
- Gutenberg block with display controls
- QR code generation (local, no external services)
- vCard download in VCF format
- Logo upload via Media Library
- Full theme customization (colors, fonts)
- Address and social media fields
- Polish translation
- Complete security hardening
- Responsive mobile design

## Support

For support, bug reports, or feature requests:

- **Issues:** [GitHub Issues](https://github.com/Blu8print/contact-card-wp-plugin/issues)
- **Documentation:** See readme.txt for WordPress.org documentation

## License

This plugin is licensed under the GPL v2 or later.

```
Contact Card WordPress Plugin
Copyright (C) 2026

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## Credits

- **Developer:** Sebastiaan Castenmiller (Blueprint 8)
- **QRCode.js:** QR code generation library
- **WordPress:** Built on the WordPress platform

## Author

**Sebastiaan Castenmiller**
Blueprint 8
[https://blu8print.nl](https://blu8print.nl)

---

Made with ❤️ for the WordPress community by [Blueprint 8](https://blu8print.com)
