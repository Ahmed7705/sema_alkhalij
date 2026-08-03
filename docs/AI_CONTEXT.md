# AI Context & Project Rules

## Tech Stack & Architecture
- **Language:** PHP 8.0+
- **Framework:** Laravel 9.x
- **Database:** MySQL
- **Templating:** Blade Layouts & Components
- **Server Interactivity:** Livewire 2.x
- **Client Interactivity:** Alpine.js 3.x
- **Styling:** Tailwind CSS 3.x
- **Charts:** Chart.js

## Hosting & Environment Constraints
- Free hosting / ProFreeHost (No SSH, No Redis, No S3)
- Max PHP version: 8.0 - 8.2
- File Uploads: Local Storage (`storage/app/public` WebP compressed)
- Cache & Sessions: `database` or `file` drivers
- Queues: `database` queue driver executed via web cron endpoint
- Notifications Email: External Mail API (Brevo / Mailgun)

## Design System Tokens
- **Primary Color:** `#0F4C3A` (Dark Medical Green)
- **Accent Color:** `#3CA96B` (Medium/Light Green)
- **Background Light:** `#FFFFFF` & `#F6F9F7`
- **Text Primary:** `#1B241F`
- **Direction:** RTL (Arabic Default) with LTR preparation
- **Icons:** Lucide Icons / Heroicons (STRICTLY NO EMOJIS)
- **Logo Location:** `public/images/logo.png`
