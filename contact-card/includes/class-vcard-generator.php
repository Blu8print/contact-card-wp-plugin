<?php
/**
 * vCard generator class
 *
 * @package ContactCard
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Contact_Card_VCard_Generator Class
 *
 * Generates vCard 3.0 format from contact data
 */
class Contact_Card_VCard_Generator {

    /**
     * Contact data
     *
     * @var array
     */
    private $contact;

    /**
     * Constructor
     *
     * @param array $contact Contact data
     */
    public function __construct($contact) {
        $this->contact = $contact;
    }

    /**
     * Generate vCard content
     *
     * @return string vCard 3.0 formatted content
     */
    public function generate() {
        $vcard = "BEGIN:VCARD\n";
        $vcard .= "VERSION:3.0\n";

        // Name fields (N: Last;First;Middle;;)
        $vcard .= "N:" . $this->escape($this->contact['last_name']) . ";"
                . $this->escape($this->contact['first_name']) . ";"
                . $this->escape($this->contact['middle_name']) . ";;\n";

        // Full name (FN: Full Name)
        $vcard .= "FN:" . $this->escape($this->contact['name']) . "\n";

        // Organization and title
        if (!empty($this->contact['company'])) {
            $vcard .= "ORG:" . $this->escape($this->contact['company']) . "\n";
        }

        if (!empty($this->contact['job_title'])) {
            $vcard .= "TITLE:" . $this->escape($this->contact['job_title']) . "\n";
        }

        // Phone (TEL;TYPE=CELL:+123456789)
        if (!empty($this->contact['phone'])) {
            $vcard .= "TEL;TYPE=CELL:" . $this->escape($this->contact['phone']) . "\n";
        }

        // Email (EMAIL:email@example.com)
        if (!empty($this->contact['email'])) {
            $vcard .= "EMAIL:" . $this->escape($this->contact['email']) . "\n";
        }

        // Website (URL:https://example.com)
        if (!empty($this->contact['website_url'])) {
            $vcard .= "URL:" . $this->escape($this->contact['website_url']) . "\n";
        }

        // Address (ADR;TYPE=WORK:;;Street;City;State;ZIP;Country)
        if (!empty($this->contact['address'])) {
            $addr = $this->contact['address'];
            if (!empty($addr['street']) || !empty($addr['city']) || !empty($addr['state']) ||
                !empty($addr['zip']) || !empty($addr['country'])) {
                $vcard .= "ADR;TYPE=WORK:;;"
                        . $this->escape($addr['street']) . ";"
                        . $this->escape($addr['city']) . ";"
                        . $this->escape($addr['state']) . ";"
                        . $this->escape($addr['zip']) . ";"
                        . $this->escape($addr['country']) . "\n";
            }
        }

        $vcard .= "END:VCARD";

        return $vcard;
    }

    /**
     * Escape special characters for vCard format
     *
     * @param string $value Value to escape
     * @return string Escaped value
     */
    private function escape($value) {
        if (empty($value)) {
            return '';
        }

        // Escape semicolons, commas, and backslashes
        $value = str_replace('\\', '\\\\', $value);
        $value = str_replace(';', '\\;', $value);
        $value = str_replace(',', '\\,', $value);

        // Remove newlines
        $value = str_replace(array("\r\n", "\r", "\n"), ' ', $value);

        return $value;
    }

    /**
     * Get safe filename for vCard
     *
     * @return string Sanitized filename
     */
    public function get_filename() {
        $name = !empty($this->contact['name']) ? $this->contact['name'] : 'contact';
        return sanitize_title($name) . '.vcf';
    }
}
