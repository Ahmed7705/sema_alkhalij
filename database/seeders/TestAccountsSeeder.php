<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contract;
use App\Models\StaffProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestAccountsSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure Demo Company Exists for Corporate Users
        $company = Company::updateOrCreate(
            ['cr_number' => '1010999888'],
            [
                'name' => 'شركة أرامكو للتطوير الصحي (حساب تجريبي)',
                'phone' => '0112223333',
                'email' => 'corporate@sema-alkhalij.com',
                'city' => 'الرياض',
                'address' => 'طريق الملك فهد، البرج الشمالي',
                'status' => 'active',
            ]
        );

        // Ensure Demo Contract Exists for Company Portal
        Contract::updateOrCreate(
            ['contract_number' => 'CNT-2026-0001'],
            [
                'company_id' => $company->id,
                'start_date' => now()->subMonth(),
                'end_date' => now()->addYear(),
                'payment_terms' => 'monthly_invoice',
                'status' => 'active',
            ]
        );

        $defaultPassword = Hash::make('password123');

        $users = [
            [
                'email' => 'admin@sema-alkhalij.com',
                'name' => 'مدير النظام التنفيذي',
                'phone' => '0590000001',
                'role' => 'admin',
                'company_id' => null,
            ],
            [
                'email' => 'manager@sema-alkhalij.com',
                'name' => 'مدير العمليات الطبية',
                'phone' => '0590000002',
                'role' => 'manager',
                'company_id' => null,
            ],
            [
                'email' => 'customer@sema-alkhalij.com',
                'name' => 'سارة الأحمد (عميل/مريض)',
                'phone' => '0551234567',
                'role' => 'customer',
                'company_id' => null,
            ],
            [
                'email' => 'doctor@sema-alkhalij.com',
                'name' => 'د. خالد المنصور (طبيب استشاري)',
                'phone' => '0590000003',
                'role' => 'doctor',
                'staff_type' => 'doctor',
                'specialty' => 'طب أسرة وزيارات منزلية',
                'license_number' => 'MOH-DOC-99881',
                'job_title' => 'طبيب استشاري طب أسرة',
                'company_id' => null,
            ],
            [
                'email' => 'nurse@sema-alkhalij.com',
                'name' => 'منى السعدي (تمريض منزلي)',
                'phone' => '0590000004',
                'role' => 'nurse',
                'staff_type' => 'nurse',
                'specialty' => 'تمريض عام ورعاية منزلية',
                'license_number' => 'MOH-NRS-44552',
                'job_title' => 'أخصائية تمريض منزلي',
                'company_id' => null,
            ],
            [
                'email' => 'physio@sema-alkhalij.com',
                'name' => 'أحمد الشهري (علاج طبيعي)',
                'phone' => '0590000005',
                'role' => 'physio',
                'staff_type' => 'physio',
                'specialty' => 'تأهيل وعلاج طبيعي',
                'license_number' => 'MOH-PHY-33221',
                'job_title' => 'أخصائي علاج طبيعي كبار السن',
                'company_id' => null,
            ],
            [
                'email' => 'lab@sema-alkhalij.com',
                'name' => 'طارق الزهراني (فني مختبر)',
                'phone' => '0590000006',
                'role' => 'lab_tech',
                'staff_type' => 'lab_tech',
                'specialty' => 'سحب وتحليل العينات المخبرية',
                'license_number' => 'MOH-LAB-77663',
                'job_title' => 'فني سحب وتحليل عينات منزلي',
                'company_id' => null,
            ],
            [
                'email' => 'support@sema-alkhalij.com',
                'name' => 'نورة العتيبي (خدمة العملاء)',
                'phone' => '0590000007',
                'role' => 'customer_service',
                'company_id' => null,
            ],
            [
                'email' => 'company.admin@sema-alkhalij.com',
                'name' => 'فيصل الغامدي (مسؤول شركة أرامكو)',
                'phone' => '0590000008',
                'role' => 'company_admin',
                'company_id' => $company->id,
            ],
            [
                'email' => 'company.operator@sema-alkhalij.com',
                'name' => 'ريم الدوسري (منسقة شركة أرامكو)',
                'phone' => '0590000009',
                'role' => 'company_operator',
                'company_id' => $company->id,
            ],
            [
                'email' => 'editor@sema-alkhalij.com',
                'name' => 'سلطان القحطاني (محرر محتوى)',
                'phone' => '0590000010',
                'role' => 'editor',
                'company_id' => null,
            ],
        ];

        foreach ($users as $uData) {
            $staffType = $uData['staff_type'] ?? null;
            $specialty = $uData['specialty'] ?? null;
            $licenseNumber = $uData['license_number'] ?? null;
            $jobTitle = $uData['job_title'] ?? null;

            unset($uData['staff_type'], $uData['specialty'], $uData['license_number'], $uData['job_title']);

            $uData['password'] = $defaultPassword;
            $uData['email_verified_at'] = now();
            $uData['is_active'] = true;

            $user = User::updateOrCreate(
                ['email' => $uData['email']],
                $uData
            );

            if ($staffType) {
                StaffProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'staff_type' => $staffType,
                        'specialty' => $specialty,
                        'license_number' => $licenseNumber,
                        'job_title' => $jobTitle,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
