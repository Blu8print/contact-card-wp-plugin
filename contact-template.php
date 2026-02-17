<?php
/**
 * Template Name: Contact Card Standalone
 * Description: A complete standalone template for displaying a contact card with QR code
 */

// Detect browser language
function getBrowserLanguage() {
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        return $lang;
    }
    return 'en'; // Default to English
}

$browser_language = getBrowserLanguage();
$is_polish = ($browser_language === 'pl');

// Text translations
$translations = array(
    'en' => array(
        'contact_information' => 'Contact Information',
        'name' => 'Name',
        'phone' => 'Phone',
        'email' => 'Email',
        'website' => 'Website',
        'add_to_contacts' => 'Add to Contacts',
        'scan_qr' => 'Scan this QR code with your phone',
        'card_created_for' => 'This contact card was created for',
        'back_to_site' => 'Back to Site',
        'all_rights_reserved' => 'All rights reserved',
        'home' => 'Home'
    ),
    'pl' => array(
        'contact_information' => 'Informacje Kontaktowe',
        'name' => 'Imię i nazwisko',
        'phone' => 'Telefon',
        'email' => 'Email',
        'website' => 'Strona www',
        'add_to_contacts' => 'Dodaj do kontaktów',
        'scan_qr' => 'Zeskanuj ten kod QR swoim telefonem',
        'card_created_for' => 'Ta wizytówka została stworzona dla',
        'back_to_site' => 'Powrót do strony',
        'all_rights_reserved' => 'Wszelkie prawa zastrzeżone',
        'home' => 'Strona główna'
    )
);

// Select language
$lang = $is_polish ? 'pl' : 'en';
$text = $translations[$lang];

// Contact Information - Edit these details as needed
$contact = array(
    'name' => 'Tomasz Maria Falkowski',
    'phone' => '+48502122799',
    'email' => 'tomasz@hipnodentysta.com',
    'website' => 'www.hipnodentysta.com',
    'website_url' => 'http://www.hipnodentysta.com'
);

// Custom header - This replaces get_header()
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc_html($contact['name']); ?> - <?php echo $is_polish ? 'Wizytówka' : 'Contact Card'; ?></title>
    <?php wp_head(); // Required for WordPress plugins and admin bar ?>
    
    <!-- Inline CSS -->
    <style>
    /**
     * Contact Card Styles - Black and Yellow Theme
     */
    
    /* Container */
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #121212;
        color: #fff;
    }
    
    /* Custom Header */
    .custom-header {
        background-color: #1a1a1a;
        padding: 20px 0;
        border-bottom: 2px solid #ffd700;
        text-align: center;
    }
    
    .custom-header h1 {
        margin: 0;
        color: #ffd700;
        font-size: 24px;
    }
    
    /* Contact Container */
    .contact-page-container {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #fff;
        background-color: #121212;
        max-width: 600px;
        margin: 30px auto;
        padding: 20px;
    }
    
    /* Logo Styles */
    .logo-container {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .logo-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .logo-placeholder span {
        color: #ffd700;
        font-size: 24px;
        font-weight: bold;
    }
    
    .logo-placeholder img {
        max-width: 100%;
        height: auto;
        border-radius: 50%;
    }
    
    /* Card Styles */
    .contact-card {
        border: 2px solid #ffd700;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.2);
        margin-bottom: 30px;
        background-color: #1a1a1a;
        text-align: center;
    }
    
    .contact-info {
        margin-bottom: 20px;
        display: inline-block;
        text-align: left;
    }
    
    .contact-info p {
        margin: 5px 0;
        font-size: 18px;
    }
    
    .label {
        font-weight: bold;
        margin-right: 10px;
        display: inline-block;
        width: 80px;
        color: #ffd700;
    }
    
    /* Button Styles */
    .contact-button {
        display: inline-block;
        background-color: #ffd700;
        color: #121212 !important;
        padding: 14px 35px;
        text-align: center;
        text-decoration: none;
        font-size: 18px;
        font-weight: bold;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        margin-top: 20px;
        transition: all 0.3s ease;
    }
    
    .contact-button:hover {
        background-color: #ffea00;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(255, 215, 0, 0.3);
    }
    
    /* QR Code Styles */
    .qr-code {
        text-align: center;
        margin: 30px 0;
    }
    
    #qrcode {
        margin: 0 auto;
        padding: 15px;
        background: white;
        border-radius: 10px;
        display: inline-block;
    }
    
    /* Footer Styles */
    .contact-footer {
        margin-top: 30px;
        font-size: 14px;
        color: #999;
        text-align: center;
    }
    
    /* Custom Footer */
    .custom-footer {
        background-color: #1a1a1a;
        padding: 20px 0;
        border-top: 2px solid #ffd700;
        text-align: center;
        margin-top: 40px;
    }
    
    .custom-footer p {
        margin: 5px 0;
        color: #999;
        font-size: 14px;
    }
    
    .custom-footer a {
        color: #ffd700;
        text-decoration: none;
    }
    
    .custom-footer a:hover {
        text-decoration: underline;
    }
    
    /* Typography */
    .contact-page-container h1 {
        color: #ffd700;
        text-align: center;
        margin-bottom: 30px;
    }
    
    .contact-page-container h3 {
        color: #ffd700;
    }
    
    .contact-page-container a {
        color: #ffd700;
        text-decoration: none;
    }
    
    .contact-page-container a:hover {
        text-decoration: underline;
    }
    
    /* Back to site link */
    .back-to-site {
        text-align: center;
        margin: 20px 0;
    }
    
    .back-to-site a {
        color: #ffd700;
        text-decoration: none;
        font-size: 16px;
    }
    
    .back-to-site a:hover {
        text-decoration: underline;
    }
    
    /* Button container */
    .button-container {
        text-align: center;
        margin-top: 20px;
    }
    
    /* Responsive adjustments */
    @media screen and (max-width: 480px) {
        .contact-card {
            padding: 20px;
        }
        
        .contact-info p {
            font-size: 16px;
        }
        
        .contact-button {
            width: 100%;
            padding: 12px;
        }
    }
    </style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); // Required for WordPress 5.2+ ?>

<!-- Custom Header -->
<header class="custom-header">
    <div class="header-container">
        <h1><?php echo get_bloginfo('name'); ?></h1>
    </div>
</header>

<!-- Back to site link -->
<div class="back-to-site">
    <a href="<?php echo esc_url(home_url('/')); ?>">&larr; <?php echo esc_html($text['back_to_site']); ?></a>
</div>

<!-- Contact Card HTML -->
<div class="contact-page-container">
    <div class="logo-container">
        <div class="logo-placeholder">
            <?php 
            // Check for custom logo
            if (function_exists('the_custom_logo') && has_custom_logo()) {
                the_custom_logo();
            } else {
                // Or use a custom logo from media library if you've uploaded one
                // $custom_logo_id = 123; // Replace with your logo's attachment ID
                // if ($custom_logo_id) {
                //     echo wp_get_attachment_image($custom_logo_id, 'full', false, array('class' => 'custom-logo'));
                // } else {
                    echo '<span>LOGO</span>';
                // }
            }
            ?>
        </div>
    </div>
    
    <div class="contact-card">
        <h1><?php echo esc_html($text['contact_information']); ?></h1>
        <div class="contact-info">
            <p><span class="label"><?php echo esc_html($text['name']); ?>:</span> <?php echo esc_html($contact['name']); ?></p>
            <p><span class="label"><?php echo esc_html($text['phone']); ?>:</span> <?php echo esc_html($contact['phone']); ?></p>
            <p><span class="label"><?php echo esc_html($text['email']); ?>:</span> <?php echo esc_html($contact['email']); ?></p>
            <p><span class="label"><?php echo esc_html($text['website']); ?>:</span> <a href="<?php echo esc_url($contact['website_url']); ?>" target="_blank"><?php echo esc_html($contact['website']); ?></a></p>
        </div>
        
        <div class="button-container">
            <a href="#" class="contact-button" id="download-vcard"><?php echo esc_html($text['add_to_contacts']); ?></a>
        </div>
        
        <div class="qr-code">
            <h3><?php echo esc_html($text['scan_qr']); ?></h3>
            <div id="qrcode"></div>
        </div>
    </div>
    
    <div class="contact-footer">
        <p><?php echo esc_html($text['card_created_for']); ?> <?php echo esc_html($contact['name']); ?>.</p>
    </div>
</div>

<!-- Custom Footer -->
<footer class="custom-footer">
    <div class="footer-container">
        <p>&copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>. <?php echo esc_html($text['all_rights_reserved']); ?>.</p>
        <p>
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html($text['home']); ?></a> | 
            <a href="<?php echo esc_url($contact['website_url']); ?>"><?php echo esc_html($contact['website']); ?></a>
        </p>
    </div>
</footer>

<!-- QR Code Script -->
<?php
// Register and enqueue the QR code library
wp_enqueue_script('qrcode-js', 'https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js', array('jquery'), null, true);

// Add inline script for QR code generation
$contact_name_parts = explode(' ', $contact['name']);
$firstname = $contact_name_parts[0] ?? '';
$middlename = $contact_name_parts[1] ?? '';
$lastname = $contact_name_parts[count($contact_name_parts)-1];

// Build vCard content
$vcard = "BEGIN:VCARD\n";
$vcard .= "VERSION:3.0\n";
$vcard .= "N:" . $lastname . ";" . $firstname . ";" . $middlename . ";;\n";
$vcard .= "FN:" . $contact['name'] . "\n";
$vcard .= "TEL;TYPE=CELL:" . $contact['phone'] . "\n";
$vcard .= "EMAIL:" . $contact['email'] . "\n";
$vcard .= "URL:" . $contact['website_url'] . "\n";
$vcard .= "END:VCARD";

// Create safe filename
$safe_filename = sanitize_title($contact['name']) . '.vcf';
?>

<script>
    jQuery(document).ready(function($) {
        // Create QR code
        new QRCode(document.getElementById("qrcode"), {
            text: <?php echo json_encode($vcard); ?>,
            width: 200,
            height: 200,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        // Create vCard download functionality
        $("#download-vcard").on('click', function(e) {
            e.preventDefault();
            
            // Create a Blob with the vCard content
            const vCardContent = <?php echo json_encode($vcard); ?>;
            const blob = new Blob([vCardContent], { type: 'text/vcard' });
            const url = URL.createObjectURL(blob);
            
            // Create a temporary link and trigger download
            const a = document.createElement('a');
            a.href = url;
            a.download = <?php echo json_encode($safe_filename); ?>;
            document.body.appendChild(a);
            a.click();
            
            // Clean up
            setTimeout(function() {
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }, 100);
        });
    });
</script>

<?php wp_footer(); // Required for WordPress plugins and admin bar ?>
</body>
</html>