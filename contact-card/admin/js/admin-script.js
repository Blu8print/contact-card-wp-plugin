/**
 * Contact Card Admin JavaScript
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // Initialize color pickers with individual settings
        if ($.fn.wpColorPicker) {
            $('.contact-card-color-picker').each(function() {
                var $input = $(this);
                var defaultColor = $input.data('default-color') || '#2271b1';

                $input.wpColorPicker({
                    defaultColor: defaultColor,
                    change: function(event, ui) {
                        // Update the input value when color changes
                        $input.val(ui.color.toString());
                    },
                    clear: function() {
                        // Reset to default when cleared
                        $input.val(defaultColor);
                    }
                });
            });
        }

        // Media uploader for logo
        var mediaUploader;

        $('#upload_logo_button').on('click', function(e) {
            e.preventDefault();

            // If the uploader object has already been created, reopen it
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            // Create the media uploader
            mediaUploader = wp.media({
                title: 'Choose Logo',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });

            // When an image is selected, run a callback
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();

                // Update hidden fields
                $('#logo_attachment_id').val(attachment.id);
                $('#logo_url').val(attachment.url);

                // Update preview
                $('.logo-preview').html(
                    '<img src="' + attachment.url + '" alt="Logo" style="max-width: 150px; height: auto; border-radius: 50%;">'
                );

                // Update button text
                $('#upload_logo_button').text('Change Logo');

                // Show remove button if it doesn't exist
                if ($('#remove_logo_button').length === 0) {
                    $('#upload_logo_button').after(
                        '<button type="button" class="button" id="remove_logo_button">Remove Logo</button>'
                    );
                    // Bind remove handler to the new button
                    bindRemoveHandler();
                }
            });

            // Open the uploader
            mediaUploader.open();
        });

        // Remove logo button handler
        function bindRemoveHandler() {
            $('#remove_logo_button').on('click', function(e) {
                e.preventDefault();

                // Clear hidden fields
                $('#logo_attachment_id').val('');
                $('#logo_url').val('');

                // Update preview
                $('.logo-preview').html(
                    '<div class="no-logo" style="width: 150px; height: 150px; border: 2px dashed #ccc; display: flex; align-items: center; justify-content: center; border-radius: 50%;">' +
                    '<span>No Logo</span>' +
                    '</div>'
                );

                // Update button text
                $('#upload_logo_button').text('Upload Logo');

                // Remove the remove button
                $(this).remove();
            });
        }

        // Bind remove handler on page load if button exists
        if ($('#remove_logo_button').length > 0) {
            bindRemoveHandler();
        }

        // Handle tab persistence after form save
        if (window.location.hash) {
            var hash = window.location.hash.substring(1);
            $('.nav-tab-wrapper a[href*="tab=' + hash + '"]').trigger('click');
        }

        // Copy shortcode to clipboard
        $(document).on('click', '.contact-card-shortcode-box', function() {
            var $this = $(this);
            var text = $this.text();

            // Create temporary input to copy text
            var $temp = $('<input>');
            $('body').append($temp);
            $temp.val(text).select();
            document.execCommand('copy');
            $temp.remove();

            // Show copied feedback
            var originalText = $this.text();
            $this.addClass('copied').text('Copied!');

            setTimeout(function() {
                $this.removeClass('copied').text(originalText);
            }, 2000);
        });
    });

})(jQuery);
