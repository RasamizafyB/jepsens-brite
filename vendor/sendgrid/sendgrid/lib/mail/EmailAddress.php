<?php
/**
 * This helper builds the EmailAddress object for a /mail/send API call
 */

namespace SendGrid\Mail;

use SendGrid\Helper\Assert;

/**
 * This class is used to construct a EmailAddress object for the /mail/send API call
 *
 * @package SendGrid\Mail
 */
class EmailAddress implements \JsonSerializable
{
    /** @var $name string The name of the person associated with the email */
    private $name;
    /** @var $email string The email address */
    private $email;
    /** @var $substitutions Substitution[] An array of key/value substitutions
     * to be be applied to the text and html content of the email body
     */
    private $substitutions;
    /** @var $subject Subject The personalized subject of the email */
    private $subject;

    /**
     * Optional constructor
     *
     * @param string|null $emailAddress  The email address
     * @param string|null $name          The name of the person associated with
     *                                   the email
     * @param array|null  $substitutions An array of key/value substitutions to
     *                                   be be applied to the text and html content
     *                                   of the email body
     * @param string|null $subject       The personalized subject of the email
     * @throws TypeException
     */
    public function __construct(
        $emailAddress = null,
        $name = null,
        $substitutions = null,
        $subject = null
    ) {
        if (isset($emailAddress)) {
            $this->setEmailAddress($emailAddress);
        }
        if (isset($name) && $name !== null) {
            $this->setName($name);
        }
        if (isset($substitutions)) {
            $this->setSubstitutions($substitutions);
        }
        if (isset($subject)) {
            $this->setSubject($subject);
        }
    }

    /**
     * Add the email address to a EmailAddress object
     *
     * @param string $emailAddress The email address
     *
     * @throws TypeException
     */
    public function setEmailAddress($emailAddress)
    {
        Assert::email($emailAddress, 'emailAddress');

        $this->email = $emailAddress;
    }

    /**
     * Retrieve the email address from a EmailAddress object
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->email;
    }

    /**
     * Retrieve the email address from a EmailAddress object
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getEmailAddress();
    }

    /**
     * Add a name to a EmailAddress object
     *
     * @param string $name The name of the person associated with the email
     *
     * @throws TypeException
     */
    public function setName($name)
    {
        Assert::string($name, 'name');

        /*
            Issue #368
            ==========
            If the name is not wrapped in double quotes and contains a comma or
            semicolon, the API fails to parse it correctly.
            When wrapped in double quotes, commas, semicolons and unescaped single
            quotes are supported.
            Escaped double quotes are supported as well but will appear unescaped in
            the mail (e.g. "O\'Keefe").
            Double quotes will be shown in some email clients, so the name should
            only be wrapped when necessary.
        */
        // Only wrap in double quote if comma or semicolon are found
        if (false !== strpos($name, ',') || false !== strpos($name, ';')) {
            // Unescape quotes
            $name = stripslashes(html_entity_decode($name, ENT_QUOTES));
            // Escape only double quotes
            $name = str_replace('"', '\\"', $name);
            // Wrap in double quotes
            $name = '"' . $name . '"';
        }
        $this->name = (!empty($name)) ? $name : null;
    }

    /**
     * Retrieve the name from a EmailAddress object
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add substitutions to a EmailAddress object
     *
     * @param array $substitutions An array of key/value substitutions to
     *                             be be applied to the text and html content
     *                             of the email body
     *
     * @throws TypeException
     */
    public function setSubstitutions($substitutions)
    {
        Assert::maxItems($substitutions, 'substitutions', 10000);

        $this->substitutions = $substitutions;
    }

    /**
     * Retrieve substitutions from a EmailAddress object
     */
    public function getSubstitutions()
    {
        return $this->substitutions;
    }

    /**
     * Add a subject to a EmailAddress object
     *
     * @param string $subject The personalized subject of the email
     *
     * @throws TypeException
     */
    public function setSubject($subject)
    {
        Assert::string($subject, 'subject');

        // Now that we know it is a string, we can safely create a new subject
        $this->subject = new Subject($subject);
    }

    /**
     * Retrieve a subject from an EmailAddress object
     *
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Return an array representing an EmailAddress object for the Twilio SendGrid API
     *
     * @return null|array
     */
    public function jsonSerialize()
    {
        return array_filter(
            [
                'name' => $this->getName(),
                'email' => $this->getEmail()
            ],
            function ($value) {
                return $value !== null;
            }
        ) ?: null;
    }
}
