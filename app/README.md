# FeedTrack (rebuilt)

A clean PHP 8 + MySQL rebuild of the feed inventory / production / orders system.

## Features
- Session auth with bcrypt, CSRF protection on every form, role-based access (`admin` / `staff`)
- Dashboard with live stats + Chart.js graphs
- Inventory CRUD with low-stock alerts and suppliers
- Orders (deducts finished-product stock; deliver / cancel-restock / delete)
- Production batches (scales a recipe, consumes ingredients, adds finished stock — all transactional)
- Suppliers, Users (admin only), Reports, and an Activity log

## Setup (XAMPP)
1. Start **Apache** and **MySQL** in the XAMPP control panel.
2. Import the schema: open **phpMyAdmin → Import** and choose `app/schema.sql`
   (or run `mysql -u root < app/schema.sql`). This creates the `feedtrack` database with sample data.
3. Put this project under your web root (e.g. `C:\xampp\htdocs\FEEDT`) or point a vhost at it.
4. Visit `http://localhost/FEEDT/app/` (adjust the path to where you placed it).

If your MySQL uses a password or a non-default host/port, edit `app/config.php`
(or set the `DB_HOST` / `DB_PORT` / `DB_USER` / `DB_PASS` / `DB_NAME` environment variables).

## Demo logins
| Role | Username | Password |
|------|----------|----------|
| Administrator (all modules) | `admin1` | `123` |
| Staff (all except Users) | `admin2` | `123` |

> Remove the demo-credentials panel on the login page before any real deployment.

## Notes
- The old app (root `index.php`, `frontend/`, `backend/`, `fims` database) is untouched.
  This rebuild lives entirely under `app/` and uses its own `feedtrack` database.
