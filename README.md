# 🏥 منصة سيما الخليج للخدمات الطبية والمنصة الإلكترونية
> **Sema Al-Khalij Medical Services & Home Healthcare E-Commerce Platform**

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

تطبيق ويب متكامل يجمع بين **الموقع التعريفي للرعاية الصحية المنزلية**، **كتالوج وحجز الزيارات الطبية**، و**المتجر الإلكتروني لبيع المستلزمات والأجهزة الطبية** بأسلوب تصميم عصري ومُبهر مستوحى من كبرى المجموعات الطبية العالمية (مثل مجموعة فقيه الطبية).

---

## 🌟 أبرز مميزات المنصة

- 🩺 **كتالوج الرعاية الصحية المنزلية الشاملة**:
  - عرض 9 خدمات طبية متخصصة (زيارات أطباء، تمريض منزلي 24/7، علاج طبيعي وتأهيل، سحب عينات، فحوصات مخبرية وجينية، استشارات افتراضية، وخدمات الشركات).
  - صور واقعية عالية الجودة 4K مخصصة لكل خدمة دون أي تكرار.
  - تحديد وتعبئة اسم الخدمة تلقائياً داخل نافذة الحجز عند ضغط **"احجز الآن"**.

- 🛒 **المتجر الإلكتروني وسلة التسوق التفاعلية (`/products`)**:
  - عرض الأجهزة والمستلزمات الطبية المنزلية المعتمدة (أجهزة ضغط، أكسجين، نيبولايزر، سكر، كراسي متحركة، أسرة طبية).
  - نافذة عرض تفاصيل المنتج السريعة (Quick View Modal) بالمواصفات ومحدد الكمية.
  - **سلة تسوق مركزية تفاعلية** بـ Alpine.js تحسب المجموع وشريط التوصيل المجاني فورياً.
  - نافذة إتمام الشراء والدفع متعدد الخيارات (الدفع عند الاستلام، مدى، Apple Pay).

- 👤 **لوحة تحكم المستخدم والبروفايل (`/profile`)**:
  - لوحة تحكم تفاعلية لاستعراض سجل الزيارات المنزلية والمواعيد القادمة والمكتملة.
  - جدول متابعة الطلبات الشحنات مع حالات التوصيل والمبالغ.
  - قسم التقارير الطبية ونتائج التحاليل المعتمدة القابلة للتحميل.

- 📚 **المدونة والوعي الطبي (`/blog`)**:
  - مقالات توعوية وإرشادية بنظام المجلات الطبية مع صور مخصصة وفلترة فورية ومربع اشتراك في النشرة البريدية.

- 🎨 **هوية بصرية فاخرة وأيقونات متجهة (Zero Emojis)**:
  - تصميم باللغة العربية RTL مبني على ألوان الهية الطبية الرسمية (الزمردي الداكن `#071f18` والذهبي والترميز الطبي).
  - خلو الكود تماماً من الإيموجيز واستبدالها بأيقونات متجهة SVG عالية الدقة.

---

## 🛠️ البنية التقنية (Tech Stack)

| الطبقة | التقنية |
|---|---|
| **Back-End** | PHP 8.2+ / Laravel 11.x |
| **Front-End** | Laravel Blade / Alpine.js 3.x / Tailwind CSS (Standalone CLI) |
| **Database** | MySQL 8.0 / MariaDB |
| **Icons & Media** | Custom Vector SVG Icons / 4K Realistic Medical Assets |

---

## 🚀 تعليمات التشغيل المحلي (Local Setup)

### 1. المتطلبات الأساسية
- مثبت PHP (النسخة 8.2 أو أحدث).
- مثبت Composer.
- خادم MySQL أو XAMPP.
- Node.js (لتشغيل Tailwind CLI).

### 2. خطوات التثبيت والتشغيل
```bash
# 1. الاستنساخ والدخول لمجلد المشروع
git clone https://github.com/Ahmed7705/sema_alkhalij.git
cd sema_alkhalij

# 2. تثبيت اعتماديات Composer
composer install

# 3. إنشاء ملف البيئة وإنشاء مفتاح التطبيق
cp .env.example .env
php artisan key:generate

# 4. ضبط قاعدة البيانات في ملف .env
# DB_DATABASE=sema_alkhalij
# DB_USERNAME=root
# DB_PASSWORD=

# 5. تشغيل التهجيرات (Migrations)
php artisan migrate

# 6. بناء ملفات التنسيق Tailwind CSS
npx tailwindcss -i ./resources/css/app.css -o ./public/css/app.css --minify

# 7. تشغيل سيرفر التطوير المحلي
php artisan serve
```
سيكون الموقع متاحاً على الرابط المحلي: `http://127.0.0.1:8000`

---

## 🌐 تعليمات النشر والرفع للاستضافة (Deployment Guide)

### 1. ضغط الملفات للرفع (cPanel / Shared / VPS)
- قم بضغط ملفات المشروع في ملف `project.zip` **باستثناء** مجلد `vendor` و`node_modules` وملف `.env` المحلي.

### 2. إعداد السيرفر وقاعدة البيانات
1. أنشئ قاعدة بيانات جديدة عبر **MySQL Database Wizard** في الاستضافة ورابطها بمستخدم ذو صلاحيات كاملة.
2. ارفع `project.zip` وفك الضغط عنه داخل الاستضافة.

### 3. إعداد ملف البيئة الإنتاجي (`.env`)
```env
APP_NAME="سيما الخليج للخدمات الطبية"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=اسم_قاعدة_البيانات
DB_USERNAME=اسم_المستخدم
DB_PASSWORD=كلمة_المرور
```

### 4. توجيه النطاق وأوامر تسريع الأداء (Caching)
- وجه مسار المستند (Document Root) إلى مجلد `/public`.
- تشغيل أوامر الكاش عبر SSH:
```bash
composer install --no-dev --optimize-autoloader
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📞 بيانات التواصل الرسمية

- **اسم المنشأة**: شركة سيما الخليج للخدمات الطبية
- **العنوان**: جدة، حي الرويس، طريق المدينة المنورة، المملكة العربية السعودية
- **الهاتف والخط الساخن**: `+966 54 588 0082`
- **البريد الإلكتروني**: c.care@s-sema.com
- **المستودع الرسمي على GitHub**: [github.com/Ahmed7705/sema_alkhalij](https://github.com/Ahmed7705/sema_alkhalij)

---

حقوق النشر © 2026 **شركة سيما الخليج للخدمات الطبية**. جميع الحقوق محفوظة.
