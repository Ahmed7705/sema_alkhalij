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
- واتساب
- رقم الهاتف
- تسجيل الدخول / أيقونة الحساب
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