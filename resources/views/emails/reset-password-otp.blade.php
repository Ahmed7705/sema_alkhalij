<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إعادة تعيين كلمة المرور - سيما الخليج</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f6f9f7; color: #1b241f; margin: 0; padding: 20px; text-align: right; }
        .card { max-width: 500px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 16px; border: 1px solid #e5e7eb; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .title { color: #0F4C3A; font-size: 20px; font-weight: bold; margin-bottom: 10px; text-align: center; }
        .otp-box { background: #fef2f2; border: 2px dashed #ef4444; font-size: 32px; font-weight: bold; color: #991b1b; letter-spacing: 8px; text-align: center; padding: 15px; border-radius: 12px; margin: 25px 0; }
        .footer { font-size: 12px; color: #6b7280; text-align: center; margin-top: 25px; border-top: 1px solid #f3f4f6; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="card">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="color: #0F4C3A; margin: 0;">سيما الخليج للخدمات الطبية</h2>
        </div>
        <div class="title">إعادة تعيين كلمة المرور</div>
        <p>مرحباً <strong>{{ $user->name }}</strong>،</p>
        <p>لقد تلقينا طلباً لإعادة تعيين كلمة المرور الخاصة بحسابك. استخدم كود التحقق التالي لتحديد كلمة مرور جديدة:</p>
        
        <div class="otp-box">{{ $otp }}</div>
        
        <div class="footer">
            إذا لم تقم بطلب إعادة تعيين كلمة المرور، يرجى تجاهل هذه الرسالة ليبقى حسابك آمناً.<br>
            © {{ date('Y') }} سيما الخليج للخدمات الطبية.
        </div>
    </div>
</body>
</html>
