<?php
// header("Content-type: application/json");
// Configure your Subject Prefix and Recipient here
$subjectPrefix = '[Quotation Form]';
$emailTo       = '<info@nezalogistics.com>';
$emailTo2       = '<olamipo@nezalogistics.com>';
$errors = array(); // array to hold validation errors
$data   = array(); // array to pass back data
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = stripslashes(trim($_POST['name']));
    $email   = stripslashes(trim($_POST['email']));
    $phone = stripslashes(trim($_POST['phone']));
    $type = stripslashes(trim($_POST['type']));
    $quantity = stripslashes(trim($_POST['quantity']));
    $pickup = stripslashes(trim($_POST['pickup']));
    $delivery = stripslashes(trim($_POST['delivery']));
    $message = stripslashes(trim($_POST['message']));
    if (empty($name)) {
        $errors['name'] = 'Name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email is invalid.';
    }
    if (empty($phone)) {
        $errors['phone'] = 'Phone is required.';
    }
    if (empty($type)) {
        $errors['type'] = 'Item Type is required.';
    }
    if (empty($quantity)) {
        $errors['quantity'] = 'Quantity/Size is required.';
    }
    if (empty($pickup)) {
        $errors['pickup'] = 'Pickup Address is required.';
    }
    if (empty($delivery)) {
        $errors['delivery'] = 'Delivery Address is required.';
    }
    if (empty($message)) {
        $errors['message'] = 'Message is required.';
    }
    // if there are any errors in our errors array, return a success boolean or false
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {
        $subject = "$subjectPrefix ";
        $body    = '<html><body>
            <strong>Name: </strong>'.$name.'<br />
            <strong>Email: </strong>'.$email.'<br />
            <strong>Phone: </strong>'.$phone.'<br />
            <strong>Item Type: </strong>'.$type.'<br />
            <strong>Quantity/Size: </strong>'.$quantity.'<br />
            <strong>Pickup Address: </strong>'.$pickup.'<br />
            <strong>Delivery Address: </strong>'.$delivery.'<br />
            <strong>Message: </strong>'.nl2br($message).'<br />
            </body></html>';
        $headers  = "MIME-Version: 1.1" . PHP_EOL;
        $headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
        $headers .= "Content-Transfer-Encoding: 8bit" . PHP_EOL;
        $headers .= "Date: " . date('r', $_SERVER['REQUEST_TIME']) . PHP_EOL;
        $headers .= "Message-ID: <" . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>' . PHP_EOL;
        $headers .= "From: " . "=?UTF-8?B?".base64_encode($name)."?=" . "<$email>" . PHP_EOL;
        $headers .= "Return-Path: $emailTo" . PHP_EOL;
        $headers .= "Reply-To: $email" . PHP_EOL;
        $headers .= "X-Mailer: PHP/". phpversion() . PHP_EOL;
        $headers .= "X-Originating-IP: " . $_SERVER['SERVER_ADDR'] . PHP_EOL;
        mail($emailTo, "=?utf-8?B?" . base64_encode($subject) . "?=", $body, $headers);
        mail($emailTo2, "=?utf-8?B?" . base64_encode($subject) . "?=", $body, $headers);
        $data['success'] = true;
        $data['message'] = 'Congratulations. Your message has been sent successfully';
    }
    // return all our data to an AJAX call
    echo json_encode($data);
}
