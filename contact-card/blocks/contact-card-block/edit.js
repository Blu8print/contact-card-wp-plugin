/**
 * Contact Card Block Editor Component
 */

import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Edit component
 */
export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Display Options', 'contact-card')} initialOpen={true}>
                    <ToggleControl
                        label={__('Show Logo', 'contact-card')}
                        checked={attributes.showLogo}
                        onChange={(value) => setAttributes({ showLogo: value })}
                    />
                    <ToggleControl
                        label={__('Show QR Code', 'contact-card')}
                        checked={attributes.showQR}
                        onChange={(value) => setAttributes({ showQR: value })}
                    />
                    <ToggleControl
                        label={__('Show vCard Button', 'contact-card')}
                        checked={attributes.showVCardButton}
                        onChange={(value) => setAttributes({ showVCardButton: value })}
                    />
                    <ToggleControl
                        label={__('Show Social Links', 'contact-card')}
                        checked={attributes.showSocialLinks}
                        onChange={(value) => setAttributes({ showSocialLinks: value })}
                    />
                </PanelBody>
            </InspectorControls>

            <div {...blockProps}>
                <ServerSideRender
                    block="contact-card/contact-card-block"
                    attributes={attributes}
                />
            </div>
        </>
    );
}
