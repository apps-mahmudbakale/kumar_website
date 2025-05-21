<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input to prevent XSS
    function clean_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Get form data
    $name = clean_input($_POST['name']);
    $phone = clean_input($_POST['phone']);
    $email = filter_var(clean_input($_POST['email']), FILTER_SANITIZE_EMAIL);
    $companyname = clean_input($_POST['companyname']);
    $inquirytype = clean_input($_POST['inquirytype']);
    $message = clean_input($_POST['message']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Email receiver
    $to = "abubakarlawan112@gmail.com"; // Replace with your email
    $subject = "New Inquiry from $name";
    $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";

    $email_content = "Name: $name\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Company: $companyname\n";
    $email_content .= "Inquiry Type: $inquirytype\n";
    $email_content .= "Message:\n$message\n";

    // Send email
    if (mail($to, $subject, $email_content, $headers)) {
        echo "Your message has been sent successfully!";
    } else {
        echo "Failed to send your message. Please try again.";
    }
} else {
    echo "Invalid request.";
}
?>
