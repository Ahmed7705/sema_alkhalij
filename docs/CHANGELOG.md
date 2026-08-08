# Changelog — Sema Al-Khalij Medical Services

## [Phase 10] - 2026-08-08 - Notifications, Communication, Scheduling, Background Jobs & Integrations

### Added
- **Database Migrations**:
  - `notifications` table (core Laravel database notification driver).
  - `notification_preferences` table (per-user channel configuration).
  - `user_device_tokens` table (FCM and Web Push token registry).
  - `communication_logs` table (multi-channel delivery log).
  - `webhooks` & `webhook_logs` tables (incoming & outgoing webhook log).
  - `activity_logs` table (user timeline feed).
- **Eloquent Models & Relationships**:
  - `NotificationPreference`, `UserDeviceToken`, `CommunicationLog`, `Webhook`, `WebhookLog`, `ActivityLog`.
  - Added `deviceTokens()`, `notificationPreferences()`, `communicationLogs()`, and `activityLogs()` relationships to `User` model.
- **Service Layer & Decoupled Drivers**:
  - `NotificationEngine`: Multi-channel notification dispatcher checking user preferences.
  - `SmsService` adhering to `SmsDriverInterface`.
  - `WhatsAppService` adhering to `WhatsAppDriverInterface`.
  - `PushNotificationService` managing FCM device tokens.
  - `WebhookService` managing outgoing HMAC signed webhooks and incoming payloads.
- **Queue Jobs**:
  - `SendEmailJob`, `SendSmsJob`, `SendWhatsAppJob`, `SendPushNotificationJob`, `DispatchWebhookJob`, `GeneratePdfReportJob`.
- **Scheduled Console Tasks**:
  - `sema:check-low-stock`: Daily automated warehouse inventory threshold check.
  - `sema:check-expiry-alerts`: Daily 60-day batch expiry check.
- **User Interface & Controllers**:
  - `NotificationController` & `/notifications` view with category filters, unread badges, mark read, and delete.
  - `/notifications/preferences` multi-channel matrix configuration form.
  - `ActivityFeedController` & `/profile/activity` user timeline feed view.
  - `Admin\SystemHealthController` & `/admin/system/health`, `/admin/system/queues`, `/admin/system/webhooks` dashboards.
- **API Endpoints**:
  - `/api/v1/webhooks/incoming` incoming third-party webhook handler.
- **Automated Feature Test Suite**:
  - `tests/Feature/Phase10NotificationsCommunicationJobsTest.php` (11/11 Passed).
