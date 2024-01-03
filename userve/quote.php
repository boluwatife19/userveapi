

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting</title>
</head>
<body style="color: black; background: black">
    <?php

use PHPMailer\PHPMailer\PHPMailer;

require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';


if (isset($_POST["send"])) {
    $dashboard = "No";

    if($_POST["dashboard"] == "on"){
        $dashboard = "Yes";
    }else{
        $dashboard = "No";
    }
    // Sanitize and validate input values
    $mail = new PHPMailer(true);

    // $mail->isSMTP();
    // $mail->Host = 'smtp.gmail.com';
    // $mail->SMTPAuth = true;
    // $mail->Username = 'userve12@gmail.com'; // Your Gmail username
    // $mail->Password = 'othtjhjutrghjjqq'; // Your Gmail password
    // $mail->SMTPSecure = 'ssl';
    // $mail->Port = 465;

    
    $mail->isSMTP();
    $mail->Host = 'mailout.one.com ';
    $mail->SMTPAuth = true;
    $mail->Username = 'quote@uservewireless.net'; // Your one.com username
    $mail->Password = 'Boluwatife19'; // Your one.com password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom($_POST["email"]); // Set the sender's email address
    $mail->addAddress($_POST["email"]); // Add the recipient's email address
    $mail->addAddress('userve12@gmail.com'); // Add the recipient's email addzress
    $mail->isHTML(true);
    $mail->Subject = "New Qoutation Request"; // Set the email subject (overwrite the previous subject)
    $mail->Body = '<html lang="en">

    <body style="background: #000; color: white; font-family: Poppins, sans-serif; padding: 30px;">
        <nav style="max-height: 60px; margin: 0px; display: flex; justify-content: flex-end; padding-bottom: 10px"><img style="max-height: 60px; max-width: 50px;" src="https://uservewireless.net/blogg/userve/images/logo.png" alt="Userve Logo"></nav>
        <main style="background: #181818; padding: 20px; margin-top: 20px; border-radius: 10px;">
            <h1 style="text-align: center; border-bottom: 2px solid black; padding-bottom: 10px; font-size: 30px;">QOUTATION REQUEST</h1>
            <div>
                <div class="">
                    <h1 style="font-size: 20px; font-weight: 800">Company Name:</h1>
                    <p style="font-size: 17px; border-bottom: 2px solid #282828; padding-bottom: 10px;">'.$_POST["name"].'</p>
                    <h1 style="font-size: 20px; font-weight: 800">Phone Number:</h1>
                    <p style="font-size: 17px; border-bottom: 2px solid #282828; padding-bottom: 10px;">'.$_POST["number"].'</p>
                    <h1 style="font-size: 20px; font-weight: 800">Address:</h1>
                    <p style="font-size: 17px; border-bottom: 2px solid #282828; padding-bottom: 10px;">'.$_POST["address"].'</p>
                    <h1 style="font-size: 20px; font-weight: 800">Email:</h1>
                    <p style="font-size: 17px; border-bottom: 2px solid #282828; padding-bottom: 10px;">'.$_POST["email"].'</p>
                    <h1 style="font-size: 20px; font-weight: 800">Flow Meter Name:</h1>
                    <p style="font-size: 17px; border-bottom: 2px solid #282828; padding-bottom: 10px;">'.$_POST["metername"].'</p>
                    <h1 style="font-size: 20px; font-weight: 800">Flow Meter Model:</h1>
                    <p style="font-size: 17px; border-bottom: 2px solid #282828; padding-bottom: 10px;">'.$_POST["metermodel"].'</p>
                    <h1 style="font-size: 20px; font-weight: 800">Gas Capacity in MMSCFD:</h1>
                    <p style="font-size: 17px; border-bottom: 2px solid #282828; padding-bottom: 10px;">'.$_POST["gas"].'</p>
                    <h1 style="font-size: 20px; font-weight: 800">Power Source:</h1>
                    <p style="font-size: 17px; border-bottom: 2px solid #282828; padding-bottom: 10px;">'.$_POST["power"].'</p>
                    <h1 style="font-size: 20px; font-weight: 800">Dashboard required:</h1>
                    <p style="font-size: 17px; border-bottom: 2px solid #282828; padding-bottom: 10px;">'.$dashboard.'</p>
                    <h1 style="font-size: 20px; font-weight: 800">Required Parameters:</h1>
                    <p style="font-size: 17px; border-bottom: 2px solid #282828; padding-bottom: 10px;">'.$_POST["parameters"].'</p>
                    <h1 style="font-size: 20px; font-weight: 800">Company Budget:</h1>
                    <p style="font-size: 17px; padding-bottom: 10px;">'.$_POST["currency"].''.$_POST["budget"].'</p>
                </div>
            </div>
        </main>
    </body>
    
    </html>';

    $mail->send(); // Send the email
    echo "<script>alert('Sent Successfully'); document.location.href = 'https://uservewireless.net/'</script>"; // Display a success message and redirect to the index.php page
}
?>
</body>
</html>