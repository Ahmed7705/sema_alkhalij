راجع الآن Navigation والواجهات الفعلية للمشروع بالكامل، وليس Backend أو Routes فقط.

اقرأ أولًا كامل الملف:
E:\Saudi\Jazan\Other projects\Sema-Alkhalij\code\sema-alkhalij-crm-medical-operations-prompt.md

ثم افحص الكود والواجهات الحالية فعليًا قبل إجراء أي تعديل.

========================================
1. الوضع الحالي
========================================

الهيدر العام الحالي يحتوي تقريبًا على:

- الرئيسية
- من نحن
- الخدمات الطبية
- المتجر الطبي
- المدونة
- تواصل معنا
- واتساب
- 0545880082
- الأدمن
- طلب خدمة

والـ Admin Sidebar الحالي يحتوي:

- الرئيسية ونظرة عامة
- مركز التحليلات والتقارير
- إدارة الخدمات الطبية
- إدارة المتجر والمنتجات
- البحث التشغيلي المتقدم
- بوابة الكادر الطبي
- بوابة الشركات المتعاقدة
- إدارة الحجوزات والزيارات
- طلبات الشراء والفوترة
- معدّل CMS والإعدادات
- إدارة المستخدمين والصلاحيات
- سجل العمليات والأمان

هذا التنظيم غير كافٍ بعد إضافة CRM وMedical Operations.

مهم:
لا أريد مجرد إضافة Routes إلى Sidebar.
ولا تعتبر وجود Model أو Migration أو Controller أو Route أن Feature مكتملة.
يجب وجود شاشات UI حقيقية ومتكاملة ومتصلة ببيانات MySQL الحقيقية.

========================================
2. أعد تصميم Public Header
========================================

حافظ على التصميم الحالي الجميل والهوية الحالية، لكن أعد تنظيم Navigation ليصبح منطقيًا.

للمستخدم غير المسجل Guest اقترح وتنفيذ Header مثل:

الرئيسية
من نحن
الخدمات الطبية
خدمات الشركات ▼
المتجر الطبي
المدونة
تواصل معنا

ثم عناصر الإجراءات:
- تسجيل الدخول  
 أيقونة الحساب
- السلة
- طلب خدمة

أضف "خدمات الشركات" كـ Dropdown حقيقي، مثل:

خدمات الشركات
├── حلول الشركات
├── الخدمات الطبية للشركات
├── آلية التعاقد
├── طلب تعاقد جديد
└── دخول الشركات

لا تجعلها روابط شكلية.

أنشئ عند الحاجة صفحة عامة احترافية:
Corporate Services

تشرح:
- ما هي خدمات الشركات.
- الخدمات الطبية المتاحة للشركات.
- آلية التعاقد.
- إدارة المستفيدين.
- إمكانية وجود خدمات وأسعار خاصة بالعقد.
- آلية طلب الخدمات بعد التعاقد.
- متابعة الطلبات والزيارات.
- Call To Action لطلب التعاقد.

وأنشئ Public Contract Request Form حقيقي إذا لم يكن موجودًا.

عند إرساله:
يحفظ الطلب في MySQL داخل contract_requests
ويظهر فورًا داخل:
Admin → Corporate → Contract Requests

ولا تعرض العقود أو الأسعار الخاصة أو بيانات المستفيدين للعامة.

========================================
3. لا تعرض "الأدمن" لكل المستخدمين
========================================

راجع العنصر الحالي "الأدمن" الموجود في Header.

لا يجب أن يظهر للـGuest أو Customer العادي.

Navigation يجب أن تعتمد على Authentication + Roles + Permissions.

Guest:
- تسجيل الدخول
- إنشاء حساب

Customer / Patient:
- حسابي
- حجوزاتي
- طلباتي
- تقاريري الطبية
- المفضلة
- السلة
- تسجيل الخروج

Medical Staff:
- بوابة الكادر / مهامي
- تسجيل الخروج

Company User:
- بوابة الشركة
- تسجيل الخروج

Admin/Manager المصرح له:
- لوحة التحكم الإدارية

Editor:
- يظهر له فقط رابط الإدارة المتعلق بالمحتوى الذي يملك Permission عليه.

لا تعتمد على إخفاء الرابط فقط.
احمِ Route وController وLivewire Actions Server-Side أيضًا.

========================================
4. شاشات العميل / المريض
========================================

راجع Customer Dashboard وتأكد من وجود شاشات فعلية ومنظمة مثل:

- نظرة عامة
- الملف الشخصي
- حجوزاتي / زياراتي
- طلباتي
- تفاصيل الحجز
- تفاصيل الطلب
- العناوين
- السلة
- المفضلة
- التقارير الطبية الخاصة بي
- تحميل PDF المصرح به
- تسجيل الخروج

المريض لا يستطيع رؤية بيانات أو تقارير أي مريض آخر.

========================================
5. Staff Portal
========================================

Staff Dashboard بوابة مستقلة للكادر وليست شاشة Admin.

حسب Role/Permission:

Doctor
Nurse
Physiotherapist
Lab Technician
وغيرها

تتضمن:

- Dashboard
- مهام اليوم
- الزيارات المسندة
- تفاصيل الزيارة
- Accept
- Start
- Complete
- Notes
- Timeline
- العينات المتعلقة به عند الصلاحية
- رفع PDF للتقرير عند الصلاحية

لا تعطِ كل Staff نفس الصلاحيات.

Customer Service وManager قد يحتاجان صلاحيات أوسع، حددها باستخدام Permission System.

========================================
6. Company Portal
========================================

أنشئ/راجع Company Portal الحقيقي.

حسب صلاحيات:
Company Admin
Company Operator
Company Viewer

يمكن أن يحتوي:

- Dashboard
- بيانات الشركة
- العقود
- الخدمات المتاحة
- الأسعار التعاقدية المصرح بعرضها
- المستفيدون
- إضافة مستفيد
- طلب خدمة لمستفيد
- الطلبات والزيارات
- متابعة حالة الطلب
- التقارير الطبية المصرح بها
- طباعة Service Request

يجب دعم أكثر من User لنفس الشركة.

Company Admin ≠ Operator ≠ Viewer.

ويجب منع IDOR بشكل كامل:
أي Company User لا يستطيع رؤية بيانات شركة أخرى حتى لو عدّل URL/ID يدويًا.

========================================
7. أعد بناء Admin Sidebar منطقيًا
========================================

لا تضع:

"بوابة الكادر الطبي"
و
"بوابة الشركات المتعاقدة"

كبديل لشاشات إدارة الأدمن.

هذه User Portals وليست Admin Management Screens.

نظم Sidebar تقريبًا بالشكل التالي:

Dashboard
├── الرئيسية ونظرة عامة
└── التحليلات والتقارير

Medical Operations
├── طلبات الخدمات والزيارات
├── البحث التشغيلي المتقدم
├── العينات المخبرية
└── التقارير الطبية

CRM
├── الكادر الطبي
└── المرضى / العملاء

Corporate
├── الشركات
├── طلبات التعاقد
├── العقود
├── المستفيدون
└── مستخدمو الشركات

Commerce
├── المنتجات
└── الطلبات والفواتير

Content
├── الخدمات
├── المدونة
├── الأسئلة الشائعة
├── التقييمات
├── الشركاء / الاعتمادات
└── CMS عند الحاجة

System
├── المستخدمون
├── الأدوار والصلاحيات
├── الإعدادات
└── سجل العمليات والأمان

يمكنك تحسين أسماء الأقسام بالعربية بما يتناسب مع التصميم الحالي.

ولا تظهر أي Menu Item للأدمن/الموظف إذا لم يملك Permission المناسبة.

========================================
8. Medical Operations Management
========================================

أنشئ شاشات Admin حقيقية تشمل:

- قائمة جميع طلبات الخدمات والزيارات.
- البحث والفلاتر.
- تفاصيل الطلب.
- Patient Information.
- Service Information.
- Company/Contract عند وجودهما.
- Assigned Staff.
- Assign.
- Reassign.
- Workflow.
- Verification.
- Notes.
- Timeline كامل.

Workflow الحالي:

requested
→ assigned
→ accepted
→ in_progress
→ completed
→ verified

مع معالجة Cancelled عند الحاجة.

كل انتقال يجب أن يخضع لقواعد Server-Side.

========================================
9. Medical Staff Management
========================================

Admin → CRM → Medical Staff

يجب أن يحتوي:

- قائمة الكادر.
- البحث والفلاتر.
- إضافة موظف.
- تعديل.
- عرض التفاصيل.
- Role/Staff Type.
- Specialty.
- Professional License Number.
- Job Title.
- Active/Inactive.
- بيانات الحساب.
- المهام المسندة.
- إحصائيات التنفيذ عند المناسب.

الأنواع تشمل:
Doctor
Nurse
Physiotherapist
Lab Technician
وغيرها بطريقة قابلة للتوسع.

========================================
10. Companies Management
========================================

Admin → Corporate → Companies

شاشات حقيقية:

- Companies List
- Create Company
- Company Details
- Edit Company
- Activate/Deactivate

داخل Company Details اعرض Tabs مناسبة مثل:

Overview
Users
Contracts
Beneficiaries
Service Requests
Visits
Reports

========================================
11. Contract Requests
========================================

Admin → Corporate → Contract Requests

يحتوي:

- New
- Under Review
- Approved
- Rejected

مع:
- List
- Search
- Filters
- Details
- Approve
- Reject
- Notes

عند Approve:
وفر Workflow يحول البيانات إلى:
Company + Contract

بدون إعادة إدخال نفس البيانات قدر الإمكان.

========================================
12. Contracts Management
========================================

Admin → Corporate → Contracts

يشمل:

- Contracts List
- Create
- View
- Edit
- Activate/Expire/Cancel حسب Business Rules
- Contract Number
- Company
- Start Date
- End Date
- Status
- Payment Terms
- Included Services
- Custom Contract Pricing
- Attachments عند وجودها
- Beneficiaries
- Related Requests

الأسعار الخاصة يجب حسابها Server-Side.

========================================
13. Beneficiaries Management
========================================

Admin → Corporate → Beneficiaries

يشمل:

- List
- Search
- Filter by Company
- Filter by Contract
- Create
- Edit
- Activate/Deactivate
- Identity Type
- Identity Number

أنواع الهوية:

Saudi National ID
Iqama
Border Number
GCC ID

إذا كان المستفيد Patient موجودًا مسبقًا، اربطه بالسجل الموجود بدل إنشاء Patient مكرر.

اعرض:
- بيانات المستفيد
- الشركة
- العقد
- طلباته
- زياراته
- التقارير المسموح بها

========================================
14. Company Users Management
========================================

أضف إدارة فعلية لمستخدمي الشركات.

Admin يستطيع:

- إضافة User لشركة.
- تعديل.
- تفعيل/تعطيل.
- ربطه بالشركة.
- تحديد دوره.
- تغيير Permissions.
- عرض نشاطه.

مثل:

Company Admin
Company Operator
Company Viewer

ولا تفترض أن لكل شركة User واحد فقط.

========================================
15. Laboratory Samples
========================================

Admin → Medical Operations → Laboratory Samples

يجب أن يحتوي:

- Samples List
- Visit Code
- Patient
- Identity
- Booking/Request
- Service
- Company
- Contract
- Assigned Staff
- Current Status
- Registered At
- Collected At
- Received At
- Result Ready At
- Actions

Workflow:

registered
→ assigned
→ sample_collected
→ sent_to_lab
→ received_by_lab
→ processing
→ result_ready

Visit Code يجب أن يكون Unique ولا يتكرر.

مثل:
VIS-2026-XXXXXX

مع UNIQUE Constraint في MySQL وآلية توليد آمنة.

مهم جدًا:
حاليًا لا تنشئ Structured Lab Result Fields.

النتيجة الطبية حاليًا = PDF فقط.

الموظف المصرح له:
- يرفع PDF.
- يستبدله عند الصلاحية.
- يشاهده.
- يحمله.

وكل عملية حساسة تسجل في Audit Log.

========================================
16. Medical Reports
========================================

أنشئ Admin Medical Reports Management حقيقية.

تشمل:

- Reports List
- Patient
- Visit Code
- Sample
- Company عند وجودها
- Uploaded By
- Upload Date
- Verification Status عند استخدامه
- View
- Download
- Replace
- Delete/Archive حسب السياسة

PDF يجب أن يبقى في Private Storage ولا يمكن الوصول إليه مباشرة.

Authorization إلزامي عند كل View/Download.

========================================
17. Analytics
========================================

راجع Analytics الموجودة وأكملها لتشمل بيانات MySQL حقيقية:

- Total Requested
- Assigned
- Accepted
- In Progress
- Completed
- Verified
- Cancelled
- Achievement Rate

Achievement Rate يجب أن يعكس فعليًا:
عدد الزيارات المطلوبة مقابل الزيارات المنفذة/المتحقق منها حسب تعريف Business Rule المعتمد.

أضف Filters:

- Date Range
- Company
- Contract
- Service
- Staff

وأضف Charts حقيقية.

لا تستخدم Mock Data.

========================================
18. Roles & Permissions
========================================

وجود Roles في Dropdown لا يعني أن النظام مكتمل.

راجع كل Role فعليًا:

customer
doctor
nurse
physio
lab_tech
customer_service
manager
company_admin
editor
admin

وأي Company Operator/Viewer مستخدمة.

أنشئ Permission Matrix مناسبة.

مثال:

view_operations
assign_services
accept_assignment
start_assignment
complete_assignment
verify_service
manage_staff
manage_patients
manage_companies
manage_contracts
manage_beneficiaries
manage_company_users
manage_lab_samples
upload_medical_reports
view_medical_reports
manage_products
manage_orders
manage_content
manage_users
manage_roles
manage_settings
view_audit_logs
view_analytics

استخدم النظام الحالي إن كان لديه Permission Architecture جيدة ولا تبنِ نظامًا مكررًا.

كل:
Page
Route
Controller Action
Livewire Action
Button

يجب أن يحترم Permissions المناسبة.

========================================
19. CRUD الصحيح
========================================

الأدمن لا يعني Hard Delete لكل شيء.

حدد الإجراء المناسب لكل Entity:

Create
View
Edit
Update
Activate/Deactivate
Archive
Soft Delete
Delete
Restore

حسب طبيعة البيانات.

لا تحذف نهائيًا بشكل عشوائي:
- السجلات الطبية
- التقارير
- الزيارات
- العقود
- العمليات المالية
- Audit Logs

إذا كان الحذف سيؤثر على سلامة السجل التاريخي.

========================================
20. VAT
========================================

راجع المشروع بالكامل وابحث عن أي:

15%
0.15
VAT hardcoded

VAT يجب أن تأتي من:

SettingsService / site_settings

القيمة الحالية يمكن أن تكون 15%، لكن يستطيع الأدمن تغييرها من Settings بدون تعديل الكود.

========================================
21. متطلبات كل شاشة
========================================

لا تعتبر الشاشة مكتملة لمجرد وجود Blade File.

كل شاشة حسب طبيعتها يجب أن تحتوي على:

- Page Title
- Breadcrumb
- Real MySQL Data
- Search
- Filters
- Pagination
- Sorting عند الحاجة
- Empty State
- Loading State عند الحاجة
- Form Validation
- Authorization
- Success/Error Feedback
- Responsive Design
- RTL
- Permission-based Actions

واستخدم Blade Components/Layouts الموجودة بدل تكرار Header/Footer/Buttons/Forms.

========================================
22. السيناريو الكامل للشركات
========================================

اختبر هذا السيناريو End-to-End:

Guest
→ خدمات الشركات
→ قراءة التفاصيل
→ طلب تعاقد
→ Contract Request يُحفظ في MySQL
→ يظهر للأدمن
→ Under Review
→ Approve
→ إنشاء Company
→ إنشاء Contract
→ تحديد Services
→ تحديد Contract Prices
→ إنشاء Company User
→ إضافة Beneficiaries
→ Company User Login
→ اختيار Beneficiary
→ طلب خدمة
→ استخدام السعر التعاقدي Server-Side
→ ظهور الطلب في Medical Operations
→ Assign Staff
→ Staff Accept
→ Start
→ Complete
→ Verify
→ الشركة تتابع Status

إذا كانت الخدمة تحليلًا:

→ إنشاء Visit Code
→ Sample Tracking
→ رفع Medical Report PDF
→ Result Ready
→ التقرير يظهر فقط للمصرح لهم.

========================================
23. افحص قبل أن تعدل
========================================

قبل إنشاء ملفات جديدة، افحص الموجود فعليًا.

أنشئ Requirement Audit Matrix:

Requirement
Backend Exists?
Database Exists?
Admin Screen Exists?
Public Screen Exists?
Customer Screen Exists?
Staff Screen Exists?
Company Screen Exists?
Route Exists?
Permission Exists?
Real DB Data?
Tested?
Status

بعدها أكمل الناقص فقط.

ممنوع إنشاء نسخة ثانية من Feature موجودة بالفعل.

========================================
24. اختبر الواجهات فعليًا
========================================

لا تقل COMPLETE بناءً على:
Migration موجودة
أو Model موجود
أو Route موجود.

اختبر الشاشة نفسها والـWorkflow.

اختبر على الأقل:

Guest
Customer
Doctor
Nurse
Lab Technician
Customer Service
Manager
Company Admin
Company Operator/Viewer
Editor
Admin

وتأكد من 403 للمستخدم غير المصرح له.

========================================
25. المطلوب في النهاية
========================================

بعد الانتهاء أعطني تقريرًا فعليًا وليس وصفًا عامًا.

أولًا:
Public Screens قبل تسجيل الدخول.

ثانيًا:
Customer/Patient Screens.

ثالثًا:
Staff Portal Screens.

رابعًا:
Company Portal Screens.

خامسًا:
Admin Screens.

لكل شاشة:

Screen Name | URL | Allowed Roles/Permissions | Navigation Location | Purpose | Main Actions | Tested

ثم أعطني:

- ما الذي كان موجودًا سابقًا.
- ما الذي كان Backend فقط وتم إنشاء UI له.
- ما الشاشات الجديدة التي أنشأتها.
- ما Routes الجديدة.
- ما Permissions الجديدة.
- ما الذي اختبرته فعليًا.
- أي شيء لا يزال ناقصًا.

وأعطني Admin Sidebar النهائي كشجرة.

وأعطني Public Header النهائي قبل وبعد Login.

وأعطني Staff Navigation.

وأعطني Company Navigation.

ثم حدث بدقة:

/docs/PROJECT_STATUS.md
/docs/SESSION_HANDOFF.md
/docs/CHANGELOG.md
/docs/ROUTES.md
/docs/ARCHITECTURE.md
/docs/DATABASE.md

إذا كانت هذه الملفات موجودة استخدمها ولا تنشئ نسخًا مكررة.

مهم:
حدّث PROJECT_STATUS.md بما تم تنفيذه فعليًا فقط، وليس ما هو مخطط له.

ولا تكتب COMPLETE لأي Feature لم يتم اختبار واجهتها وWorkflow الخاص بها فعليًا.

========================================
26. قاعدة أساسية
========================================

كل البيانات والوظائف يجب أن تكون حقيقية ومتصلة بـ MySQL.

ممنوع:
- Mock Data
- Fake Statistics
- Hardcoded Patients
- Hardcoded Companies
- Hardcoded Contracts
- Hardcoded Samples
- Hardcoded Reports
- Hardcoded Analytics
- واجهات شكلية لا تحفظ في Database
- أزرار بدون Backend Action

حافظ على Stack المشروع الحالي:
Laravel + MySQL + Blade + Livewire + Alpine.js + Tailwind CSS + Chart.js

ولا تغيّر Architecture أو Stack بدون ضرورة.

ابدأ أولًا بالفحص وإنشاء Requirement Audit Matrix، ثم اعرض خطة الأشياء الناقصة، وبعد ذلك نفذها مرحلة بمرحلة واختبر كل مرحلة قبل اعتبارها مكتملة.