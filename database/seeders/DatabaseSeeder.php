<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Service;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Site Settings
        SiteSetting::set('site_name', 'سيما الخليج للخدمات الطبية');
        SiteSetting::set('phone', '0590000000');
        SiteSetting::set('email', 'info@sema-alkhalij.com');
        SiteSetting::set('address', 'الرياض - المملكة العربية السعودية');
        SiteSetting::set('vat_rate', '15');

        // 2. Create Users
        User::updateOrCreate(
            ['email' => 'admin@sema-alkhalij.com'],
            [
                'name' => 'مدير النظام',
                'phone' => '0590000001',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $customer = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'أحمد عبدالله',
                'phone' => '0551234567',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Seed Multiple Delivery Addresses for Customer
        \App\Models\Address::create([
            'user_id' => $customer->id,
            'label' => 'المنزل - الرئيسي',
            'city' => 'الرياض',
            'district' => 'الياسمين',
            'street' => 'طريق أنس بن مالك',
            'building_no' => '402',
            'additional_info' => 'بجوار صيدلية الدواء - الشقة 4',
            'lat' => 24.812345,
            'lng' => 46.634567,
            'is_default' => true,
        ]);

        \App\Models\Address::create([
            'user_id' => $customer->id,
            'label' => 'مقر العمل',
            'city' => 'الرياض',
            'district' => 'العليا',
            'street' => 'طريق الملك فهد',
            'building_no' => '105',
            'additional_info' => 'برج التعاونية - الدور 8',
            'lat' => 24.712345,
            'lng' => 46.674567,
            'is_default' => false,
        ]);

        // 3. Create Service Categories
        $catVisits = Category::firstOrCreate(
            ['slug' => 'doctor-visits'],
            [
                'name' => 'الزيارات الطبية',
                'type' => 'service',
                'icon' => 'stethoscope',
                'description' => 'خدمات كشف وتطبيب منزلية بواسطة أطباء مرخصين.',
            ]
        );

        $catNursing = Category::firstOrCreate(
            ['slug' => 'home-nursing'],
            [
                'name' => 'التمريض المنزلي',
                'type' => 'service',
                'icon' => 'user-nurse',
                'description' => 'رعاية تمريضية شامِلة وتركيب المغذيات وتغيير الجروح.',
            ]
        );

        $catLab = Category::firstOrCreate(
            ['slug' => 'lab-tests'],
            [
                'name' => 'الفحوصات والمختبر',
                'type' => 'service',
                'icon' => 'flask',
                'description' => 'سحب عينات الدم والفحوصات الجينية والمخبرية من منزلك.',
            ]
        );

        $catPhysio = Category::firstOrCreate(
            ['slug' => 'physiotherapy'],
            [
                'name' => 'العلاج الطبيعي',
                'type' => 'service',
                'icon' => 'activity',
                'description' => 'جلسات تأهيل وعلاج طبيعي لكبار السن وحالات ما بعد العمليات.',
            ]
        );

        // 4. Create Product Categories
        $catEquip = Category::firstOrCreate(
            ['slug' => 'medical-devices'],
            [
                'name' => 'الأجهزة الطبية المنزلية',
                'type' => 'product',
                'icon' => 'heart-pulse',
                'description' => 'أجهزة قياس الضغط والسكر والأكسجين والنيبولايزر.',
            ]
        );

        $catSupplies = Category::firstOrCreate(
            ['slug' => 'medical-supplies'],
            [
                'name' => 'المستلزمات الطبية',
                'type' => 'product',
                'icon' => 'package',
                'description' => 'مستلزمات التعقيم والجروح والكراسي المتحركة.',
            ]
        );

        // 5. Create 9 Approved Medical Services (Matching Home Page Exactly)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Service::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Service::create([
            'category_id' => $catNursing->id,
            'title' => 'الرعاية الصحية المنزلية',
            'slug' => 'home-health-care',
            'short_description' => 'برامج مخصصة لكبار السن وأصحاب الأمراض المزمنة في بيئة منزلية دافئة وآمنة.',
            'description' => 'تتضمن الخدمة الرعاية الصحية الشاملة والمستمرة لكبار السن والمرضى في بيئتهم المنزلية بإشراف طاقم طبي متخصص.',
            'price' => 250.00,
            'discount_price' => 220.00,
            'duration_minutes' => 60,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $catVisits->id,
            'title' => 'الزيارات الطبية المنزلية',
            'slug' => 'home-doctor-visits',
            'short_description' => 'أطباء واستشاريون لمعاينة المريض، التشخيص الدقيق، ووصف العلاج في المنزل.',
            'description' => 'أطباء واستشاريون مرخصون يصلون لمنزلك لمعاينة المريض وإجراء الفحص السريري الكامل وصرف العلاجات.',
            'price' => 300.00,
            'discount_price' => 260.00,
            'duration_minutes' => 45,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $catNursing->id,
            'title' => 'التمريض المنزلي 24/7',
            'slug' => 'home-nursing-247',
            'short_description' => 'رعاية تمريضية متواصلة، متابعة العلامات الحيوية، العناية بالجروح والمغذيات.',
            'description' => 'خدمات تمريضية متخصصة متواصلة على مدار 12 أو 24 ساعة للعناية بالمؤشرات الحيوية والمغذيات والجروح.',
            'price' => 450.00,
            'discount_price' => 390.00,
            'duration_minutes' => 720,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $catPhysio->id,
            'title' => 'العلاج الطبيعي والتأهيل',
            'slug' => 'physiotherapy-rehab',
            'short_description' => 'جلسات تأهيلية مخصصة لما بعد العمليات والجلطات وإصابات العظام والعضلات.',
            'description' => 'برامج تأهيل حركي وتأهيل لما بعد الجلطات والعمليات الجراحية بأحدث الأجهزة المحمولة.',
            'price' => 300.00,
            'discount_price' => 250.00,
            'duration_minutes' => 60,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $catLab->id,
            'title' => 'سحب العينات المنزلي',
            'slug' => 'home-blood-sampling',
            'short_description' => 'أخصائي سحب عينات يحضر لمنزلك بأدوات معقمة مع نتائج إلكترونية سريعة.',
            'description' => 'سحب عينات الدم بشكل آمن ومريح بالمنزل وإرسالها للمختبر المعتمد مع استلام النتائج إلكترونياً.',
            'price' => 150.00,
            'discount_price' => 120.00,
            'duration_minutes' => 30,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $catLab->id,
            'title' => 'الفحوصات المخبرية الشاملة',
            'slug' => 'comprehensive-lab-tests',
            'short_description' => 'باقات فحوصات وقائية شاملة: الوظائف، الفيتامينات، الدهون، والسكر بنسب دقيقة.',
            'description' => 'تحاليل شاملة تشمل 25 مؤشر حيوي لوظائف الكبد والكلى، السكر، الفيتامينات، والدهون بنسب دقيقة.',
            'price' => 350.00,
            'discount_price' => 245.00,
            'duration_minutes' => 30,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $catLab->id,
            'title' => 'الفحوصات الجينية والوراثية',
            'slug' => 'genetic-dna-tests',
            'short_description' => 'تحاليل DNA وبصمة جينية وكشف مبكر عن الأمراض الوراثية بأعلى سرية.',
            'description' => 'فحوصات البصمة الجينية وDNA المتقدمة للكشف المبكر عن الأمراض الوراثية والجينومية بأعلى درجات السرية.',
            'price' => 600.00,
            'discount_price' => 520.00,
            'duration_minutes' => 45,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $catVisits->id,
            'title' => 'الاستشارات الطبية',
            'slug' => 'medical-teleconsultation',
            'short_description' => 'استشارات طارئة ومرئية هاتفية مع استشاريين متميزين لمتابعة حالتك الصحّية.',
            'description' => 'استشارات مرئية فورية ومتابعة هاتفية مع استشاريين لمراجعة الفحوصات وتعديل الخطط العلاجية.',
            'price' => 200.00,
            'discount_price' => 150.00,
            'duration_minutes' => 30,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $catVisits->id,
            'title' => 'خدمات الرعاية للشركات',
            'slug' => 'corporate-medical-care',
            'short_description' => 'تجهيز عيادات موقعية، فحوصات دورية للموظفين، وتغطية الفعاليات والمؤتمرات.',
            'description' => 'عقود رعاية طبية متكاملة للمؤسسات والشركات تشمل العيادات الداخلية وفحوصات الموظفين وتغطية المؤتمرات.',
            'price' => 1000.00,
            'discount_price' => 850.00,
            'duration_minutes' => 120,
            'is_featured' => true,
            'is_active' => true,
        ]);

        // 6. Create Product Categories
        $catEquip = Category::firstOrCreate(
            ['slug' => 'medical-devices'],
            [
                'name' => 'الأجهزة الطبية المنزلية',
                'type' => 'product',
                'icon' => 'heart-pulse',
                'description' => 'أجهزة قياس الضغط والسكر والأكسجين والنيبولايزر.',
            ]
        );

        $catSupplies = Category::firstOrCreate(
            ['slug' => 'medical-supplies'],
            [
                'name' => 'المستلزمات والرعاية الطبية',
                'type' => 'product',
                'icon' => 'package',
                'description' => 'مستلزمات التعقيم والجروح والكراسي المتحركة.',
            ]
        );

        $catMobility = Category::firstOrCreate(
            ['slug' => 'mobility-beds'],
            [
                'name' => 'الكراسي والأسرة الطبية',
                'type' => 'product',
                'icon' => 'truck',
                'description' => 'كراسي متحركة، أسرّة كهربائية، ومساعدات الحركة.',
            ]
        );

        // 7. Seed 8 Complete Medical Products
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Product::create([
            'category_id' => $catEquip->id,
            'title' => 'جهاز قياس ضغط الدم الرقمي الذكي',
            'slug' => 'smart-blood-pressure-monitor',
            'short_description' => 'جهاز ناطق ذكي مع شاشة LED وكاشف لعدم انتظام ضربات القلب.',
            'description' => 'جهاز طبّي دقيق معتمد من هيئة الغذاء والدواء السعودية لحفظ القراءات لشخصين حتى 120 قراءة مع شاشة ملونة سهلة القراءة وكاشف لتصلب الشرايين.',
            'price' => 220.00,
            'discount_price' => 175.00,
            'stock' => 45,
            'sku' => 'MED-BP-01',
            'image' => 'products/bp-monitor.png',
            'is_featured' => true,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $catEquip->id,
            'title' => 'طقم جهاز قياس السكر بالدم الشامل',
            'slug' => 'glucometer-kit',
            'short_description' => 'طقم فحص السكر يشتمل على الجهاز + 50 شريحة فحص + قلم الوخز.',
            'description' => 'نتائج سريعة خلال 5 ثوانٍ فقط بدقة عالية وضمان مدى الحياة. يشمل 50 شريحة فحص معقمة و100 إبرة وخز ناعمة.',
            'price' => 140.00,
            'discount_price' => 110.00,
            'stock' => 80,
            'sku' => 'MED-GL-02',
            'image' => 'products/glucometer.png',
            'is_featured' => true,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $catMobility->id,
            'title' => 'كرسي متحرك طبي خفيف الوزن قابل للطي',
            'slug' => 'foldable-wheelchair',
            'short_description' => 'كرسي متحرك هيكل ألومنيوم مقوى مع مساند مريحة وفرامل يد مزدوجة.',
            'description' => 'يتحمل وزن حتى 120 كجم وسهل الطي والوضع في شنطة السيارة، ممتص للصدمات ومزود بمقعد مريح ضد التقرحات.',
            'price' => 650.00,
            'discount_price' => 580.00,
            'stock' => 15,
            'sku' => 'MED-WC-03',
            'image' => 'products/wheelchair.png',
            'is_featured' => true,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $catEquip->id,
            'title' => 'جهاز قياس نسبة الأكسجين بالدم وضربات القلب',
            'slug' => 'pulse-oximeter',
            'short_description' => 'جهاز نبضات وأكسجين إلكتروني سريع مع شاشة OLED ملونة.',
            'description' => 'يقيس نسبة SpO2 ومعدل النبض في 3 ثوانٍ بلمسة واحدة، مناسب لمرضى الربو والجهاز التنفسي وكبار السن.',
            'price' => 95.00,
            'discount_price' => 75.00,
            'stock' => 60,
            'sku' => 'MED-PO-04',
            'image' => 'products/oximeter.png',
            'is_featured' => true,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $catEquip->id,
            'title' => 'جهاز استنشاق البخار الطبي (نيبولايزر) للربو والحساسية',
            'slug' => 'nebulizer-compressor',
            'short_description' => 'جهاز جلسات البخار المنزلي الهادئ المخصص للأطفال والكبار.',
            'description' => 'يحول الدواء السائل إلى رذاذ ناعم جداً لسهولة التنفس، مزود بجميع القناعات الطبية الخاصة بالأطفال والكبار ورأس استنشاق الفم.',
            'price' => 180.00,
            'discount_price' => 145.00,
            'stock' => 30,
            'sku' => 'MED-NEB-05',
            'image' => 'products/nebulizer.png',
            'is_featured' => true,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $catEquip->id,
            'title' => 'ميزان حرارة عن بعد بالأشعة تحت الحمراء (بدون تلامس)',
            'slug' => 'infrared-thermometer',
            'short_description' => 'قياس الحرارة الفوري للجبهة والأجسام خلال ثانية واحدة.',
            'description' => 'قياس دقيق بدون تلامس لتفادي نقل العدوى، مع إضاءة خلفية تحذيرية عند ارتفاع درجة الحرارة (حمى).',
            'price' => 120.00,
            'discount_price' => 89.00,
            'stock' => 50,
            'sku' => 'MED-TH-06',
            'image' => 'products/thermometer.png',
            'is_featured' => true,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $catSupplies->id,
            'title' => 'طقم غيار الجروح المعقم الشامل',
            'slug' => 'sterile-wound-dressing-kit',
            'short_description' => 'حقيبة ضمادات ومطهرات معقمة عالية الجودة للجروح وتقرحات الفراش.',
            'description' => 'تحتوي على ضمادات غير لاصقة، مسحات طبية، شاش معقم، شريط طبي لاصق ضد الماء، ومحلول سالين معقم.',
            'price' => 85.00,
            'discount_price' => 65.00,
            'stock' => 100,
            'sku' => 'MED-SK-07',
            'image' => 'products/firstaid.png',
            'is_featured' => false,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $catMobility->id,
            'title' => 'سرير طبي كهربائي 3 حركات للرعاية المنزلية',
            'slug' => 'electric-medical-bed',
            'short_description' => 'سرير طبي متطور بريموت كنترول للتحكم بالظهر والأرجل والارتفاع.',
            'description' => 'مزود بجوانب حماية للأمان، مرتبة طبية مقاوِمة للتقرحات، وعجلات بسلسلة فرامل مركزية لراحة المرضى وكبار السن.',
            'price' => 2800.00,
            'discount_price' => 2450.00,
            'stock' => 5,
            'sku' => 'MED-BED-08',
            'image' => 'products/medical-bed.png',
            'is_featured' => true,
            'is_active' => true,
        ]);

        // 7. Seed CMS Elements (FAQs, Reviews, Certifications, Partners, Stats, Blog)
        \App\Models\Faq::updateOrCreate(
            ['question_ar' => 'كيف يمكنني حجز زيارة طبيب منزلي؟'],
            [
                'answer_ar' => 'يمكنك الحجز بسهولة عبر موقعنا باختيار الخدمة المناسبة، ثم تحديد التاريخ والوقت والعنوان المناسبين لك، وسيصلك الفريق الطبي في الموعد المكتوب.',
                'category' => 'الزيارات الطبية',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        \App\Models\Faq::updateOrCreate(
            ['question_ar' => 'هل الكوادر الطبية مرخصة من الهيئة السعودية للتخصصات الصحية؟'],
            [
                'answer_ar' => 'نعم، 100% من أطبائنا وممرضينا وأخصائيي المختبر مرخصون رسمياً ومصنفون من الهيئة السعودية للتخصصات الصحية.',
                'category' => 'الكوادر والجودة',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        \App\Models\Faq::updateOrCreate(
            ['question_ar' => 'متى تظهر نتائج الفحوصات المخبرية المنزلية؟'],
            [
                'answer_ar' => 'تظهر معظم نتائج الفحوصات العامة والفيتامينات خلال 12 إلى 24 ساعة كحد أقصى، وتصلك بصيغة PDF معتمدة على الواتساب وحسابك بالموقع.',
                'category' => 'المختبر والفحوصات',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        \App\Models\SiteStat::updateOrCreate(['label_ar' => 'مرضى تم خدمتهم'], ['value' => '+15,000', 'icon' => 'users', 'sort_order' => 1]);
        \App\Models\SiteStat::updateOrCreate(['label_ar' => 'طبيب وممرض مرخص'], ['value' => '+120', 'icon' => 'user-check', 'sort_order' => 2]);
        \App\Models\SiteStat::updateOrCreate(['label_ar' => 'زيارة منزلية ناجحة'], ['value' => '+45,000', 'icon' => 'home', 'sort_order' => 3]);
        \App\Models\SiteStat::updateOrCreate(['label_ar' => 'نسبة رضا المرضى'], ['value' => '99.2%', 'icon' => 'heart', 'sort_order' => 4]);

        $sampleService = \App\Models\Service::first();
        if ($sampleService) {
            \App\Models\Review::updateOrCreate(
                ['user_id' => $customer->id, 'reviewable_id' => $sampleService->id, 'reviewable_type' => \App\Models\Service::class],
                [
                    'rating' => 5,
                    'comment' => 'خدمة ممتازة وسريعة جداً. وصل الطبيب في الموعد المحدد وقام بالكشف الكامل على الوالد بكل مهنية واحترام.',
                    'is_approved' => true,
                ]
            );
        }

        \App\Models\Certification::updateOrCreate(
            ['name_ar' => 'ترخيص وزارة الصحة السعودية'],
            [
                'logo' => 'images/cert-moh.png',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        \App\Models\Partner::updateOrCreate(
            ['name' => 'مختبرات العرب المعتمدة'],
            [
                'logo' => 'images/partner-lab.png',
                'website_url' => 'https://example.com',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $blogCat = \App\Models\BlogCategory::firstOrCreate(
            ['slug' => 'home-health-care'],
            [
                'name_ar' => 'التثقيف الطبي المنزلي',
            ]
        );

        \App\Models\BlogPost::updateOrCreate(
            ['slug' => 'importance-of-regular-checkups'],
            [
                'title_ar' => 'أهمية الفحص الطبي الدوري الشامل وكيفية إجرائه في المنزل',
                'content_ar' => 'الفحص الطبي الدوري يمثل خط الدفاع الأول للوقاية من الأمراض المزمنة واكتشاف أي نقص في الفيتامينات والمعادن مبكراً...',
                'excerpt_ar' => 'تعرف على أهم الفحوصات الطبية الدورية التي يمكنك إجراؤها من منزلك بضغطة زر.',
                'category_id' => $blogCat->id,
                'author_id' => 1,
                'views_count' => 340,
                'is_published' => true,
                'published_at' => now(),
            ]
        );
    }
}
