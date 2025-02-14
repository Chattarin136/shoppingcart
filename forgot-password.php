<?php
session_start();
include 'include/config.php';

use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer();

try {
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = trim($_POST['email']);
        
        // Check if email exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Generate reset token
            $token = bin2hex(random_bytes(32));
            
            // Store token in database
            $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
            $stmt->bind_param("ss", $token, $email);
            $stmt->execute();

            // Mail settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable debug output
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            // Replace with your Gmail address and App Password
            $mail->Username = 'shoppingcartrmuti@gmail.com';
            $mail->Password = 'ctku yhmy ufql fnbx';
            
            // Email content
            $mail->setFrom('shoppingcartrmuti@gmail.com', 'Shopping Cart');
            $mail->addAddress($email);
            $mail->isHTML(true);
            
            $reset_link = $base_url . "/reset-password.php?token=" . $token;
            $mail->Subject = "Password Reset Request";
            $mail->Body = "Click this link to reset your password: <a href='" . $reset_link . "'>" . $reset_link . "</a>";
            $mail->AltBody = "Click this link to reset your password: " . $reset_link;
            
            try {
                if($mail->send()) {
                    header("Location: login.php");
                    exit();
                } else {
                    // Log the error
                    $errorLog = date('[Y-m-d H:i:s]') . " Failed to send password reset email to: " . $email . 
                               " - Error: " . $mail->ErrorInfo . PHP_EOL;
                    error_log($errorLog, 3, "logs/email_errors.log");
                    
                   $error = "Something went wrong. Please try again";
                }
            } catch (Exception $e) {
                // Log any exceptions
                $errorLog = date('[Y-m-d H:i:s]') . " Exception while sending email to: " . $email . 
                           " - Error: " . $e->getMessage() . PHP_EOL;
                error_log($errorLog, 3, "logs/email_errors.log");
                
               $error = "Something went wrong. Please try again";
            }
        } else {
           $error = "Email not found";
        }
    }
} catch (Exception $e) {
    error_log("Mail Error: " . $mail->ErrorInfo, 3, "logs/email_errors.log");
   $error = "Email sending failed: " . $mail->ErrorInfo;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="<?php echo $base_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Forgot Password</h2>
                        <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>