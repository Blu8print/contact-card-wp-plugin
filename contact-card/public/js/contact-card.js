/**
 * Contact Card Frontend JavaScript
 * Extracted from contact-template.php
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Get data passed from PHP
        var contactCardData = window.contactCardData || {};

        if (!contactCardData.vcard) {
            console.error('Contact Card: vCard data not found');
            return;
        }

        // Create QR code if QR display is enabled
        if (contactCardData.showQR && $('#contact-card-qrcode').length > 0) {
            if (typeof QRCode === 'undefined') {
                console.error('Contact Card: QRCode library not loaded');
                return;
            }

            new QRCode(document.getElementById('contact-card-qrcode'), {
                text: contactCardData.vcard,
                width: contactCardData.qrSettings.width || 200,
                height: contactCardData.qrSettings.height || 200,
                colorDark: contactCardData.qrSettings.colorDark || '#000000',
                colorLight: contactCardData.qrSettings.colorLight || '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
        }

        // Create vCard download functionality
        $('#contact-card-download-vcard').on('click', function(e) {
            e.preventDefault();

            // Create a Blob with the vCard content
            var vCardContent = contactCardData.vcard;
            var blob = new Blob([vCardContent], { type: 'text/vcard' });
            var url = URL.createObjectURL(blob);

            // Create a temporary link and trigger download
            var a = document.createElement('a');
            a.href = url;
            a.download = contactCardData.filename || 'contact.vcf';
            document.body.appendChild(a);
            a.click();

            // Clean up
            setTimeout(function() {
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }, 100);
        });
    });

})(jQuery);
