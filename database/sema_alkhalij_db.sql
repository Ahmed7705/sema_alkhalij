-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2026 at 03:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sema_alkhalij_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(191) NOT NULL DEFAULT 'المنزل',
  `city` varchar(191) NOT NULL DEFAULT 'الرياض',
  `district` varchar(191) DEFAULT NULL,
  `street` varchar(191) DEFAULT NULL,
  `building_no` varchar(191) DEFAULT NULL,
  `additional_info` text DEFAULT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `label`, `city`, `district`, `street`, `building_no`, `additional_info`, `lat`, `lng`, `is_default`, `created_at`, `updated_at`) VALUES
(3, 29, 'المنزل - الرئيسي', 'الرياض', 'الياسمين', 'طريق أنس بن مالك', '402', 'بجوار صيدلية الدواء - الشقة 4', 24.8123450, 46.6345670, 1, '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(4, 29, 'مقر العمل', 'الرياض', 'العليا', 'طريق الملك فهد', '105', 'برج التعاونية - الدور 8', 24.7123450, 46.6745670, 0, '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(5, 29, 'المنزل - الرئيسي', 'الرياض', 'الياسمين', 'طريق أنس بن مالك', '402', 'بجوار صيدلية الدواء - الشقة 4', 24.8123450, 46.6345670, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(6, 29, 'مقر العمل', 'الرياض', 'العليا', 'طريق الملك فهد', '105', 'برج التعاونية - الدور 8', 24.7123450, 46.6745670, 0, '2026-08-03 22:07:26', '2026-08-03 22:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(191) NOT NULL,
  `model_type` varchar(191) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(191) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name_ar`, `name_en`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'التثقيف الطبي المنزلي', NULL, 'home-health-care', '2026-08-03 22:06:32', '2026-08-03 22:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title_ar` varchar(191) NOT NULL,
  `title_en` varchar(191) DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `excerpt_ar` text DEFAULT NULL,
  `excerpt_en` text DEFAULT NULL,
  `content_ar` longtext DEFAULT NULL,
  `content_en` longtext DEFAULT NULL,
  `featured_image` varchar(191) DEFAULT NULL,
  `meta_title_ar` varchar(191) DEFAULT NULL,
  `meta_description_ar` varchar(191) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `category_id`, `author_id`, `title_ar`, `title_en`, `slug`, `excerpt_ar`, `excerpt_en`, `content_ar`, `content_en`, `featured_image`, `meta_title_ar`, `meta_description_ar`, `tags`, `is_published`, `published_at`, `views_count`, `created_at`, `updated_at`) VALUES
(2, 1, 28, 'أهمية الفحص الطبي الدوري الشامل وكيفية إجرائه في المنزل', NULL, 'importance-of-regular-checkups', 'تعرف على أهم الفحوصات الطبية الدورية التي يمكنك إجراؤها من منزلك بضغطة زر.', NULL, 'الفحص الطبي الدوري يمثل خط الدفاع الأول للوقاية من الأمراض المزمنة واكتشاف أي نقص في الفيتامينات والمعادن مبكراً...', NULL, NULL, NULL, NULL, NULL, 1, '2026-08-03 22:07:26', 340, '2026-08-03 22:07:26', '2026-08-03 22:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contract_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_name` varchar(191) DEFAULT NULL,
  `identification_type` varchar(191) DEFAULT NULL,
  `identification_number` varchar(191) DEFAULT NULL,
  `booking_number` varchar(191) NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` varchar(191) NOT NULL,
  `city` varchar(191) NOT NULL DEFAULT 'الرياض',
  `address` text NOT NULL,
  `phone` varchar(191) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(191) NOT NULL DEFAULT 'unpaid',
  `payment_method` varchar(191) NOT NULL DEFAULT 'cash',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned_provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_by` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `accepted_at` timestamp NULL DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `callback_requests`
--

CREATE TABLE `callback_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `service_type` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(191) NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `type` enum('service','product') NOT NULL DEFAULT 'service',
  `icon` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `type`, `icon`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'الزيارات الطبية', 'doctor-visits', 'service', 'stethoscope', 'خدمات كشف وتطبيب منزلية بواسطة أطباء مرخصين.', 1, 0, '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(2, 'التمريض المنزلي', 'home-nursing', 'service', 'user-nurse', 'رعاية تمريضية شامِلة وتركيب المغذيات وتغيير الجروح.', 1, 0, '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(3, 'الفحوصات والمختبر', 'lab-tests', 'service', 'flask', 'سحب عينات الدم والفحوصات الجينية والمخبرية من منزلك.', 1, 0, '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(4, 'العلاج الطبيعي', 'physiotherapy', 'service', 'activity', 'جلسات تأهيل وعلاج طبيعي لكبار السن وحالات ما بعد العمليات.', 1, 0, '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(5, 'الأجهزة الطبية المنزلية', 'medical-devices', 'product', 'heart-pulse', 'أجهزة قياس الضغط والسكر والأكسجين والنيبولايزر.', 1, 0, '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(6, 'المستلزمات الطبية', 'medical-supplies', 'product', 'package', 'مستلزمات التعقيم والجروح والكراسي المتحركة.', 1, 0, '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(7, 'الكراسي والأسرة الطبية', 'mobility-beds', 'product', 'truck', 'كراسي متحركة، أسرّة كهربائية، ومساعدات الحركة.', 1, 0, '2026-08-03 22:06:32', '2026-08-03 22:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `certifications`
--

CREATE TABLE `certifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certifications`
--

INSERT INTO `certifications` (`id`, `name_ar`, `name_en`, `logo`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'ترخيص وزارة الصحة السعودية', NULL, 'images/cert-moh.png', 1, 1, '2026-08-03 22:06:32', '2026-08-03 22:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `is_coming_soon` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `cr_number` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `cr_number`, `phone`, `email`, `city`, `address`, `status`, `created_at`, `updated_at`) VALUES
(2, 'شركة أرامكو للتطوير الصحي (حساب تجريبي)', '1010999888', '0112223333', 'corporate@sema-alkhalij.com', 'الرياض', 'طريق الملك فهد، البرج الشمالي', 'active', '2026-08-03 22:10:24', '2026-08-03 22:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `message` text NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_number` varchar(191) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `payment_terms` varchar(191) NOT NULL DEFAULT 'immediate',
  `status` varchar(191) NOT NULL DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `contract_number`, `company_id`, `start_date`, `end_date`, `payment_terms`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'CNT-2026-0001', 2, '2026-07-04', '2027-08-04', 'monthly_invoice', 'active', NULL, '2026-08-03 22:11:10', '2026-08-03 22:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `contract_beneficiaries`
--

CREATE TABLE `contract_beneficiaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id_number` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_prices`
--

CREATE TABLE `contract_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `custom_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_requests`
--

CREATE TABLE `contract_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(191) NOT NULL,
  `cr_number` varchar(191) DEFAULT NULL,
  `contact_person` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `city` varchar(191) DEFAULT NULL,
  `requested_services` text DEFAULT NULL,
  `expected_beneficiaries` int(11) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_uses` int(11) NOT NULL DEFAULT 100,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(191) NOT NULL DEFAULT 'general',
  `question_ar` text NOT NULL,
  `question_en` text DEFAULT NULL,
  `answer_ar` text NOT NULL,
  `answer_en` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `category`, `question_ar`, `question_en`, `answer_ar`, `answer_en`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'الزيارات الطبية', 'كيف يمكنني حجز زيارة طبيب منزلي؟', NULL, 'يمكنك الحجز بسهولة عبر موقعنا باختيار الخدمة المناسبة، ثم تحديد التاريخ والوقت والعنوان المناسبين لك، وسيصلك الفريق الطبي في الموعد المكتوب.', NULL, 1, 1, '2026-08-03 22:06:32', '2026-08-03 22:06:32'),
(2, 'الكوادر والجودة', 'هل الكوادر الطبية مرخصة من الهيئة السعودية للتخصصات الصحية؟', NULL, 'نعم، 100% من أطبائنا وممرضينا وأخصائيي المختبر مرخصون رسمياً ومصنفون من الهيئة السعودية للتخصصات الصحية.', NULL, 2, 1, '2026-08-03 22:06:32', '2026-08-03 22:06:32'),
(3, 'المختبر والفحوصات', 'متى تظهر نتائج الفحوصات المخبرية المنزلية؟', NULL, 'تظهر معظم نتائج الفحوصات العامة والفيتامينات خلال 12 إلى 24 ساعة كحد أقصى، وتصلك بصيغة PDF معتمدة على الواتساب وحسابك بالموقع.', NULL, 3, 1, '2026-08-03 22:06:32', '2026-08-03 22:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `lab_samples`
--

CREATE TABLE `lab_samples` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visit_code` varchar(191) NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contract_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sample_status` varchar(191) NOT NULL DEFAULT 'registered',
  `collected_at` timestamp NULL DEFAULT NULL,
  `received_at` timestamp NULL DEFAULT NULL,
  `result_ready_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_reports`
--

CREATE TABLE `medical_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lab_sample_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `visit_code` varchar(191) DEFAULT NULL,
  `file_path` varchar(191) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `file_size` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `mime_type` varchar(191) NOT NULL DEFAULT 'application/pdf',
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_08_03_000001_create_categories_table', 1),
(6, '2026_08_03_000002_create_services_table', 1),
(7, '2026_08_03_000003_create_products_table', 1),
(8, '2026_08_03_000004_create_bookings_table', 1),
(9, '2026_08_03_000005_create_orders_table', 1),
(10, '2026_08_03_000006_create_site_settings_table', 1),
(11, '2026_08_03_000007_create_addresses_table', 1),
(12, '2026_08_03_000008_create_roles_and_permissions_tables', 1),
(13, '2026_08_03_000009_create_cities_table', 1),
(14, '2026_08_03_000010_create_cart_and_wishlist_tables', 1),
(15, '2026_08_03_000010_create_product_images_table', 1),
(16, '2026_08_03_000012_create_payments_and_coupons_tables', 1),
(17, '2026_08_03_000013_create_blog_tables', 1),
(18, '2026_08_03_000014_create_faqs_reviews_partners_stats_tables', 1),
(19, '2026_08_03_000015_create_system_support_tables', 1),
(20, '2026_08_03_000016_add_uuid_to_orders_and_bookings_tables', 1),
(21, '2026_08_03_000017_add_zatca_fields_to_orders_table', 1),
(22, '2026_08_03_000018_create_audit_logs_table', 1),
(23, '2026_08_04_000001_create_crm_operations_tables', 1),
(24, '2026_08_04_000002_create_corporate_crm_tables', 1),
(25, '2026_08_04_000003_create_laboratory_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) NOT NULL,
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(191) DEFAULT NULL,
  `order_number` varchar(191) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(191) NOT NULL DEFAULT 'unpaid',
  `payment_method` varchar(191) NOT NULL DEFAULT 'cash',
  `city` varchar(191) NOT NULL DEFAULT 'الرياض',
  `shipping_address` text NOT NULL,
  `phone` varchar(191) NOT NULL,
  `notes` text DEFAULT NULL,
  `zatca_qr` text DEFAULT NULL,
  `zatca_hash` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_views`
--

CREATE TABLE `page_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(191) DEFAULT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `referrer` varchar(191) DEFAULT NULL,
  `device_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `website_url` varchar(191) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `logo`, `website_url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'مختبرات العرب المعتمدة', 'images/partner-lab.png', 'https://example.com', 1, 1, '2026-08-03 22:06:32', '2026-08-03 22:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payable_type` varchar(191) NOT NULL,
  `payable_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(191) NOT NULL DEFAULT 'SAR',
  `provider` varchar(191) NOT NULL,
  `transaction_id` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `raw_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`raw_response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `group` varchar(191) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 100,
  `sku` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `title`, `slug`, `short_description`, `description`, `price`, `discount_price`, `stock`, `sku`, `image`, `is_featured`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 5, 'جهاز قياس ضغط الدم الرقمي الذكي', 'smart-blood-pressure-monitor', 'جهاز ناطق ذكي مع شاشة LED وكاشف لعدم انتظام ضربات القلب.', 'جهاز طبّي دقيق معتمد من هيئة الغذاء والدواء السعودية لحفظ القراءات لشخصين حتى 120 قراءة مع شاشة ملونة سهلة القراءة وكاشف لتصلب الشرايين.', 220.00, 175.00, 45, 'MED-BP-01', 'prod-bp.png', 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(2, 5, 'طقم جهاز قياس السكر بالدم الشامل', 'glucometer-kit', 'طقم فحص السكر يشتمل على الجهاز + 50 شريحة فحص + قلم الوخز.', 'نتائج سريعة خلال 5 ثوانٍ فقط بدقة عالية وضمان مدى الحياة. يشمل 50 شريحة فحص معقمة و100 إبرة وخز ناعمة.', 140.00, 110.00, 80, 'MED-GL-02', 'prod-glucometer.png', 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(3, 7, 'كرسي متحرك طبي خفيف الوزن قابل للطي', 'foldable-wheelchair', 'كرسي متحرك هيكل ألومنيوم مقوى مع مساند مريحة وفرامل يد مزدوجة.', 'يتحمل وزن حتى 120 كجم وسهل الطي والوضع في شنطة السيارة، ممتص للصدمات ومزود بمقعد مريح ضد التقرحات.', 650.00, 580.00, 15, 'MED-WC-03', 'prod-wheelchair.png', 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(4, 5, 'جهاز قياس نسبة الأكسجين بالدم وضربات القلب', 'pulse-oximeter', 'جهاز نبضات وأكسجين إلكتروني سريع مع شاشة OLED ملونة.', 'يقيس نسبة SpO2 ومعدل النبض في 3 ثوانٍ بلمسة واحدة، مناسب لمرضى الربو والجهاز التنفسي وكبار السن.', 95.00, 75.00, 60, 'MED-PO-04', 'prod-oximeter.png', 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(5, 5, 'جهاز استنشاق البخار الطبي (نيبولايزر) للربو والحساسية', 'nebulizer-compressor', 'جهاز جلسات البخار المنزلي الهادئ المخصص للأطفال والكبار.', 'يحول الدواء السائل إلى رذاذ ناعم جداً لسهولة التنفس، مزود بجميع القناعات الطبية الخاصة بالأطفال والكبار ورأس استنشاق الفم.', 180.00, 145.00, 30, 'MED-NEB-05', 'prod-nebulizer.png', 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(6, 5, 'ميزان حرارة عن بعد بالأشعة تحت الحمراء (بدون تلامس)', 'infrared-thermometer', 'قياس الحرارة الفوري للجبهة والأجسام خلال ثانية واحدة.', 'قياس دقيق بدون تلامس لتفادي نقل العدوى، مع إضاءة خلفية تحذيرية عند ارتفاع درجة الحرارة (حمى).', 120.00, 89.00, 50, 'MED-TH-06', 'prod-supplies.png', 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(7, 6, 'طقم غيار الجروح المعقم الشامل', 'sterile-wound-dressing-kit', 'حقيبة ضمادات ومطهرات معقمة عالية الجودة للجروح وتقرحات الفراش.', 'تحتوي على ضمادات غير لاصقة، مسحات طبية، شاش معقم، شريط طبي لاصق ضد الماء، ومحلول سالين معقم.', 85.00, 65.00, 100, 'MED-SK-07', 'prod-firstaid.png', 0, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(8, 7, 'سرير طبي كهربائي 3 حركات للرعاية المنزلية', 'electric-medical-bed', 'سرير طبي متطور بريموت كنترول للتحكم بالظهر والأرجل والارتفاع.', 'مزود بجوانب حماية للأمان، مرتبة طبية مقاوِمة للتقرحات، وعجلات بسلسلة فرامل مركزية لراحة المرضى وكبار السن.', 2800.00, 2450.00, 5, 'MED-BED-08', 'prod-bed.png', 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(191) NOT NULL,
  `alt_text_ar` varchar(191) DEFAULT NULL,
  `alt_text_en` varchar(191) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refunds`
--

CREATE TABLE `refunds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` text DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewable_type` varchar(191) NOT NULL,
  `reviewable_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `reviewable_type`, `reviewable_id`, `rating`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 29, 'App\\Models\\Service', 1, 5, 'خدمة ممتازة وسريعة جداً. وصل الطبيب في الموعد المحدد وقام بالكشف الكامل على الوالد بكل مهنية واحترام.', 1, '2026-08-03 22:06:32', '2026-08-03 22:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `duration_minutes` int(11) NOT NULL DEFAULT 60,
  `image` varchar(191) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `title`, `slug`, `short_description`, `description`, `price`, `discount_price`, `duration_minutes`, `image`, `is_featured`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'الرعاية الصحية المنزلية', 'home-health-care', 'برامج مخصصة لكبار السن وأصحاب الأمراض المزمنة في بيئة منزلية دافئة وآمنة.', 'تتضمن الخدمة الرعاية الصحية الشاملة والمستمرة لكبار السن والمرضى في بيئتهم المنزلية بإشراف طاقم طبي متخصص.', 250.00, 220.00, 60, NULL, 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(2, 1, 'الزيارات الطبية المنزلية', 'home-doctor-visits', 'أطباء واستشاريون لمعاينة المريض، التشخيص الدقيق، ووصف العلاج في المنزل.', 'أطباء واستشاريون مرخصون يصلون لمنزلك لمعاينة المريض وإجراء الفحص السريري الكامل وصرف العلاجات.', 300.00, 260.00, 45, NULL, 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(3, 2, 'التمريض المنزلي 24/7', 'home-nursing-247', 'رعاية تمريضية متواصلة، متابعة العلامات الحيوية، العناية بالجروح والمغذيات.', 'خدمات تمريضية متخصصة متواصلة على مدار 12 أو 24 ساعة للعناية بالمؤشرات الحيوية والمغذيات والجروح.', 450.00, 390.00, 720, NULL, 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(4, 4, 'العلاج الطبيعي والتأهيل', 'physiotherapy-rehab', 'جلسات تأهيلية مخصصة لما بعد العمليات والجلطات وإصابات العظام والعضلات.', 'برامج تأهيل حركي وتأهيل لما بعد الجلطات والعمليات الجراحية بأحدث الأجهزة المحمولة.', 300.00, 250.00, 60, NULL, 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(5, 3, 'سحب العينات المنزلي', 'home-blood-sampling', 'أخصائي سحب عينات يحضر لمنزلك بأدوات معقمة مع نتائج إلكترونية سريعة.', 'سحب عينات الدم بشكل آمن ومريح بالمنزل وإرسالها للمختبر المعتمد مع استلام النتائج إلكترونياً.', 150.00, 120.00, 30, NULL, 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(6, 3, 'الفحوصات المخبرية الشاملة', 'comprehensive-lab-tests', 'باقات فحوصات وقائية شاملة: الوظائف، الفيتامينات، الدهون، والسكر بنسب دقيقة.', 'تحاليل شاملة تشمل 25 مؤشر حيوي لوظائف الكبد والكلى، السكر، الفيتامينات، والدهون بنسب دقيقة.', 350.00, 245.00, 30, NULL, 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(7, 3, 'الفحوصات الجينية والوراثية', 'genetic-dna-tests', 'تحاليل DNA وبصمة جينية وكشف مبكر عن الأمراض الوراثية بأعلى سرية.', 'فحوصات البصمة الجينية وDNA المتقدمة للكشف المبكر عن الأمراض الوراثية والجينومية بأعلى درجات السرية.', 600.00, 520.00, 45, NULL, 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(8, 1, 'الاستشارات الطبية', 'medical-teleconsultation', 'استشارات طارئة ومرئية هاتفية مع استشاريين متميزين لمتابعة حالتك الصحّية.', 'استشارات مرئية فورية ومتابعة هاتفية مع استشاريين لمراجعة الفحوصات وتعديل الخطط العلاجية.', 200.00, 150.00, 30, NULL, 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26'),
(9, 1, 'خدمات الرعاية للشركات', 'corporate-medical-care', 'تجهيز عيادات موقعية، فحوصات دورية للموظفين، وتغطية الفعاليات والمؤتمرات.', 'عقود رعاية طبية متكاملة للمؤسسات والشركات تشمل العيادات الداخلية وفحوصات الموظفين وتغطية المؤتمرات.', 1000.00, 850.00, 120, NULL, 1, 1, '2026-08-03 22:07:26', '2026-08-03 22:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(191) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'سيما الخليج للخدمات الطبية', 'general', '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(2, 'phone', '0590000000', 'general', '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(3, 'email', 'info@sema-alkhalij.com', 'general', '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(4, 'address', 'الرياض - المملكة العربية السعودية', 'general', '2026-08-03 22:06:31', '2026-08-03 22:06:31'),
(5, 'vat_rate', '15', 'general', '2026-08-03 22:06:31', '2026-08-03 22:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `site_stats`
--

CREATE TABLE `site_stats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label_ar` varchar(191) NOT NULL,
  `label_en` varchar(191) DEFAULT NULL,
  `value` varchar(191) NOT NULL,
  `icon` varchar(191) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_stats`
--

INSERT INTO `site_stats` (`id`, `label_ar`, `label_en`, `value`, `icon`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'مرضى تم خدمتهم', NULL, '+15,000', 'users', 1, 1, '2026-08-03 22:06:32', '2026-08-03 22:06:32'),
(2, 'طبيب وممرض مرخص', NULL, '+120', 'user-check', 2, 1, '2026-08-03 22:06:32', '2026-08-03 22:06:32'),
(3, 'زيارة منزلية ناجحة', NULL, '+45,000', 'home', 3, 1, '2026-08-03 22:06:32', '2026-08-03 22:06:32'),
(4, 'نسبة رضا المرضى', NULL, '99.2%', 'heart', 4, 1, '2026-08-03 22:06:32', '2026-08-03 22:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `staff_profiles`
--

CREATE TABLE `staff_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `staff_type` varchar(191) NOT NULL DEFAULT 'doctor',
  `specialty` varchar(191) DEFAULT NULL,
  `license_number` varchar(191) DEFAULT NULL,
  `job_title` varchar(191) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_profiles`
--

INSERT INTO `staff_profiles` (`id`, `user_id`, `staff_type`, `specialty`, `license_number`, `job_title`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 32, 'doctor', 'طب أسرة وزيارات منزلية', 'MOH-DOC-99881', 'طبيب استشاري طب أسرة', 1, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(2, 33, 'nurse', 'تمريض عام ورعاية منزلية', 'MOH-NRS-44552', 'أخصائية تمريض منزلي', 1, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(3, 34, 'physio', 'تأهيل وعلاج طبيعي', 'MOH-PHY-33221', 'أخصائي علاج طبيعي كبار السن', 1, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(4, 35, 'lab_tech', 'سحب وتحليل العينات المخبرية', 'MOH-LAB-77663', 'فني سحب وتحليل عينات منزلي', 1, '2026-08-03 22:11:10', '2026-08-03 22:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `identification_type` varchar(191) DEFAULT NULL,
  `identification_number` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `google_id` varchar(191) DEFAULT NULL,
  `apple_id` varchar(191) DEFAULT NULL,
  `verification_code` varchar(191) DEFAULT NULL,
  `code_expires_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `role` varchar(191) NOT NULL DEFAULT 'customer',
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `identification_type`, `identification_number`, `phone`, `avatar`, `google_id`, `apple_id`, `verification_code`, `code_expires_at`, `email_verified_at`, `password`, `role`, `company_id`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(28, 'مدير النظام التنفيذي', 'admin@sema-alkhalij.com', NULL, NULL, '0590000001', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:11:10', '$2y$10$Q3u9bRmN8HDSRG4Uazr5uubolQpiXtyegSWjrfm.xd9Sq8ElB1m6O', 'admin', NULL, 1, '6TFiImsbSIyJ0AiKDFA18g7YutYbWX85h2PWysg6p603p4PcsWpluTW9ZzVC', '2026-08-03 22:06:31', '2026-08-03 22:11:10'),
(29, 'أحمد عبدالله', 'user@example.com', NULL, NULL, '0551234567', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:07:26', '$2y$10$VUhcivXiJ9QAUFlqcdMsIesDjZ8B0.bVIJH6ETqnTNLIvDNXDXamq', 'customer', NULL, 1, NULL, '2026-08-03 22:06:31', '2026-08-03 22:07:26'),
(30, 'مدير العمليات الطبية', 'manager@sema-alkhalij.com', NULL, NULL, '0590000002', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:11:10', '$2y$10$Q3u9bRmN8HDSRG4Uazr5uubolQpiXtyegSWjrfm.xd9Sq8ElB1m6O', 'manager', NULL, 1, NULL, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(31, 'سارة الأحمد (عميل/مريض)', 'customer@sema-alkhalij.com', NULL, NULL, '0551234567', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:11:10', '$2y$10$Q3u9bRmN8HDSRG4Uazr5uubolQpiXtyegSWjrfm.xd9Sq8ElB1m6O', 'customer', NULL, 1, NULL, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(32, 'د. خالد المنصور (طبيب استشاري)', 'doctor@sema-alkhalij.com', NULL, NULL, '0590000003', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:11:10', '$2y$10$Q3u9bRmN8HDSRG4Uazr5uubolQpiXtyegSWjrfm.xd9Sq8ElB1m6O', 'doctor', NULL, 1, NULL, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(33, 'منى السعدي (تمريض منزلي)', 'nurse@sema-alkhalij.com', NULL, NULL, '0590000004', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:11:10', '$2y$10$Q3u9bRmN8HDSRG4Uazr5uubolQpiXtyegSWjrfm.xd9Sq8ElB1m6O', 'nurse', NULL, 1, NULL, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(34, 'أحمد الشهري (علاج طبيعي)', 'physio@sema-alkhalij.com', NULL, NULL, '0590000005', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:11:10', '$2y$10$Q3u9bRmN8HDSRG4Uazr5uubolQpiXtyegSWjrfm.xd9Sq8ElB1m6O', 'physio', NULL, 1, NULL, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(35, 'طارق الزهراني (فني مختبر)', 'lab@sema-alkhalij.com', NULL, NULL, '0590000006', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:11:10', '$2y$10$Q3u9bRmN8HDSRG4Uazr5uubolQpiXtyegSWjrfm.xd9Sq8ElB1m6O', 'lab_tech', NULL, 1, NULL, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(36, 'نورة العتيبي (خدمة العملاء)', 'support@sema-alkhalij.com', NULL, NULL, '0590000007', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:11:10', '$2y$10$Q3u9bRmN8HDSRG4Uazr5uubolQpiXtyegSWjrfm.xd9Sq8ElB1m6O', 'customer_service', NULL, 1, NULL, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(37, 'فيصل الغامدي (مسؤول شركة أرامكو)', 'company.admin@sema-alkhalij.com', NULL, NULL, '0590000008', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:11:10', '$2y$10$Q3u9bRmN8HDSRG4Uazr5uubolQpiXtyegSWjrfm.xd9Sq8ElB1m6O', 'company_admin', 2, 1, NULL, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(38, 'ريم الدوسري (منسقة شركة أرامكو)', 'company.operator@sema-alkhalij.com', NULL, NULL, '0590000009', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:11:10', '$2y$10$Q3u9bRmN8HDSRG4Uazr5uubolQpiXtyegSWjrfm.xd9Sq8ElB1m6O', 'company_operator', 2, 1, NULL, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(39, 'سلطان القحطاني (محرر محتوى)', 'editor@sema-alkhalij.com', NULL, NULL, '0590000010', NULL, NULL, NULL, NULL, NULL, '2026-08-03 22:11:10', '$2y$10$Q3u9bRmN8HDSRG4Uazr5uubolQpiXtyegSWjrfm.xd9Sq8ElB1m6O', 'editor', NULL, 1, NULL, '2026-08-03 22:11:10', '2026-08-03 22:11:10'),
(40, 'IT', 'a715038805@gmail.com', NULL, NULL, '0526319376', 'https://lh3.googleusercontent.com/a/ACg8ocJ2w1VRqFZsnhCJVh8ZaAaCAEitO3W5Q9cyl2pYHghmBb0IVd4S=s96-c', '113581226480300057147', NULL, NULL, NULL, '2026-08-03 22:11:59', '$2y$10$PtVPB0xR/Hpq7k7EpigH1OBlXNWzae2FlQ3jyW9OvCVO5ApEUwi3e', 'customer', NULL, 1, NULL, '2026-08-03 22:11:59', '2026-08-03 22:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(191) NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_categories_slug_unique` (`slug`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  ADD KEY `blog_posts_category_id_foreign` (`category_id`),
  ADD KEY `blog_posts_author_id_foreign` (`author_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_booking_number_unique` (`booking_number`),
  ADD UNIQUE KEY `bookings_uuid_unique` (`uuid`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_service_id_foreign` (`service_id`),
  ADD KEY `bookings_assigned_provider_id_foreign` (`assigned_provider_id`),
  ADD KEY `bookings_assigned_by_foreign` (`assigned_by`),
  ADD KEY `bookings_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `callback_requests`
--
ALTER TABLE `callback_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`),
  ADD KEY `cart_items_service_id_foreign` (`service_id`),
  ADD KEY `cart_items_session_id_index` (`session_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `certifications`
--
ALTER TABLE `certifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_cr_number_unique` (`cr_number`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contracts_contract_number_unique` (`contract_number`),
  ADD KEY `contracts_company_id_foreign` (`company_id`);

--
-- Indexes for table `contract_beneficiaries`
--
ALTER TABLE `contract_beneficiaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contract_beneficiaries_contract_id_patient_id_unique` (`contract_id`,`patient_id`),
  ADD KEY `contract_beneficiaries_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `contract_prices`
--
ALTER TABLE `contract_prices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contract_prices_contract_id_service_id_unique` (`contract_id`,`service_id`),
  ADD KEY `contract_prices_service_id_foreign` (`service_id`);

--
-- Indexes for table `contract_requests`
--
ALTER TABLE `contract_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_samples`
--
ALTER TABLE `lab_samples`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lab_samples_visit_code_unique` (`visit_code`),
  ADD KEY `lab_samples_patient_id_foreign` (`patient_id`),
  ADD KEY `lab_samples_booking_id_foreign` (`booking_id`),
  ADD KEY `lab_samples_assigned_staff_id_foreign` (`assigned_staff_id`);

--
-- Indexes for table `medical_reports`
--
ALTER TABLE `medical_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_reports_lab_sample_id_foreign` (`lab_sample_id`),
  ADD KEY `medical_reports_patient_id_foreign` (`patient_id`),
  ADD KEY `medical_reports_booking_id_foreign` (`booking_id`),
  ADD KEY `medical_reports_uploaded_by_foreign` (`uploaded_by`),
  ADD KEY `medical_reports_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newsletter_subscribers_email_unique` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD UNIQUE KEY `orders_uuid_unique` (`uuid`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_service_id_foreign` (`service_id`);

--
-- Indexes for table `page_views`
--
ALTER TABLE `page_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_views_user_id_foreign` (`user_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_payable_type_payable_id_index` (`payable_type`,`payable_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refunds_payment_id_foreign` (`payment_id`),
  ADD KEY `refunds_processed_by_foreign` (`processed_by`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_reviewable_type_reviewable_id_index` (`reviewable_type`,`reviewable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `role_permission_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`),
  ADD KEY `services_category_id_foreign` (`category_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Indexes for table `site_stats`
--
ALTER TABLE `site_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_profiles`
--
ALTER TABLE `staff_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlist_items_user_id_foreign` (`user_id`),
  ADD KEY `wishlist_items_product_id_foreign` (`product_id`),
  ADD KEY `wishlist_items_service_id_foreign` (`service_id`),
  ADD KEY `wishlist_items_session_id_index` (`session_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `callback_requests`
--
ALTER TABLE `callback_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `certifications`
--
ALTER TABLE `certifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contract_beneficiaries`
--
ALTER TABLE `contract_beneficiaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contract_prices`
--
ALTER TABLE `contract_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contract_requests`
--
ALTER TABLE `contract_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lab_samples`
--
ALTER TABLE `lab_samples`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_reports`
--
ALTER TABLE `medical_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_views`
--
ALTER TABLE `page_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refunds`
--
ALTER TABLE `refunds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `site_stats`
--
ALTER TABLE `site_stats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff_profiles`
--
ALTER TABLE `staff_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `blog_posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_assigned_provider_id_foreign` FOREIGN KEY (`assigned_provider_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contract_beneficiaries`
--
ALTER TABLE `contract_beneficiaries`
  ADD CONSTRAINT `contract_beneficiaries_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contract_beneficiaries_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contract_prices`
--
ALTER TABLE `contract_prices`
  ADD CONSTRAINT `contract_prices_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contract_prices_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lab_samples`
--
ALTER TABLE `lab_samples`
  ADD CONSTRAINT `lab_samples_assigned_staff_id_foreign` FOREIGN KEY (`assigned_staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lab_samples_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lab_samples_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_reports`
--
ALTER TABLE `medical_reports`
  ADD CONSTRAINT `medical_reports_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `medical_reports_lab_sample_id_foreign` FOREIGN KEY (`lab_sample_id`) REFERENCES `lab_samples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_reports_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_reports_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_reports_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `page_views`
--
ALTER TABLE `page_views`
  ADD CONSTRAINT `page_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `refunds`
--
ALTER TABLE `refunds`
  ADD CONSTRAINT `refunds_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `refunds_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `staff_profiles`
--
ALTER TABLE `staff_profiles`
  ADD CONSTRAINT `staff_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `wishlist_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_items_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
