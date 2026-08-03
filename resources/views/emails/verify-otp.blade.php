<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>كود تفعيل الحساب - سيما الخليج</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f6f9f7; color: #1b241f; margin: 0; padding: 20px; text-align: right; }
        .card { max-width: 500px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 16px; border: 1px solid #e5e7eb; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .logo { text-align: center; margin-bottom: 20px; }
        .logo img { height: 50px; }
        .title { color: #0F4C3A; font-size: 20px; font-weight: bold; margin-bottom: 10px; text-align: center; }
        .otp-box { background: #f0fdf4; border: 2px dashed #3CA96B; font-size: 32px; font-weight: bold; color: #0F4C3A; letter-spacing: 8px; text-align: center; padding: 15px; border-radius: 12px; margin: 25px 0; }
        .footer { font-size: 12px; color: #6b7280; text-align: center; margin-top: 25px; border-top: 1px solid #f3f4f6; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <h2 style="color: #0F4C3A; margin: 0;">سيما الخليج للخدمات الطبية</h2>
        </div>
        <div class="title">كود تفعيل حسابك</div>
        <p>مرحباً <strong>{{ $user->name }}</strong>،</p>
        <p>شكراً لتسجيلك في منصة <strong>سيما الخليج للخدمات الطبية والرعاية المنزلية</strong>. لتأكيد حسابك وتفعيله، استخدم كود التحقق التالي:</p>
        
        <div class="otp-box">{{ $otp }}</div>
        
        <p style="font-size: 13px; color: #ef4444; text-align: center;">ينتهي كود التحقق بعد 15 دقيقة.</p>
        
        <div class="footer">
            إذا لم تقم بطلب هذا الكود، يرجى تجاهل هذه الرسالة.<br>
            © {{ date('Y') }} سيما الخليج للخدمات الطبية. جميع الحقوق محفوظة.
        </div>
    </div>
</body>
</html>
