<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_email = $_POST['sender_email'];
    $spoofed_name = $_POST['spoofed_name'];
    $spoofed_email = $_POST['spoofed_email'];
    $reciever_email = $_POST['reciever_email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $emails = array($spoofed_email, $sender_email);
    
    // Setting basic headers
    $headers = "From: $sender_name "."<".$spoofed_email.">\r\n";
    $headers .= "Reply-To: ".implode (",", $emails)."\r\n" // If you really spoof, you'd also want a reply. No ?
    
    // Setting email priority Read more https://stackoverflow.com/questions/4169605/php-mail-how-to-set-priority
    $headers .= "X-Priority: 1\r\n"; // Very high priority!
    $headers .= "X-MSMail-Priority: High\r\n";
    $headers .= "Importance: High\r\n";
    
    // Setting additional headers
    $headers .= "X-Mailer: Microsoft Outlook 16.0\r\n"; // Spoof any trusted email client Here
    $headers .= "Return-Path: ".$sender_email."\r\n"; // Return path for errors
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    
    // Don't forget to spoof the X-Sender header. We'll set it using the 5th parameter of php mailer
    // See more https://stackoverflow.com/questions/179014/how-to-change-envelope-from-address-using-php-mail
    $xsender = "-f ".$spoofed_email;
    
    mail($reciever_email, $subject, $message, $headers,$xsender );
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emailer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h3 id="header">Em@il $poofer</h3>
    <form action="index.php" method="post">
        <label for="sender_email">Spoofer's Email:</label>
        <input type="email" name="sender_email" id="sender_email">
        <label for="spoofed_name">Spoofed Name:</label>
        <input type="text" name="spoofed_name" id="spoofed_name">
        <label for="spoofed_email">Spoofed Email:</label>
        <input type="email" name="spoofed_email" id="spoofed_email">
        <label for="receiver_email">Receiver's Email:</label>
        <input type="email" name="receiver_email" id="receiver_email">
        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject">
        <label for="message">Message:</label>
        <textarea name="message" id="message" cols="62" rows="10"></textarea>
        <button class="send-btn">Send Email</button>
    </form>
</body>
</html>
