# FINAL IMPLEMENTATION PROMPT
# Sema Al-Khalij — CRM, Medical Operations, Corporate Management & Laboratory Tracking

المشروع:
شركة سيما الخليج للخدمات الطبية
Sema Al-Khalij Medical Services

==================================================
0. السياق الأساسي للمشروع
==================================================

أنت تعمل على مشروع Laravel موجود بالفعل وليس مشروعًا جديدًا.

المطلوب إضافة وتطوير:

- CRM.
- Medical Operations.
- Service Assignment.
- Staff Management.
- Corporate Management.
- Contracts.
- Company Portal.
- Beneficiaries.
- Laboratory Sample Tracking.
- Medical PDF Reports.
- Advanced Operations Search.
- Operational Reports.
- Analytics.

داخل مشروع "سيما الخليج للخدمات الطبية" الحالي.

هذا نظام حقيقي Production-Oriented.

ليس:
- Demo.
- Prototype.
- Mockup.
- Simulation.

يجب أن تعمل جميع الوظائف فعليًا باستخدام Laravel + MySQL.

==================================================
1. اقرأ ملفات المشروع أولًا
==================================================

قبل كتابة أو تعديل أي كود:

أولًا اقرأ البرومبت الرئيسي الموجود في جذر المشروع:

sema-alkhalij-full-prompt.md

ثم اقرأ هذا الملف:

sema-alkhalij-crm-medical-operations-prompt.md

اعتبر:

sema-alkhalij-full-prompt.md
هو المرجع الأساسي للمشروع بالكامل.

وهذا الملف:
sema-alkhalij-crm-medical-operations-prompt.md

هو المرجع الخاص بإضافات:

CRM
Medical Operations
Corporate Management
Laboratory Tracking

لا تبدأ التنفيذ قبل فهم الملفين.

إذا وجدت تعارضًا:
- لا تخمن.
- لا تغير Architecture الأساسية من نفسك.
- سجل التعارض في الخطة.
- اختر الحل الأقل كسرًا للنظام الحالي.
- اطلب الموافقة إذا كان القرار سيؤثر على Architecture رئيسية.

==================================================
2. افحص المشروع الموجود فعليًا
==================================================

قبل إنشاء أي شيء افحص:

- composer.json
- package.json إن وجد
- .env.example
- config/
- routes/
- migrations
- seeders
- factories
- Models
- Controllers
- Services
- Actions إن وجدت
- Events
- Listeners
- Middleware
- Form Requests
- Policies
- Gates
- Roles
- Permissions
- Notifications
- Jobs إن وجدت
- Blade
- Blade Components
- Livewire Components
- Alpine.js
- Tailwind
- Admin Dashboard
- Customer Dashboard
- Authentication
- Email Verification
- Services
- Booking
- Products
- Cart
- Wishlist
- Checkout
- Payments
- Settings
- Analytics
- SEO
- Localization
- Audit Logs
- Tests
- docs/

افحص أيضًا قاعدة بيانات MySQL الحالية وجميع:

Tables
Columns
Indexes
Foreign Keys
Relationships

قبل إنشاء Migration جديد.

قاعدة إلزامية:

لا تنشئ Model أو Table أو Controller أو Service أو Component أو Feature يؤدي وظيفة موجودة مسبقًا.

قم بتوسيع الموجود بدل تكراره.

ولا تكسر أي Feature موجودة.

==================================================
3. الـStack الحالي
==================================================

التزم بالـStack الحالي للمشروع:

- PHP
- Laravel
- MySQL
- Blade
- Livewire
- Alpine.js
- Tailwind CSS
- Chart.js

لا تضف:

React
Vue
Next.js
Node Backend
Microservice

أو Backend منفصل بدون سبب معماري ضروري وموافقة.

يجب أن يبقى المشروع مناسبًا للاستضافة الحالية التي تعتمد على PHP/MySQL.

لا تعتمد على خدمات بنية تحتية غير متوفرة في الاستضافة.

==================================================
4. قاعدة صارمة: Real Data Only
==================================================

كل شيء يجب أن يكون حقيقيًا ومربوطًا بـMySQL.

ممنوع في النظام الفعلي:

- Fake Data.
- Mock Data.
- Static Arrays بدل DB.
- Hardcoded Users.
- Hardcoded Companies.
- Hardcoded Patients.
- Hardcoded Employees.
- Hardcoded Services.
- Hardcoded Bookings.
- Hardcoded Contracts.
- Hardcoded Prices.
- Hardcoded Statistics.
- Hardcoded Analytics.
- Hardcoded Visit Codes.
- Hardcoded Sample Results.
- Fake Charts.
- Fake Counters.
- Fake Success Messages.
- Fake Forms.
- UI-only implementations.

أي:

Counter
Chart
Table
Dashboard
Report
Search Result
Status
Analytics
Notification

يجب أن يعتمد على البيانات الحقيقية.

مثال:

ممنوع:

$completedVisits = 82;
$totalVisits = 100;

بل يجب حساب القيم من قاعدة البيانات.

Factories / Seeders مسموحة للتطوير والاختبارات فقط ولا يعتمد عليها Production.

==================================================
5. المرجع البصري والوظيفي Blazma
==================================================

يوجد داخل المشروع مجلد:

E:\Saudi\Jazan\Other projects\Sema-Alkhalij\code\تغذية بصرية

افحص محتويات هذا المجلد.

يحتوي على مواد وأكواد وواجهات مرجعية من نظام Blazma Operations.

استفد منه لفهم:

- Medical Operations.
- Samples Report.
- Advanced Search.
- Filters.
- Operational Tables.
- Sample Tracking.
- Status Tracking.
- Medical Reports.
- Corporate Operations.
- Workflow.
- UX الخاصة بالبحث التشغيلي.

لكن Blazma مرجع وظيفي وبصري فقط.

ممنوع:

- نسخ الكود حرفيًا.
- نسخ التصميم Pixel-by-Pixel.
- تغيير هوية سيما الخليج لتصبح مثل Blazma.
- الاعتماد على Blazma أثناء Runtime.
- إنشاء Integration معه حاليًا.

استخدم المفاهيم المناسبة وأعد تنفيذها باستخدام Architecture وهوية Sema Al-Khalij.

==================================================
6. CRM والمستخدمون
==================================================

وسّع نظام المستخدمين الحالي لدعم أدوار مثل:

- Super Admin / Admin حسب النظام الحالي.
- Manager.
- Customer Service.
- Doctor.
- Nurse.
- Physiotherapist.
- Laboratory / Results Employee.
- Company User.
- Patient / Customer.

مع إمكانية إضافة Roles مستقبلًا.

استخدم النظام الموجود للمشروع:

Roles
Permissions
Policies
Gates
Middleware

ولا تنشئ نظام صلاحيات مكرر.

كل مستخدم يرى فقط البيانات والعمليات المسموح بها.

==================================================
7. Medical Staff Profiles
==================================================

لا تضع جميع البيانات المهنية داخل users.

أنشئ أو استخدم Architecture مناسبة لملف الموظف الطبي مثل:

Staff Profile / Service Provider Profile.

يكون مرتبطًا بـUser.

يمكن أن يحتوي حسب الحاجة على:

- Specialty.
- Professional License Number.
- Job Title.
- Staff Type.
- Active Status.
- Professional Information.
- Availability عند الحاجة مستقبلًا.

User يبقى للحساب والمصادقة.

Staff Profile يبقى للبيانات المهنية.

==================================================
8. Patient Identification
==================================================

دعم أنواع الهوية:

- Saudi National ID.
- Iqama.
- Border Number.
- GCC National ID.

بتصميم مناسب مثل:

identification_type
identification_number

مع إمكانية البحث باستخدام:

- Patient Name.
- Mobile.
- Identification Type.
- Identification Number.

طبق Validation مناسبة حسب نوع الهوية عندما تكون القواعد معروفة.

لا تفترض Validation غير مؤكدة.

حافظ على سرية بيانات المرضى.

==================================================
9. Service Requests
==================================================

أنشئ أو وسّع مفهوم Service Request.

كل طلب خدمة يجب أن يمثل طلبًا حقيقيًا في قاعدة البيانات.

يمكن أن يحتوي حسب Architecture الحالية على:

- Unique Request Number.
- Patient.
- Company عند وجودها.
- Contract عند وجوده.
- Service.
- Requested Date.
- Requested Time.
- Address.
- Notes.
- Source.
- Status.
- Created By.
- Assigned Provider عند الإسناد.

لا تكرر Booking إذا كان الموجود يمكن توسيعه.

حدد أثناء Phase 1 العلاقة الصحيحة بين:

Service Request
Booking
Order
Corporate Request
Laboratory Sample

بحسب Architecture المشروع الحالية.

==================================================
10. Service Assignment
==================================================

كل طلب/حجز قابل للإسناد لمنفذ خدمة محدد.

يجب حفظ:

- Assigned Provider.
- Assigned By.
- Assigned At.
- Accepted At.
- Started At.
- Completed At.
- Verified At.
- Verified By.
- Notes.
- Current Status.

كل ذلك فعليًا في قاعدة البيانات.

==================================================
11. Service Workflow
==================================================

Workflow أساسي:

Requested
→ Assigned
→ Accepted / Received
→ In Progress
→ Completed
→ Verified

مع حالات استثنائية عند الحاجة:

Rejected
Cancelled
Unable to Complete

ممنوع الانتقال العشوائي.

يجب إنشاء قواعد Server-Side تحدد Allowed Transitions.

مثال:

Requested → Completed

غير مسموح إذا كان Workflow يتطلب Assignment وExecution.

لا تعتمد على إخفاء الزر فقط.

التحقق يجب أن يكون Backend Authorization حقيقيًا.

==================================================
12. Verification Permission
==================================================

مرحلة Verified حساسة.

لا تفترض أن منفذ الخدمة يستطيع اعتماد خدمته بنفسه.

أنشئ Permission مستقلة مثل:

verify_service

أو استخدم Naming Convention الحالي.

فقط المستخدم المصرح له يستطيع تحويل الخدمة إلى Verified.

يمكن إعطاء الصلاحية حسب سياسة الشركة إلى:

- Manager.
- Supervisor.
- Customer Service Supervisor.
- Admin.

حسب Roles/Permissions.

==================================================
13. Service Timeline
==================================================

كل Service Request يجب أن يمتلك History / Timeline.

سجل:

- Request Created.
- Assigned.
- Reassigned.
- Accepted.
- Started.
- Completed.
- Verified.
- Cancelled.
- وغيرها.

مع:

- Performed By.
- Timestamp.
- Previous Status.
- New Status.
- Notes.

استخدم Audit Log الحالي إذا كان مناسبًا.

لا تنشئ نظام Logging مكررًا بدون حاجة.

==================================================
14. Staff Dashboard
==================================================

إنشاء Dashboard حقيقية لمنفذي الخدمة.

تعرض من DB:

- Assigned Services.
- Today's Services.
- Upcoming Services.
- Waiting for Acceptance.
- In Progress.
- Completed.
- Cancelled.

حسب الصلاحيات.

يمكن للموظف:

- Accept.
- Start.
- Complete.
- Add Notes.

حسب Workflow.

لا تعرض معلومات مالية أو إدارية غير مصرح بها.

==================================================
15. Corporate CRM
==================================================

النظام يجب أن يدعم:

Company
→ Contracts
→ Company Users
→ Beneficiaries
→ Service Requests
→ Bookings / Operations
→ Laboratory Samples
→ Reports

بعلاقات فعلية في MySQL.

==================================================
16. Corporate Contract Requests
==================================================

إنشاء نموذج طلب تعاقد للشركات.

يمكن أن يحتوي:

- Company Name.
- Commercial Registration Number.
- Contact Person.
- Phone.
- Email.
- City.
- Requested Services.
- Expected Beneficiaries.
- Notes.
- Attachments عند الحاجة.

Workflow:

New
→ Under Review
→ Approved / Rejected

عند الموافقة:

يجب تسهيل تحويل الطلب إلى:

Company + Contract

بدون إعادة إدخال البيانات يدويًا قدر الإمكان.

==================================================
17. Companies
==================================================

كل Company تحتوي على بياناتها الأساسية.

يجب دعم:

- Active / Inactive.
- Contact Information.
- Contracts.
- Users.
- Beneficiaries.
- Requests.
- Reports.

لا تجعل بيانات الشركات Static.

==================================================
18. Contracts
==================================================

كل شركة يمكن أن تمتلك عقدًا أو أكثر.

العقد يمكن أن يحتوي:

- Unique Contract Number.
- Company.
- Start Date.
- End Date.
- Status.
- Included Services.
- Special Pricing.
- Payment Terms.
- Notes.
- Attachments.

Statuses مثل:

Draft
Pending
Active
Expired
Suspended
Cancelled

==================================================
19. Contract Payment Terms
==================================================

أضف دعم شروط الدفع.

لا تجعلها Hardcoded بطريقة تمنع التوسع.

قد تكون مثل:

- Immediate Payment.
- Monthly Invoice.
- Net 30.
- أو شروط مخصصة.

اختر التصميم الأنسب حسب قاعدة البيانات الحالية.

==================================================
20. Contract Pricing
==================================================

كل عقد يمكن أن يمتلك أسعارًا خاصة.

مثال:

Public Price:
Home Nursing = 250 SAR

Company Contract Price:
Home Nursing = 190 SAR

السعر العام لا يتغير.

Contract Pricing منفصل.

كل Price Calculation يجب أن يتم Server-Side.

ممنوع الثقة بأي Price قادم من Frontend.

==================================================
21. Beneficiaries
==================================================

كل عقد يمكن أن يمتلك Beneficiaries.

المستفيد قد يكون Patient موجودًا بالفعل.

لا تنشئ Patient مكررًا إذا كان الشخص موجودًا.

صمم العلاقات بحيث تدعم:

Company
→ Contract
→ Beneficiaries
→ Patient
→ Service Requests

مع مراعاة أن نفس الشخص قد يحتاج مستقبلًا لعلاقات مختلفة حسب Business Rules.

قبل التصميم النهائي افحص Models والجداول الموجودة.

==================================================
22. Company Users
==================================================

يمكن ربط عدة Users بالشركة.

دعم صلاحيات داخلية مثل:

- Company Admin.
- Company Operator.
- Company Viewer.

أو استخدم Permission System الحالي بطريقة أكثر مرونة إذا كان أفضل.

Company User لا يرى إلا شركته.

Company A ممنوع أن يصل إلى Company B.

طبق:

Ownership
Policies
Scopes عند الحاجة
Authorization

لمنع IDOR.

لا تعتمد على company_id القادم من Frontend بدون تحقق.

==================================================
23. Company Portal
==================================================

إنشاء Dashboard للشركة.

تعرض حسب Permissions:

- Company Information.
- Contract Information.
- Contract Status.
- Included Services.
- Contract Pricing.
- Beneficiaries.
- Create Service Request.
- Service Requests.
- Bookings.
- Visit Status.
- Completed Services.
- Laboratory Results.
- Reports.
- Invoices إذا كانت موجودة.

جميع Counters وCharts من DB.

==================================================
24. Company Service Request
==================================================

Company User يستطيع طلب خدمة لمستفيد.

الطلب يحتوي حسب الحاجة على:

- Request Number.
- Company.
- Contract.
- Beneficiary / Patient.
- Identification.
- Mobile.
- Service.
- Requested Date.
- Requested Time.
- Address.
- Notes.
- Status.

النظام يجب أن يتحقق Server-Side أن:

- المستخدم تابع للشركة.
- العقد صحيح.
- العقد يسمح بالخدمة.
- المستفيد تابع للعقد إذا كانت السياسة تتطلب ذلك.
- السعر المستخدم هو Contract Price الصحيح.

==================================================
25. Printable Service Request
==================================================

كل Service Request يجب أن يمتلك View منظمة للطباعة.

تحتوي:

- Request Number.
- Patient Information.
- Company.
- Contract.
- Requested Service.
- Visit Information.
- Relevant Operational Information.

بحيث يمكن استخدامه كمستند رسمي لتنفيذ الزيارة.

==================================================
26. Operational Visit Reports
==================================================

إنشاء تقارير حقيقية تعرض:

- Total Requested Visits.
- Assigned Visits.
- Accepted Visits.
- In Progress Visits.
- Completed Visits.
- Verified Visits.
- Cancelled Visits.
- Remaining Visits.

وحساب:

Achievement Rate

من DB.

حدد تعريف Achievement Rate بوضوح في Architecture.

مثلاً إذا كان الاعتماد النهائي هو Verified:

Verified Visits / Requested Eligible Visits × 100

ولا تستخدم أرقامًا ثابتة.

==================================================
27. Analytics
==================================================

Charts حقيقية باستخدام Chart.js وبيانات Backend.

مثل:

- Requested vs Completed.
- Requested vs Verified.
- Achievement Rate.
- Visits by Status.
- Visits Over Time.
- Visits by Service.
- Visits by Company.
- Visits by Employee.
- Top Requested Services.
- Employee Performance إذا كان مناسبًا.

Filters:

- Date From.
- Date To.
- Company.
- Contract.
- Service.
- Employee.
- Status.

استخدم AnalyticsService الحالي وقم بتوسيعه إن وجد.

==================================================
28. Laboratory Tracking
==================================================

المطلوب حاليًا:

Laboratory Tracking

وليس LIS كاملًا.

إذا كان Service متعلقًا بالتحاليل يمكن إنشاء Sample مرتبطة به.

Sample يجب أن ترتبط حسب Architecture المناسبة بـ:

- Patient.
- Service Request / Booking.
- Company عند وجودها.
- Contract عند وجوده.
- Assigned Staff.
- Visit Code.
- Sample Status.
- Timestamps.
- Medical Report.

==================================================
29. Unique Visit Code
==================================================

كل Sample يجب أن تحصل تلقائيًا على Visit Code فريد.

مثال شكلي فقط:

VIS-2026-000001

لكن لا تعتمد على هذا المثال إذا كان هناك Scheme أفضل.

المهم:

- Unique.
- لا يتكرر.
- Database UNIQUE Constraint.
- آمن مع Concurrent Requests.
- Searchable.
- User Friendly.

يمكن استخدام UUID داخلي أيضًا مع Visit Code ظاهر للمستخدم.

==================================================
30. Sample Workflow
==================================================

Workflow مناسب:

Registered
→ Assigned
→ Sample Collected
→ Sent to Lab
→ Received by Lab
→ Processing
→ Result Ready

مع:

Cancelled

عند الحاجة.

احفظ Timestamps المهمة.

امنع Invalid Transitions Server-Side.

==================================================
31. نتائج المختبر — PDF فقط حاليًا
==================================================

مهم جدًا:

لا تبنِ حاليًا LIS كاملًا.

لا تنشئ شاشة لإدخال:

Result Value
Reference Range
Units
CBC Values
AST
ALT
Cholesterol
أو Structured Laboratory Results.

المرحلة الحالية:

الموظف المختص يستلم التقرير النهائي من المختبر كـPDF.

ثم يرفعه للنظام.

اربط التقرير فعليًا بـ:

- Patient.
- Sample.
- Visit Code.
- Service Request.
- Booking عند وجوده.
- Company عند وجودها.
- Uploaded By.
- Uploaded At.

بعد الاعتماد المناسب تصبح النتيجة:

Result Ready.

==================================================
32. حماية Medical Reports
==================================================

PDF الطبي Sensitive Data.

ممنوع وضعه في Public Storage بحيث يمكن فتحه عبر URL مباشر بدون تحقق.

View / Download يجب أن يمر عبر:

Authentication
+
Authorization
+
Ownership / Permission Check

يجب تسجيل العمليات الحساسة مثل:

Upload
Replace
Delete
Download عند الحاجة

ولا تكشف Physical File Path للمستخدم.

تحقق من:

MIME Type
Extension
File Size
File Integrity قدر الإمكان

ولا تعتمد على اسم الملف فقط.

==================================================
33. Future LIS Integration
==================================================

مستقبلًا قد يتم ربط:

Laboratory Information System
→ API
→ Sema Al-Khalij

لذلك افصل Laboratory Integration عن Business Logic.

يمكن تجهيز Architecture مثل:

app/Services/Integrations/Laboratory/

أو Interface/Adapter مناسب.

لكن:

لا تنفذ External API حاليًا.
لا تنشئ Fake API.
لا تحاكي LIS.

المطلوب فقط Architecture قابلة للتوسع مستقبلًا.

==================================================
34. Advanced Operations Search
==================================================

استفد من فكرة Blazma Samples Report.

إنشاء Advanced Search باستخدام Livewire عند ملاءمته.

دعم البحث باستخدام:

- Service Request Number.
- Booking Number.
- Visit Code.
- Patient Name.
- Mobile.
- Identification Number.
- Identification Type.
- Company.
- Contract.
- Service.
- Assigned Employee.
- Service Status.
- Sample Status.
- Result Status.
- Date From.
- Date To.

دعم Composite Filters.

استخدم:

Query Scopes
Indexes
Pagination
Eager Loading

وتجنب:

N+1 Queries
Loading all records
Unindexed heavy searches

==================================================
35. Operations Results Table
==================================================

جدول احترافي يمكن أن يحتوي حسب الحاجة:

- Request Number.
- Visit Code.
- Patient.
- Identification.
- Company.
- Service.
- Assigned Provider.
- Requested Date.
- Assigned At.
- Started At.
- Completed At.
- Service Status.
- Sample Status.
- Result Status.
- Actions.

Actions تظهر حسب Permissions فقط.

==================================================
36. Export & Printing
==================================================

التقارير التشغيلية يجب أن تدعم حسب الحاجة:

- Print.
- CSV Export.
- Excel Export.

ويجب أن يطبق Export:

- نفس Filters.
- نفس Search.
- نفس Authorization.
- نفس Company Isolation.

ممنوع أن يسمح Export بتجاوز صلاحيات المستخدم.

إذا احتاج Excel إلى Package إضافية، تحقق أولًا من توافقها مع المشروع والاستضافة قبل إضافتها.

==================================================
37. Events & Notifications
==================================================

استخدم Events / Listeners الحالية إن وجدت.

أحداث مناسبة قد تشمل:

ServiceRequested
ServiceAssigned
ServiceAccepted
ServiceStarted
ServiceCompleted
ServiceVerified
CorporateContractRequested
CorporateContractApproved
SampleRegistered
SampleCollected
SampleResultReady
MedicalReportUploaded

استخدم:

Email
In-System Notifications

عند الحاجة.

لا نريد SMS حاليًا.

==================================================
38. Audit Logging
==================================================

سجل العمليات الحساسة:

- Service Assignment.
- Reassignment.
- Accept.
- Start.
- Complete.
- Verify.
- Patient Identification Changes.
- Company Changes.
- Contract Status Changes.
- Contract Pricing Changes.
- Beneficiary Changes.
- Sample Status Changes.
- Medical Report Upload.
- Medical Report Replace/Delete.
- Permission-sensitive operations.

ممنوع تسجيل:

Passwords
Plain Tokens
Secrets
OTP Codes
Sensitive Credentials

==================================================
39. Security Requirements
==================================================

طبق:

Authentication
Authorization
Policies
Gates
Middleware
Form Requests
CSRF Protection
Server-Side Validation
Mass Assignment Protection
Secure File Handling
Database Transactions
Ownership Checks
Rate Limiting عند الحاجة
Audit Logging

امنع:

- IDOR.
- Privilege Escalation.
- Company Data Leakage.
- Patient Data Leakage.
- Medical Report Leakage.
- Frontend Price Manipulation.
- Unauthorized Status Changes.
- Unauthorized Downloads.
- Unauthorized Export.
- Cross-company Access.

أي عملية حساسة يجب التحقق منها Server-Side.

==================================================
40. Concurrency & Data Integrity
==================================================

انتبه للعمليات التي يمكن أن تحدث في نفس الوقت.

استخدم عند الحاجة:

- Database Transactions.
- UNIQUE Constraints.
- Foreign Keys.
- Atomic Updates.
- Locking عند الضرورة.

خصوصًا:

- Visit Code generation.
- Request Number generation.
- Contract Number generation.
- Assignments.
- Status transitions.
- Pricing.
- Sample creation.

لا تعتمد فقط على Frontend أو PHP pre-check إذا كانت قاعدة البيانات تستطيع فرض Integrity.

==================================================
41. المحافظة على النظام الحالي
==================================================

ممنوع كسر:

Authentication
Email Verification
Admin Dashboard
Public Website
Services
Booking
Products
Cart
Wishlist
Checkout
Payments
Customer Dashboard
Settings
Analytics
SEO
Localization
Notifications

نفذ Regression Testing بعد التغييرات المهمة.

==================================================
42. UI/UX
==================================================

استخدم Design System الحالي لسيما الخليج.

Arabic RTL حاليًا.

English LTR جاهزة للتفعيل مستقبلًا.

Responsive:

Desktop
Tablet
Mobile

استخدم Components المشتركة.

لا تكرر:

Header
Footer
Buttons
Forms
Tables
Cards
Modals
Alerts

إذا كان Component مشتركًا مناسبًا.

استخدم Blade Components وLivewire Components بطريقة منظمة.

==================================================
43. الأداء
==================================================

انتبه إلى:

- Database Indexes.
- Pagination.
- Eager Loading.
- Query Scopes.
- Efficient Aggregations.
- Avoid N+1.
- Avoid loading huge datasets.
- Caching فقط عندما يكون مناسبًا وآمنًا.

لا تستخدم Cache بطريقة تعرض بيانات شركة لمستخدم شركة أخرى.

==================================================
44. Implementation Phases
==================================================

قبل البرمجة أنشئ Implementation Plan مفصلة.

استخدم المراحل التالية:

Phase 1 — Existing System Audit & Gap Analysis

Phase 2 — Database & Core Architecture

Phase 3 — Roles, Permissions & Staff Profiles

Phase 4 — Patients & Identification

Phase 5 — CRM & Service Requests

Phase 6 — Service Assignment & Execution Workflow

Phase 7 — Staff Dashboard

Phase 8 — Corporate CRM & Contract Requests

Phase 9 — Contracts, Payment Terms & Contract Pricing

Phase 10 — Beneficiaries, Company Users & Company Portal

Phase 11 — Laboratory Samples & Unique Visit Codes

Phase 12 — PDF Medical Reports & Secure Access

Phase 13 — Advanced Operations Search, Filters & Export

Phase 14 — Visit Reports, Analytics & Charts

Phase 15 — Events, Notifications & Audit Logging

Phase 16 — Security Review & Authorization Testing

Phase 17 — Full Integration, Performance & Regression Testing

Phase 18 — Documentation & Production Readiness

يمكن تعديل التقسيم فقط إذا اكتشفت سببًا معماريًا حقيقيًا أثناء فحص المشروع.

==================================================
45. تفاصيل كل Phase
==================================================

لكل Phase وضح:

1. Objective.
2. Existing Components Reused.
3. Requirements Covered.
4. Files To Modify.
5. Files To Create.
6. Database Changes.
7. Migrations.
8. Models.
9. Relationships.
10. Services / Actions.
11. Controllers.
12. Form Requests.
13. Livewire Components.
14. Blade Views.
15. Routes.
16. Roles / Permissions.
17. Policies.
18. Validation.
19. Security.
20. Events / Listeners.
21. Tests.
22. Acceptance Criteria.
23. Dependencies.
24. Risks.
25. Documentation Updates.

لا تقل فقط:

"Implement CRM"

بل وضح التنفيذ الفعلي.

==================================================
46. طريقة التنفيذ
==================================================

لا تنفذ 18 Phase دفعة واحدة.

أولًا:

1. اقرأ البرومبت الرئيسي.
2. اقرأ هذا البرومبت.
3. اقرأ ملفات docs الحالية.
4. افحص المشروع.
5. افحص قاعدة البيانات.
6. افحص تغذية بصرية.
7. اعمل Gap Analysis.
8. قدم الخطة.

لا تعدل الكود قبل عرض الخطة والموافقة عليها.

بعد الموافقة:

نفذ Phase واحدة في كل مرة.

بعد كل Phase:

- شغل Tests.
- افحص Errors.
- افحص Routes.
- افحص Database.
- افحص Permissions.
- افحص Security.
- افحص Regression.
- حدث Documentation.
- حدث Project Status.
- سجل Changes.
- حدد Exact Next Step.

==================================================
47. ملفات التوثيق الإلزامية
==================================================

أنشئ/حافظ على:

/docs/
├── AI_CONTEXT.md
├── PROJECT_STATUS.md
├── ARCHITECTURE.md
├── DATABASE.md
├── ROUTES.md
├── CHANGELOG.md
├── TODO.md
├── SESSION_HANDOFF.md
├── SECURITY.md
└── TESTING.md

إذا كانت الملفات موجودة:
حدثها ولا تنشئ نسخًا مكررة.

==================================================
48. AI_CONTEXT.md
==================================================

هذا هو الدستور الثابت للمشروع.

يجب أن يحتوي باختصار ودقة على:

- Project Name.
- Purpose.
- Approved Stack.
- Hosting Constraints.
- Database.
- Architecture Rules.
- Coding Rules.
- Security Rules.
- Dynamic Data Rule.
- No Hardcoded Business Data Rule.
- Localization Rules.
- Important Business Workflows.
- Important Architectural Decisions.
- Things AI Must Never Change Without Approval.
- Main Prompt Files.

أي AI جديد يجب أن يبدأ بقراءته.

==================================================
49. PROJECT_STATUS.md
==================================================

يجب أن يكون المصدر الأساسي لمعرفة أين وصل المشروع.

يحتوي دائمًا على:

Current Phase:
Current Task:

Completed:
- ...

In Progress:
- ...

Pending:
- ...

Database Changes:
- ...

New Files:
- ...

Modified Files:
- ...

Tests:
- Passed:
- Failed:
- Not Run:

Known Issues:
- ...

Important Decisions:
- ...

Next Exact Step:
- ...

Last Updated:
- ...

يجب تحديثه بعد كل مرحلة أو تغيير مهم.

==================================================
50. SESSION_HANDOFF.md
==================================================

هذا الملف مخصص للانتقال من AI إلى AI آخر.

يجب أن يكون مختصرًا لكن دقيقًا.

يحتوي:

- What was requested.
- What was completed.
- What is currently being worked on.
- Last files modified.
- Database changes.
- Commands executed.
- Tests executed.
- Errors still unresolved.
- Decisions made.
- Do not redo.
- Exact next action.
- Relevant docs to read.

الهدف:

AI جديد يستطيع استكمال المشروع بدون إعادة العمل أو التخمين.

==================================================
51. CHANGELOG.md
==================================================

بعد كل مجموعة تغييرات سجل:

- Date.
- Phase.
- Added.
- Changed.
- Fixed.
- Database Changes.
- Security Changes.

لا تسجل تفاصيل غير مفيدة.

==================================================
52. DATABASE.md
==================================================

حافظ على توثيق:

- Tables.
- Purpose.
- Important Columns.
- Foreign Keys.
- Relationships.
- Unique Constraints.
- Important Indexes.
- Status Fields.
- Business Rules.

حدّثه مع كل Migration.

==================================================
53. ARCHITECTURE.md
==================================================

وثق:

- Major Modules.
- Service Layer.
- Workflows.
- Events.
- Authorization.
- Data Flow.
- Corporate Isolation.
- Laboratory Architecture.
- Future Integration Points.

==================================================
54. SECURITY.md
==================================================

وثق القرارات الأمنية المهمة:

- Roles/Permissions.
- Policies.
- Company Isolation.
- Medical Report Protection.
- File Access.
- Sensitive Operations.
- Audit Logging.
- Rate Limits عند استخدامها.

لا تخزن Secrets في هذا الملف.

==================================================
55. TESTING.md
==================================================

وثق:

- Test Strategy.
- Important Feature Tests.
- Authorization Tests.
- Regression Tests.
- Known Testing Gaps.
- Commands.

==================================================
56. التعامل مع Token Limit وانتقال AI
==================================================

هذه قاعدة إلزامية.

إذا لاحظت أن Context/Token Budget يقترب من النهاية:

لا تبدأ Feature كبيرة جديدة.

أكمل أصغر وحدة حالية بشكل آمن قدر الإمكان.

ثم:

1. احفظ الكود.
2. شغل الاختبارات الممكنة.
3. حدث PROJECT_STATUS.md.
4. حدث SESSION_HANDOFF.md.
5. حدث CHANGELOG.md.
6. حدث TODO.md.
7. سجل أي Error غير محلول.
8. اكتب Exact Next Step.

يجب ألا يعتمد AI التالي على ذاكرة المحادثة السابقة.

يجب أن يستطيع معرفة الحالة من ملفات المشروع نفسها.

==================================================
57. بروتوكول بدء أي AI جديد
==================================================

في بداية أي جلسة جديدة:

لا تبدأ مباشرة بالبرمجة.

اقرأ بالترتيب:

1. sema-alkhalij-full-prompt.md
2. sema-alkhalij-crm-medical-operations-prompt.md
3. docs/AI_CONTEXT.md
4. docs/PROJECT_STATUS.md
5. docs/SESSION_HANDOFF.md
6. docs/ARCHITECTURE.md
7. docs/DATABASE.md
8. docs/TODO.md
9. آخر أجزاء docs/CHANGELOG.md

ثم افحص الكود المتعلق بـCurrent Task.

بعد ذلك:

أكد لنفسك:
- Current Phase.
- Completed Work.
- Current Work.
- Next Exact Step.

لا تعيد Feature مكتملة.

لا تفترض أن Documentation صحيحة 100% إذا تعارضت مع الكود:
تحقق من الكود وقاعدة البيانات ثم صحح التوثيق.

==================================================
58. Git / Checkpoints
==================================================

إذا كان المشروع يستخدم Git:

حافظ على تغييرات منظمة.

لا تخلط عدة Phases ضخمة في تغيير واحد.

بعد اكتمال Phase واختبارها، اجعلها نقطة واضحة قابلة للرجوع إليها.

لا تنفذ destructive Git commands بدون موافقة.

لا تحذف تغييرات المستخدم غير المرتبطة بالمهمة.

==================================================
59. الاختبارات المطلوبة
==================================================

لا تعتبر Feature مكتملة لأنها تعمل بصريًا فقط.

اختبر:

- Database Persistence.
- Validation.
- Authorization.
- Ownership.
- Workflow.
- Security.
- UI Integration.

سيناريوهات مهمة:

- Create Service Request.
- Assign Provider.
- Accept Assignment.
- Start Service.
- Complete Service.
- Verify Service.
- Invalid Status Transition.
- Timeline Persistence.
- Patient Search by Identification.
- Company Creation.
- Contract Request.
- Contract Creation.
- Contract Pricing.
- Payment Terms.
- Beneficiary Management.
- Company User Isolation.
- Company Role Permissions.
- Company Service Request.
- Sample Registration.
- Unique Visit Code.
- Concurrent Visit Code Safety.
- Sample Workflow.
- PDF Upload.
- Unauthorized PDF Access.
- Authorized PDF Access.
- Advanced Search.
- Composite Filters.
- Export Authorization.
- Analytics using real data.
- Existing Features Regression.

استخدم:

php artisan test

والاختبارات المناسبة للمشروع.

==================================================
60. Definition of Done
==================================================

أي Feature لا تعتبر مكتملة إلا إذا:

- Backend حقيقي موجود.
- مربوطة فعليًا بـMySQL.
- البيانات Persist.
- Validation تعمل.
- Authorization تعمل.
- Ownership تعمل.
- UI تستخدم بيانات حقيقية.
- Workflow يعمل Server-Side.
- Audit يعمل عند الحاجة.
- Tests المناسبة تمر.
- لا يوجد Hardcoded Business Data.
- لا يوجد Mock Implementation.
- لا يوجد Fake Success.
- لا يوجد Button بدون Backend.
- لا يوجد Form لا يحفظ.
- لا يوجد Chart ثابت.
- لا يوجد Counter ثابت.
- لا يوجد TODO مخفي يعتبر Feature مكتملة.
- Documentation محدثة.

==================================================
61. لا تبالغ في Architecture
==================================================

نريد Architecture نظيفة وقابلة للتوسع، لكن لا تنشئ تعقيدًا غير مطلوب.

طبق:

DRY
SOLID
Separation of Concerns
OOP
Reusable Components
Service Layer

عندما تكون مناسبة.

لكن تجنب:

Overengineering
Unnecessary Abstractions
Duplicate Services
Duplicate Models
Huge God Classes

Controllers يجب أن تبقى خفيفة قدر الإمكان.

Business Logic المهمة توضع في Services/Actions المناسبة.

==================================================
62. المطلوب منك الآن
==================================================

لا تبدأ كتابة الكود الآن.

نفذ فقط:

1. اقرأ:
   sema-alkhalij-full-prompt.md

2. اقرأ:
   sema-alkhalij-crm-medical-operations-prompt.md

3. اقرأ ملفات /docs الحالية إن وجدت.

4. افحص المشروع الحالي بالكامل.

5. افحص MySQL Schema الحالية.

6. افحص:
   E:\Saudi\Jazan\Other projects\Sema-Alkhalij\code\تغذية بصرية

7. افهم ما تم تنفيذه بالفعل.

8. قارن الموجود بجميع المتطلبات في البرومبتين.

9. صنف المتطلبات إلى:

EXISTING
PARTIALLY EXISTS
MISSING
NEEDS MODIFICATION

10. اكتشف:
- Duplicate Risk.
- Architecture Conflicts.
- Missing Relationships.
- Missing Permissions.
- Security Risks.
- Database Changes Required.

11. صمم:
- Data Relationships.
- Service Workflow.
- Sample Workflow.
- Corporate Workflow.
- Permissions Matrix.
- Company Isolation Strategy.
- Secure Medical Report Access.
- Future LIS Integration Boundary.

12. ثم قدم Implementation Plan كاملة ومقسمة إلى Phase 1 → Phase 18.

لكل Phase وضح الملفات والجداول والعلاقات والصلاحيات والاختبارات ومعايير القبول بالتفصيل.

لا تعدل أي كود قبل أن تعرض الخطة عليّ وأوافق عليها.

==================================================
63. الهدف النهائي
==================================================

الهدف بناء نظام متكامل حقيقي داخل منصة سيما الخليج يجمع:

Public Medical Website
+
E-Commerce
+
Booking
+
CRM
+
Medical Operations
+
Staff Operations
+
Corporate Management
+
Contracts
+
Company Portal
+
Beneficiaries
+
Laboratory Sample Tracking
+
Secure PDF Medical Reports
+
Operational Search
+
Reports
+
Analytics

مع:

Real MySQL Data
Secure Authorization
Auditability
Scalable Architecture
Responsive UI
Arabic RTL
Future English LTR
Future LIS/API Readiness

وبدون:

Fake Data
Mock Features
Hardcoded Business Data
Duplicate Architecture
Public Medical Reports
Unauthorized Data Access

ويجب أن تكون حالة المشروع موثقة باستمرار داخل /docs بحيث يستطيع أي AI أو مطور جديد معرفة بالضبط:

ماذا تم إنجازه؟
أين وصل المشروع؟
ما الملفات التي تغيرت؟
ما التغييرات في قاعدة البيانات؟
ما الاختبارات التي تم تشغيلها؟
ما المشاكل الحالية؟
وما الخطوة التالية بالضبط؟