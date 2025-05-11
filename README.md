# 🎟️ Event Booking System API (Laravel)

A RESTful API built with Laravel that allows users to manage events, register attendees, and book event seats with capacity and duplication constraints.

---

## 📌 Features

- ✅ CRUD operations for **Events** and **Attendees**
- ✅ **Event Booking** with overbooking and duplicate booking prevention
- ✅ Country-based event location management
- ✅ Public access for attendees to register and book
- ✅ Role-based protected routes for managing events
- ✅ Clean validation and structured API responses

---

## 🚀 API Endpoints

### 🎫 Events
| Method | Endpoint           | Description                | Auth Required |
|--------|--------------------|----------------------------|---------------|
| GET    | `/events`          | List all events            | ❌            |
| POST   | `/events`          | Create new event           | ✅            |
| GET    | `/events/{id}`     | Get event by ID            | ❌            |
| PUT    | `/events/{id}`     | Update event               | ✅            |
| DELETE | `/events/{id}`     | Delete event               | ✅            |

---

### 👤 Attendees
| Method | Endpoint              | Description                  | Auth Required |
|--------|-----------------------|------------------------------|---------------|
| GET    | `/attendees`          | List all attendees           | ✅            |
| POST   | `/attendees`          | Register new attendee        | ❌            |
| GET    | `/attendees/{id}`     | Get attendee by ID           | ✅            |
| PUT    | `/attendees/{id}`     | Update attendee              | ✅            |
| DELETE | `/attendees/{id}`     | Delete attendee              | ✅            |

---

### 📝 Bookings
| Method | Endpoint       | Description              | Auth Required |
|--------|----------------|--------------------------|---------------|
| GET    | `/bookings`    | List all bookings        | ✅            |
| POST   | `/bookings`    | Book an attendee to event| ❌            |

---

## 🔐 Authentication & Authorization

- **Laravel Sanctum** is suggested for API token authentication.
- **Public Access**:
  - `POST /attendees`, `POST /bookings`, `GET /events`, `GET /events/{id}`
- **Protected Routes**:
  - All event/attendee management and booking list operations require authentication.
- **Authorization**:
  - Laravel Policies used to enforce that event managers can only manage their events.

---

## 🛠️ Installation

```bash
git clone https://github.com/your-repo/event-booking-api.git
cd event-booking-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
