# Registered Routes Directory — Sema Al-Khalij Medical Services

**Total Active Routes**: 190 Routes  
**Last Updated**: 2026-08-08  

## Phase 10 Added Routes

| HTTP Method | Path / URI | Route Name | Controller & Action | Middleware |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/notifications` | `notifications.index` | `NotificationController@index` | `auth` |
| `POST` | `/notifications/{id}/read` | `notifications.read` | `NotificationController@markAsRead` | `auth` |
| `POST` | `/notifications/read-all` | `notifications.read-all` | `NotificationController@markAllAsRead` | `auth` |
| `DELETE` | `/notifications/{id}` | `notifications.destroy` | `NotificationController@destroy` | `auth` |
| `GET` | `/notifications/preferences` | `notifications.preferences` | `NotificationController@preferences` | `auth` |
| `POST` | `/notifications/preferences` | `notifications.preferences.update` | `NotificationController@updatePreferences` | `auth` |
| `POST` | `/notifications/device-token` | `notifications.device-token` | `NotificationController@registerDeviceToken` | `auth` |
| `GET` | `/profile/activity` | `profile.activity` | `ActivityFeedController@index` | `auth` |
| `GET` | `/admin/system/health` | `admin.system.health` | `Admin\SystemHealthController@index` | `auth`, `role:admin` |
| `GET` | `/admin/system/queues` | `admin.system.queues` | `Admin\SystemHealthController@queues` | `auth`, `role:admin` |
| `GET` | `/admin/system/webhooks` | `admin.system.webhooks` | `Admin\SystemHealthController@webhooks` | `auth`, `role:admin` |
| `POST` | `/admin/system/webhooks` | `admin.system.webhooks.store` | `Admin\SystemHealthController@storeWebhook` | `auth`, `role:admin` |
| `POST` | `/admin/system/queues/{id}/retry` | `admin.system.queues.retry` | `Admin\SystemHealthController@retryFailedJob` | `auth`, `role:admin` |
| `POST` | `/api/v1/webhooks/incoming` | `api.webhooks.incoming` | `Api\WebhookController@handleIncoming` | API |
