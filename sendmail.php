<?php

require 'vendor/autoload.php';

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("bryanrasamizafy98@gmail.com", "Bababry");
    $email->setSubject("Sending with Twilio SendGrid is Fun");
    $email->addTo("rasamizafybryan98@gmail.com", "Bryan");
    $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $email->addContent(
        "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
    );
    $sendgrid = new \SendGrid('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');
    try {
        $response = $sendgrid->send($email);
        print $response->statusCode() . "\n";
        print_r($response->headers());
        print $response->body() . "\n";
    } catch (Exception $e) {
        echo 'Caught exception: '. $e->getMessage() ."\n";
    }
?>