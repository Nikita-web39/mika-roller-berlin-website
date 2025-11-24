<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formulardaten empfangen
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $vehicle = htmlspecialchars($_POST['vehicle']);
    $service = htmlspecialchars($_POST['service']);
    $date = htmlspecialchars($_POST['date']);
    $message = htmlspecialchars($_POST['message']);
    $language = htmlspecialchars($_POST['language']);
    
    // Ihre E-Mail-Adresse
    $to = "info@mika-roller-berlin.de";
    
    // Betreff
    $subject = $language == "de" 
        ? "Neue Terminanfrage von $name"
        : "New appointment request from $name";
    
    // Nachricht
    $email_body = $language == "de"
        ? "Neue Terminanfrage erhalten:\n\n"
          . "Name: $name\n"
          . "E-Mail: $email\n"
          . "Telefon: " . ($phone ?: "Nicht angegeben") . "\n"
          . "Fahrzeug: " . ($vehicle ?: "Nicht angegeben") . "\n"
          . "Service: " . ($service ?: "Nicht angegeben") . "\n"
          . "Gewünschter Termin: " . ($date ?: "Nicht angegeben") . "\n"
          . "Nachricht: " . ($message ?: "Keine Nachricht") . "\n\n"
          . "Gesendet am: " . date("d.m.Y H:i")
        : "New appointment request received:\n\n"
          . "Name: $name\n"
          . "Email: $email\n"
          . "Phone: " . ($phone ?: "Not provided") . "\n"
          . "Vehicle: " . ($vehicle ?: "Not provided") . "\n"
          . "Service: " . ($service ?: "Not provided") . "\n"
          . "Preferred Date: " . ($date ?: "Not provided") . "\n"
          . "Message: " . ($message ?: "No message") . "\n\n"
          . "Sent on: " . date("Y-m-d H:i");
    
    // Headers
    $headers = "From: website@mika-roller-berlin.de\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // E-Mail senden
    if (mail($to, $subject, $email_body, $headers)) {
        http_response_code(200);
        echo "success";
    } else {
        http_response_code(500);
        echo "error";
    }
} else {
    http_response_code(403);
    echo "Access denied";
}
?>
