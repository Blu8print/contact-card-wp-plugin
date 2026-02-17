/**
 * Contact Card Block Registration
 */

import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import Edit from './edit';
import metadata from './block.json';

/**
 * Register Contact Card block
 */
registerBlockType(metadata.name, {
    ...metadata,
    title: __('Contact Card', 'contact-card'),
    description: __('Display your contact card with QR code', 'contact-card'),
    icon: 'id-alt',
    category: 'widgets',
    keywords: [
        __('contact', 'contact-card'),
        __('vcard', 'contact-card'),
        __('qr code', 'contact-card')
    ],
    edit: Edit,
    save: () => null // Server-side rendering
});
