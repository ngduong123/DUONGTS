<?php
    //SQL
    define("SQLSERVERNAME", "sql110.epizy.com");
    define("SQLUSERNAME", "epiz_31647621");
    define("SQLPASSWORD", "GSgusrcmqT0");
    define("SQLDATABASE", "epiz_31647621_DUONG");



    //SEND MAIL
    // The name and address which should be used for the sender details.
    // The name can be anything you want, the address should be something in your own domain. It does not need to exist as a mailbox.
    define('CONTACTFORM_FROM_ADDRESS', 'DUONGTHACSI@gmail.com');
    define('CONTACTFORM_FROM_NAME', 'DUONG THAC SI');

    // The name and address to which the contact message should be sent.
    // These details should NOT be the same as the sender details.
    define('CONTACTFORM_TO_ADDRESS', 'customer@gmail.com');
    define('CONTACTFORM_TO_NAME', 'CUSTOMER');

    // The details of your SMTP service, e.g. Gmail.
    define('CONTACTFORM_SMTP_HOSTNAME', 'smtp.gmail.com');
    define('CONTACTFORM_SMTP_USERNAME', 'nguyenduong07122003@gmail.com');
    define('CONTACTFORM_SMTP_PASSWORD', 'ydmsfivbdwrzkxux');

    // The reCAPTCHA credentials for your site. You can get these at https://www.google.com/recaptcha/admin
    define('CONTACTFORM_RECAPTCHA_SITE_KEY', '6LdsMYQdAAAAAIf_U0UlPbIQmw3sAgLelU4btDPe');
    define('CONTACTFORM_RECAPTCHA_SECRET_KEY', '6LdsMYQdAAAAAFmMq2bKZg-3uT4RvcI331td3G4l');

    /**
     * Optional Settings
     */

    // The debug level for PHPMailer. Default is 0 (off), but can be increased from 1-4 for more verbose logging.
    define('CONTACTFORM_PHPMAILER_DEBUG_LEVEL', 0);

    // Which SMTP port and encryption type to use. The default is probably fine for most use cases.
    define('CONTACTFORM_SMTP_PORT', 587);
    define('CONTACTFORM_SMTP_ENCRYPTION', 'tls');
?>