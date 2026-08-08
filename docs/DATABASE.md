# Database Architecture & Schema Directory — Sema Al-Khalij

**Database Type**: MySQL 8.0 / SQLite (Testing)  
**Last Updated**: 2026-08-08  

## Phase 10 Created Tables

### 1. `notifications`
- `id` (UUID Primary Key)
- `type` (varchar 255)
- `notifiable_type`, `notifiable_id` (Morph index)
- `data` (text JSON)
- `read_at` (timestamp nullable)
- `created_at`, `updated_at`

### 2. `notification_preferences`
- `id` (BigInt Primary Key)
- `user_id` (Foreign Key -> `users.id`)
- `event_type` (varchar 255)
- `in_app`, `email`, `sms`, `whatsapp`, `push` (boolean)
- `created_at`, `updated_at`

### 3. `user_device_tokens`
- `id` (BigInt Primary Key)
- `user_id` (Foreign Key -> `users.id`)
- `device_token` (varchar 255 unique)
- `device_type` (varchar 50: `web`, `android`, `ios`)
- `device_name` (varchar 255 nullable)
- `last_used_at` (timestamp nullable)
- `created_at`, `updated_at`

### 4. `communication_logs`
- `id` (BigInt Primary Key)
- `user_id` (Foreign Key -> `users.id` nullable)
- `channel` (enum: `email`, `sms`, `whatsapp`, `push`)
- `recipient` (varchar 255)
- `subject` (varchar 255 nullable)
- `message` (text)
- `status` (enum: `pending`, `sent`, `failed`, `delivered`)
- `provider` (varchar 100 nullable)
- `provider_ref` (varchar 255 nullable)
- `response_payload` (json nullable)
- `error_message` (text nullable)
- `sent_at` (timestamp nullable)

### 5. `webhooks` & `webhook_logs`
- `webhooks`: `id`, `name`, `type` (`incoming`/`outgoing`), `url`, `secret`, `events` (json), `is_active` (boolean).
- `webhook_logs`: `id`, `webhook_id`, `type`, `event`, `url`, `headers` (json), `payload` (json), `status_code`, `status`, `attempts`, `error_message`.

### 6. `activity_logs`
- `id` (BigInt Primary Key)
- `user_id` (Foreign Key -> `users.id`)
- `activity_type` (varchar 100)
- `description_ar`, `description_en` (varchar 255)
- `subject_type`, `subject_id` (Morph nullable)
- `properties` (json nullable)
- `ip_address`, `user_agent` (varchar 255 nullable)
