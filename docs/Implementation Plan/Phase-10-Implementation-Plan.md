# Phase 10 Implementation Plan — Notifications, Communication, Scheduling, Background Jobs & Integrations

**Project Name**: Sema Al-Khalij Medical Services & Operations  
**Phase**: Phase 10 — Notifications, Communication, Scheduling, Background Jobs & Integrations  
**Date**: 2026-08-08  
**Status**: 🚀 IN PROGRESS  

---

## 1. Goal Description

Phase 10 adds an enterprise-grade Notification, Communication, Background Queue, Scheduler, and Integration Infrastructure to Sema Al-Khalij Medical Services. It provides unified in-app notification centers, multi-channel dispatching (In-App, Email, SMS, WhatsApp, Push), granular user communication preferences, asynchronous queue background processing, system cron scheduler tasks, activity timeline feeds, external integration driver architectures, incoming/outgoing webhooks with retry capabilities, and real-time queue & system health monitoring.

---

## 2. Technical Architecture & Database Schema

### 2.1 Database Migrations
1. `create_notification_preferences_table`: User preference per event category and channel.
2. `create_user_device_tokens_table`: FCM / APNS device registration tokens for push notifications.
3. `create_communication_logs_table`: Unified log table for `email_logs`, `sms_logs`, `whatsapp_logs`, and `push_logs`.
4. `create_webhooks_and_logs_table`: Incoming/outgoing webhook endpoints, signing secrets, payload logs, and retry counts.
5. `create_activity_logs_table`: User timeline activity feed (`bookings`, `payments`, `reports`, `auth`).

### 2.2 Core Models
- `App\Models\NotificationPreference`
- `App\Models\UserDeviceToken`
- `App\Models\CommunicationLog`
- `App\Models\Webhook`
- `App\Models\WebhookLog`
- `App\Models\ActivityLog`

### 2.3 Core Services & Drivers
- `App\Services\NotificationEngine`: Central notification router dispatching across enabled channels (In-App, Email, SMS, WhatsApp, Push) according to user preferences.
- `App\Services\Drivers\SmsDriverInterface` & `App\Services\Drivers\SmsService`: Decoupled SMS gateway integration (Twilio/Unifonic/Yamamah).
- `App\Services\Drivers\WhatsAppDriverInterface` & `App\Services\Drivers\WhatsAppService`: Decoupled WhatsApp Business API integration (Meta/Twilio/Ultramsg).
- `App\Services\Drivers\PushNotificationService`: Firebase Cloud Messaging (FCM) integration.
- `App\Services\WebhookService`: Dispatches outgoing webhooks with HMAC signatures and logs incoming webhooks.

### 2.4 Queue Jobs
- `App\Jobs\SendEmailJob`: Asynchronous mail dispatch.
- `App\Jobs\SendSmsJob`: Asynchronous SMS dispatch.
- `App\Jobs\SendWhatsAppJob`: Asynchronous WhatsApp dispatch.
- `App\Jobs\SendPushNotificationJob`: Asynchronous FCM push notification dispatch.
- `App\Jobs\DispatchWebhookJob`: Asynchronous webhook delivery with retry logic.
- `App\Jobs\GeneratePdfReportJob`: Offloaded heavy PDF report generation.

### 2.5 Console Scheduler
- Low stock check & alert job (Daily).
- Expiry batch warning job (Daily).
- Corporate contract expiration warning job (Daily).
- Medical staff license expiration check (Weekly).
- Automated cleanup of expired tokens and old communication logs (Monthly).

---

## 3. UI Views & Controllers

- `App\Http\Controllers\NotificationController`: Customer & Staff In-App Notification Center (`index`, `markAsRead`, `markAllAsRead`, `destroy`, `preferences`, `updatePreferences`).
- `App\Http\Controllers\ActivityFeedController`: Customer chronological timeline activity feed (`/profile/activity`).
- `App\Http\Controllers\Admin\SystemHealthController`: Admin Queue & System Health Monitoring dashboard (`/admin/system/health`, `/admin/system/queues`, `/admin/system/webhooks`).
- `App\Http\Controllers\Api\WebhookController`: Public incoming webhooks endpoint (`/api/v1/webhooks/incoming`).

---

## 4. Verification Plan

### 4.1 Automated Feature Test Suite
- `tests/Feature/Phase10NotificationsCommunicationJobsTest.php`:
  1. In-App Notification Center CRUD & Mark as Read.
  2. Granular Notification Channel Preferences (Email, SMS, WhatsApp, Push).
  3. Automatic Notification Engine Trigger on Account Verification / Booking / Payment / Lab / Invoice / Inventory events.
  4. Asynchronous Queue Job execution and Failed Job retry handling.
  5. Push Notification Device Token registration and management.
  6. Incoming & Outgoing Webhooks processing with HMAC signature verification.
  7. Console Scheduler task execution.
  8. User Activity Timeline Feed.
  9. System Health & Queue Monitoring authorization and access control.
  10. IDOR and Server-Side Isolation.

### 4.2 Full Regression Suite
- Run `vendor/bin/phpunit` across all 10 phases.
- Run `php artisan route:list`.
