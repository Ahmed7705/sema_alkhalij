# Routes Documentation — Sema Al-Khalij Medical Services

This document lists all active and verified routes across the system.

## Public Marketing & Corporate Routes
- `GET /` — Home page (`home`)
- `GET /about` — About Us page (`about`)
- `GET /services` — Public Medical Services catalog (`services`)
- `GET /services/{slug}` — Service Detail page (`services.show`)
- `GET /products` — Medical Products Store (`products`)
- `GET /products/{slug}` — Product Detail page (`products.show`)
- `GET /corporate-services` — Public Corporate Services & Solutions (`corporate-services`)
- `POST /corporate-services` — Public Contract Request submission (`corporate-services.store`)
- `GET /blog` — Health Blog index (`blog`)
- `GET /contact` — Contact Us page (`contact`)

## Authentication Routes
- `GET /login` — Login page
- `POST /login` — Authenticate user
- `POST /logout` — Logout user
- `GET /register` — Registration page

## Customer / Patient Portal Routes [Protected: `auth`]
- `GET /profile` — Patient / User Dashboard & Profile (`profile`)
- `POST /profile/update` — Update Profile Details (`profile.update`)
- `POST /profile/password` — Change Password (`profile.password`)
- `GET /profile/bookings/{booking}` — Booking Detail & Workflow (`profile.booking-show`)
- `GET /profile/orders/{order}` — Order Detail & ZATCA Invoice (`profile.order-show`)
- `POST /addresses` — Store New Address (`addresses.store`)
- `PUT /addresses/{address}` — Update Address (`addresses.update`)
- `DELETE /addresses/{address}` — Delete Address (`addresses.destroy`)
- `POST /addresses/{address}/set-default` — Set Default Address (`addresses.set-default`)

## Staff Operations Portal Routes [Protected: `auth`, Role Check]
- `GET /staff/dashboard` — Staff Provider Dashboard (`staff.dashboard`)

## Corporate Portal Routes [Protected: `auth`, Company Policy Check]
- `GET /company/portal` — Company Contract Portal (`company.portal`)

## Admin Control Panel Routes [Protected: `auth`, Admin Middleware]
- `GET /admin` — Admin Dashboard Overview (`admin.dashboard`)
- `GET /admin/analytics` — Advanced Analytics & Charts (`admin.analytics.index`)
- `GET /admin/operations/search` — Blazma Composite Search (`admin.operations.search`)
- `GET /admin/bookings` — Medical Services & Visits Management (`admin.bookings.index`)
- `GET /admin/orders` — Store Orders & Invoicing (`admin.orders.index`)
- `GET /admin/products` — Product Catalog Management (`admin.products.index`)
- `GET /admin/services` — Medical Services Management (`admin.services.index`)
- `GET /admin/settings` — CMS & Site Settings (`admin.settings.index`)
- `GET /admin/users` — User & Role Management (`admin.users.index`)
- `GET /admin/audit-logs` — Security Audit Logs (`admin.audit.index`)

## Protected File Delivery Routes [Protected: `auth`, IDOR Check]
- `GET /medical-reports/{id}/download` — Authorized Medical PDF Download (`medical-reports.download`)
