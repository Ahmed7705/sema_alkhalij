            # Routes Summary — Sema Al-Khalij Medical Services

            ## Admin Staff Management Routes (Prefix: `/admin`, Middleware: `auth`, `admin`):
            - `GET /admin/staff` (`admin.staff.index`) — Medical Staff directory table with search & filters
            - `GET /admin/staff/create` (`admin.staff.create`) — Add new staff member form
            - `POST /admin/staff` (`admin.staff.store`) — Save new staff member and staff profile
            - `GET /admin/staff/{id}` (`admin.staff.show`) — Staff profile details and assigned visits history
            - `GET /admin/staff/{id}/edit` (`admin.staff.edit`) — Edit staff profile form
            - `PUT /admin/staff/{id}` (`admin.staff.update`) — Update staff profile and user credentials
            - `POST /admin/staff/{id}/toggle` (`admin.staff.toggle`) — Toggle active/inactive status without deleting user

            ## Admin Bookings & Visit Assignment Routes (Prefix: `/admin`, Middleware: `auth`, `admin`):
            - `GET /admin/bookings` (`admin.bookings.index`) — Bookings register with search & filters
            - `GET /admin/bookings/{id}` (`admin.bookings.show`) — Standalone visit details, assignment form, timeline
            - `POST /admin/bookings/{id}/assign` (`admin.bookings.assign`) — Assign/reassign visit to active qualified staff
            - `POST /admin/bookings/{id}/verify` (`admin.bookings.verify`) — Supervisor verify completed visit (`completed` → `verified`)
            - `POST /admin/bookings/{id}/status` (`admin.bookings.status`) — Workflow status update with state machine validation

            ## Staff Operations Portal Routes (Prefix: `/staff`, Middleware: `auth`):
            - `GET /staff/dashboard` (`staff.dashboard`) — Staff portal viewing exclusively assigned visits
            - `POST /staff/visits/{booking}/status` (`staff.visits.update-status`) — Update assigned visit status (`assigned` → `accepted` → `in_progress` → `completed`)
