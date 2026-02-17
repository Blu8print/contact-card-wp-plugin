# Contact Card Plugin - Setup Guide

## Quick Start

### 1. Install the Plugin

Copy the `contact-card` folder to your WordPress `wp-content/plugins/` directory, then activate it in WordPress Admin > Plugins.

### 2. Build the Gutenberg Block (Required)

The Gutenberg block needs to be compiled before use:

```bash
cd wp-content/plugins/contact-card/blocks
npm install
npm run build
```

**Note:** You need Node.js 14+ installed. If you don't have it, download from https://nodejs.org/

### 3. Configure Your Contact Information

1. Go to **Settings > Contact Card** in WordPress admin
2. Fill in your contact information on the **Contact Information** tab
3. Click **Save Changes**

### 4. Add Your Logo (Optional)

1. Go to the **Logo** tab
2. Click **Upload Logo** and choose an image
3. Click **Save Changes**

### 5. Customize Theme (Optional)

1. Go to the **Theme** tab
2. Choose your colors using the color pickers
3. Select your preferred font
4. Click **Save Changes**

### 6. Set Display Options (Optional)

1. Go to the **Display Options** tab
2. Toggle which elements to show:
   - Show Logo
   - Show QR Code
   - Show vCard Button
   - Show Social Links
3. Click **Save Changes**

## How to Display the Contact Card

### Method 1: Shortcode

Add this to any page or post:

```
[contact_card]
```

### Method 2: Gutenberg Block

1. Edit a page/post in the block editor
2. Click the **+** button to add a block
3. Search for "Contact Card"
4. Insert the block
5. Use the sidebar panel to toggle display options for this specific block

### Method 3: Widget

1. Go to **Appearance > Widgets**
2. Find "Contact Card" in the available widgets
3. Drag it to your desired sidebar
4. Optionally add a title
5. Click **Save**

## Troubleshooting

### Shortcode not displaying

**Cause:** No contact information saved yet
**Solution:** Go to Settings > Contact Card and fill in at least the name field, then save

### Gutenberg block not appearing

**Cause:** Block not built yet
**Solution:** Run `npm install` and `npm run build` in the blocks directory

### Settings not saving

**Cause:** Was a bug (now fixed)
**Solution:** Update to latest version where sanitize method merges with existing settings

### QR code not generating

**Cause:** JavaScript not loaded or contact info empty
**Solution:**
1. Check browser console for errors
2. Ensure contact info is saved
3. Clear browser cache

### vCard download not working

**Cause:** JavaScript error or no contact info
**Solution:**
1. Open browser console (F12) and check for errors
2. Ensure at least name and phone/email are filled in

## Testing Checklist

After setup, verify:

- [ ] Contact info displays with shortcode `[contact_card]`
- [ ] QR code appears and is scannable with phone
- [ ] vCard downloads when clicking button
- [ ] Widget displays in sidebar
- [ ] Gutenberg block appears in editor
- [ ] Theme colors apply correctly
- [ ] Logo displays (if uploaded)
- [ ] Mobile responsive (test on phone)

## Development

### File Structure

```
contact-card/
├── contact-card.php          # Main plugin file
├── includes/                 # Core classes
├── admin/                    # Admin interface
├── public/                   # Frontend display
├── blocks/                   # Gutenberg block
│   ├── package.json
│   ├── build/               # Compiled JS (generated)
│   └── node_modules/        # Dependencies (generated)
└── languages/               # Translations
```

### Building for Development

For development with live reload:

```bash
cd blocks
npm run start
```

This watches for changes and rebuilds automatically.

### Making Changes

After modifying block files (edit.js, index.js), rebuild:

```bash
cd blocks
npm run build
```

## Support

If you encounter issues:

1. Check browser console for JavaScript errors (F12)
2. Enable WordPress debug mode: `define('WP_DEBUG', true);` in wp-config.php
3. Check WordPress error logs
4. Verify PHP version is 7.4+
5. Ensure WordPress is 5.8+

## Next Steps

- Customize colors to match your brand
- Add social media links
- Test QR code with multiple phones
- Share your contact card!
