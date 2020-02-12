<?php
// header("Content-type: application/json");
// Configure your Subject Prefix and Recipient here
$subjectPrefix = 'Schedule Delivery Form ';
$emailTo = '<info@nezalogistics.com>';
$emailTo2       = '<olamipo@nezalogistics.com>';
$errors = array(); // array to hold validation errors
$data = array(); // array to pass back data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = stripslashes(trim($_POST['name']));
    $email = stripslashes(trim($_POST['email']));
    $phone = stripslashes(trim($_POST['phone']));
    $size = stripslashes(trim($_POST['size']));
    $item = stripslashes(trim($_POST['item']));
    $pickup = stripslashes(trim($_POST['pickup']));
    $delivery = stripslashes(trim($_POST['delivery']));
    // $description = stripslashes(trim($_POST['description']));
    if (empty($name)) {
        $errors['name'] = 'Name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email is invalid.';
    }
    if (empty($phone)) {
        $errors['phone'] = 'Phone is required.';
    }
    if (empty($size)) {
        $errors['size'] = 'Size/Quantity is required.';
    }
    if (empty($item)) {
        $errors['item'] = 'Item to be delivered is required.';
    }
    if (empty($pickup)) {
        $errors['pickup'] = 'Pickup Address is required.';
    }
    if (empty($delivery)) {
        $errors['delivery'] = 'Delivery address is required.';
    }
    // if (empty($description)) {
    //     $errors['description'] = 'Description is required.';

            // <strong>Description: </strong>' . nl2br($description) . '<br />
    // }
    // if there are any errors in our errors array, return a success boolean or false
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $subject = "$subjectPrefix";
        $body = '
            <strong>Name: </strong>' . $name . '<br />
            <strong>Email: </strong>' . $email . '<br />
            <strong>Phone: </strong>' . $phone . '<br />
            <strong>Size/Quantity: </strong>' . $size . '<br />
            <strong>Item: </strong>' . $item . '<br />
            <strong>Pick Up Address: </strong>' . $pickup . '<br />
            <strong>Delivery Address: </strong>' . $delivery . '<br />
        ';
        $headers = "MIME-Version: 1.1" . PHP_EOL;
        $headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
        $headers .= "Content-Transfer-Encoding: 8bit" . PHP_EOL;
        $headers .= "Date: " . date('r', $_SERVER['REQUEST_TIME']) . PHP_EOL;
        $headers .= "Message-ID: <" . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>' . PHP_EOL;
        $headers .= "From: " . "=?UTF-8?B?" . base64_encode($name) . "?=" . "<$email>" . PHP_EOL;
        $headers .= "Return-Path: $emailTo" . PHP_EOL;
        $headers .= "Reply-To: $email" . PHP_EOL;
        $headers .= "X-Mailer: PHP/" . phpversion() . PHP_EOL;
        $headers .= "X-Originating-IP: " . $_SERVER['SERVER_ADDR'] . PHP_EOL;
        mail($emailTo, "=?utf-8?B?" . base64_encode($subject) . "?=", $body, $headers);
        mail($emailTo2, "=?utf-8?B?" . base64_encode($subject) . "?=", $body, $headers);
        $data['success'] = true;
        $data['message'] = 'Congratulations. Your message has been sent successfully, reload the page.';
    }
    // return all our data to an AJAX call
    echo json_encode($data);
}
