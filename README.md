# Volunteer Event Management API

RESTful API untuk sistem manajemen event volunteer yang memungkinkan pengguna untuk mendaftar, login, membuat event, melihat daftar event, dan bergabung dengan event.

## 📋 Daftar Isi

- [Fitur](#-fitur)
- [Teknologi](#-teknologi)
- [Cara Install](#-cara-install)
- [Cara Menjalankan Project](#-cara-menjalankan-project)
- [Daftar Endpoint API](#-daftar-endpoint-api)
- [Catatan Asumsi & Desain](#-catatan-asumsi--desain)
- [Jawaban Pertanyaan Wajib](#-jawaban-pertanyaan-wajib)

## ✨ Fitur

### Fitur Utama
- ✅ **Authentication** - Register, Login, Logout dengan Laravel Sanctum
- ✅ **Event Management** - Create, Read events
- ✅ **Event Participation** - User dapat join event
- ✅ **User Profile** - Get authenticated user info

### Bonus Features (Telah Diimplementasikan)
- ✅ **API Resources** - Clean data transformation dengan EventResource dan UserResource
- ✅ **Pagination** - Daftar event support pagination
- ✅ **Seeder** - Database seeding untuk testing (21 users, 15 events dengan participants)
- ✅ **Policy/Authorization** - EventPolicy untuk mengatur akses
- ✅ **Consistent Error Response** - Format error response yang konsisten di seluruh API

## 🛠 Teknologi

- **Laravel 11** - PHP Framework
- **MySQL 8.0** - Database
- **Laravel Sanctum** - API Authentication
- **Docker & Docker Compose** - Containerization
- **Nginx** - Web Server
- **PHP 8.3** - Programming Language

## 📥 Cara Install

### Prasyarat
- Docker & Docker Compose terinstall
- Git terinstall

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone <repository-url>
cd volunteer-event-management
```

2. **Copy Environment File**
```bash
cp .env.example .env
```

3. **Build dan Start Docker Containers**
```bash
docker-compose up -d --build
```

4. **Install Dependencies**
```bash
docker-compose exec app composer install
```

5. **Generate Application Key**
```bash
docker-compose exec app php artisan key:generate
```

6. **Run Migrations**
```bash
docker-compose exec app php artisan migrate
```

7. **Run Seeders (Optional - untuk data testing)**
```bash
docker-compose exec app php artisan db:seed
```

## 🚀 Cara Menjalankan Project

### Start Application
```bash
docker-compose up -d
```

### Stop Application
```bash
docker-compose down
```

### View Logs
```bash
docker-compose logs -f app
```

### Access Application
- **API Base URL**: `http://localhost:8000`
- **API Documentation**: `http://localhost:8000/api-docs`

### Testing dengan Provided Account
Setelah running seeder, gunakan credentials berikut:
- Email: `test@example.com`
- Password: `password`

## 📚 Daftar Endpoint API

### Authentication Endpoints

#### 1. Register
**POST** `/api/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Success Response (201):**
```json
{
  "success": true,
  "message": "Registrasi berhasil",
  "data": {
    "token": "1|abc123...",
    "user": {
      "id": "uuid",
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2026-02-17T10:00:00.000000Z",
      "updated_at": "2026-02-17T10:00:00.000000Z"
    }
  }
}
```

#### 2. Login
**POST** `/api/login`

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "token": "2|xyz789...",
    "user": {
      "id": "uuid",
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2026-02-17T10:00:00.000000Z",
      "updated_at": "2026-02-17T10:00:00.000000Z"
    }
  }
}
```

#### 3. Get Current User
**GET** `/api/me`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Profil pengguna berhasil diambil",
  "data": {
    "id": "uuid",
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2026-02-17T10:00:00.000000Z",
    "updated_at": "2026-02-17T10:00:00.000000Z"
  }
}
```

#### 4. Logout
**POST** `/api/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Logout berhasil"
}
```

### Event Endpoints

#### 5. Get All Events (with Pagination)
**GET** `/api/events?per_page=10&page=1`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `per_page` (optional, default: 10) - Jumlah item per halaman
- `page` (optional, default: 1) - Nomor halaman

**Success Response (200):**
```json
{
  "success": true,
  "message": "Events retrieved successfully",
  "data": {
    "data": [
      {
        "id": "uuid",
        "title": "Beach Cleanup Event",
        "description": "Join us for a community beach cleanup...",
        "event_date": "2026-03-15T14:00:00.000000Z",
        "participants_count": 5,
        "participants": [
          {
            "id": "uuid",
            "name": "User 1",
            "email": "user1@example.com",
            "created_at": "2026-02-17T10:00:00.000000Z",
            "updated_at": "2026-02-17T10:00:00.000000Z"
          }
        ],
        "created_at": "2026-02-17T10:00:00.000000Z",
        "updated_at": "2026-02-17T10:00:00.000000Z"
      }
    ],
    "links": {
      "first": "http://localhost:8000/api/events?page=1",
      "last": "http://localhost:8000/api/events?page=2",
      "prev": null,
      "next": "http://localhost:8000/api/events?page=2"
    },
    "meta": {
      "current_page": 1,
      "from": 1,
      "last_page": 2,
      "per_page": 10,
      "to": 10,
      "total": 15
    }
  }
}
```

#### 6. Create Event
**POST** `/api/events`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "title": "Community Garden Planting",
  "description": "Help us plant trees and flowers in the community garden",
  "event_date": "2026-04-20T09:00:00"
}
```

**Success Response (201):**
```json
{
  "success": true,
  "message": "Event created successfully",
  "data": {
    "id": "uuid",
    "title": "Community Garden Planting",
    "description": "Help us plant trees and flowers in the community garden",
    "event_date": "2026-04-20T09:00:00.000000Z",
    "created_at": "2026-02-17T10:00:00.000000Z",
    "updated_at": "2026-02-17T10:00:00.000000Z"
  }
}
```

#### 7. Get Event Detail
**GET** `/api/events/{eventId}`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Event retrieved successfully",
  "data": {
    "id": "uuid",
    "title": "Beach Cleanup Event",
    "description": "Join us for a community beach cleanup...",
    "event_date": "2026-03-15T14:00:00.000000Z",
    "participants_count": 5,
    "participants": [
      {
        "id": "uuid",
        "name": "User 1",
        "email": "user1@example.com",
        "created_at": "2026-02-17T10:00:00.000000Z",
        "updated_at": "2026-02-17T10:00:00.000000Z"
      }
    ],
    "created_at": "2026-02-17T10:00:00.000000Z",
    "updated_at": "2026-02-17T10:00:00.000000Z"
  }
}
```

#### 8. Join Event
**POST** `/api/events/{eventId}/join`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Successfully joined the event",
  "data": null
}
```

**Error Response (403) - Already Joined:**
```json
{
  "success": false,
  "message": "You have already joined this event",
  "error": "..."
}
```

### Error Responses

#### Validation Error (422)
```json
{
  "success": false,
  "message": "Validasi gagal dengan 2 kesalahan.",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password field is required."]
  }
}
```

#### Unauthorized (401)
```json
{
  "success": false,
  "message": "Tidak terautentikasi. Silakan login terlebih dahulu.",
  "error": "..."
}
```

#### Not Found (404)
```json
{
  "success": false,
  "message": "Data tidak ditemukan.",
  "error": "Resource not found"
}
```

#### Rate Limit (429)
```json
{
  "success": false,
  "message": "Terlalu banyak percobaan. Silakan coba lagi nanti."
}
```

#### Server Error (500)
```json
{
  "success": false,
  "message": "Failed to retrieve events",
  "error": {
    "error": "..."
  }
}
```

## 📝 Catatan Asumsi & Desain

### Asumsi Sistem

1. **User Management**
   - Satu user hanya bisa memiliki satu akun per email (unique email)
   - Semua user yang terdaftar dapat membuat event
   - Semua user yang terdaftar dapat join event yang sudah ada

2. **Event Management**
   - Event bersifat publik (semua authenticated user dapat melihat)
   - Satu user dapat join multiple events
   - Satu event dapat memiliki multiple participants
   - User tidak dapat join event yang sama lebih dari sekali
   - Tidak ada batasan jumlah peserta dalam satu event
   - Event date harus dalam format datetime yang valid

3. **Authorization**
   - Menggunakan Laravel Sanctum untuk token-based authentication
   - Token tidak memiliki expiration (bisa ditambahkan sesuai kebutuhan)
   - User harus authenticated untuk mengakses semua endpoint kecuali register dan login

### Desain Teknis

#### 1. Database Schema
- **users table**: id (UUID), name, email, password, timestamps
- **events table**: id (UUID), title, description, event_date, timestamps
- **event_user pivot table**: event_id, user_id, timestamps (many-to-many relationship)

#### 2. API Response Format
Menggunakan format konsisten untuk semua response:
```json
{
  "success": boolean,
  "message": string,
  "data": object|array|null,
  "error": object|string|null (hanya untuk error)
}
```

#### 3. API Resources
- **UserResource**: Transformasi data user (menghilangkan password, remember_token)
- **EventResource**: Transformasi data event dengan participants count dan list

#### 4. Error Handling
Centralized error handling di `bootstrap/app.php`:
- ValidationException (422)
- AuthenticationException (401)
- ModelNotFoundException (404)
- NotFoundHttpException (404)
- AccessDeniedException (403)
- ThrottleRequestsException (429)

#### 5. Authorization dengan Policy
- EventPolicy mengatur siapa yang boleh membuat event, melihat event, dan join event
- Menggunakan Laravel's built-in authorization gates

#### 6. Code Organization
```
app/
├── Http/
│   ├── Controllers/        # Request handlers
│   ├── Resources/          # API response transformers
│   └── Requests/           # Form validation
├── Models/                 # Eloquent models
└── Policies/              # Authorization logic
```

## 🧠 Jawaban Pertanyaan Wajib

### 1. Bagian tersulit apa dari assignment ini?

Bagian tersulit adalah **merancang struktur response yang konsisten dan error handling yang comprehensive**. 

Alasan:
- Harus memastikan semua endpoint mengembalikan format response yang sama
- Perlu menangani berbagai jenis exception (validation, authentication, authorization, not found, dll)
- Laravel 11 memiliki struktur exception handling yang berbeda dari versi sebelumnya (tidak ada `app/Exceptions/Handler.php`), sehingga perlu menyesuaikan dengan struktur baru di `bootstrap/app.php`
- Memastikan error messages tetap informatif dan user-friendly dalam bahasa Indonesia

### 2. Jika diberi waktu 1 minggu, apa yang akan kamu perbaiki?

Jika diberi waktu 1 minggu, saya akan menambahkan:

1. **Testing**
   - Unit tests untuk Models dan Policies
   - Feature tests untuk semua API endpoints
   - Integration tests untuk flow lengkap (register → login → create event → join event)
   - Code coverage minimal 80%

2. **Advanced Features**
   - Event categories/tags untuk filtering
   - Event search functionality (by name, date range, location)
   - Event capacity limit dan waitlist
   - Event creator dapat update/delete event mereka sendiri
   - Participant management (unjoin event, kick participant jika creator)
   - Event status (draft, published, cancelled, completed)
   - Email notifications saat user join event atau event updated
   - Upload event images/cover photo

3. **Security & Performance**
   - Rate limiting yang lebih spesifik per endpoint
   - Token expiration dengan refresh token mechanism
   - API versioning (v1, v2, dll)
   - Database query optimization (eager loading, indexes)
   - Caching untuk frequently accessed data
   - Request logging dan monitoring
   - CORS configuration yang lebih strict

4. **Documentation**
   - Interactive API documentation dengan Swagger/OpenAPI (sudah ada struktur tapi perlu dilengkapi)
   - Postman collection
   - Architecture diagram
   - Database ERD
   - Deployment guide (untuk production)

5. **DevOps**
   - CI/CD pipeline dengan GitHub Actions
   - Automated testing di pipeline
   - Environment-specific configuration (dev, staging, production)
   - Database backup strategy
   - Logging dan monitoring tools (Sentry, LogRocket)

### 3. Kenapa memilih pendekatan teknis tersebut?

**1. Laravel 11 sebagai Framework**
- **Alasan**: Framework modern dengan ecosystem yang matang, built-in features untuk authentication (Sanctum), ORM (Eloquent), migrations, dan validation
- **Benefit**: Development speed tinggi, code readable, maintainable, dan mengikuti best practices

**2. API Resources untuk Response Transformation**
- **Alasan**: Memisahkan business logic dari presentation logic
- **Benefit**: 
  - Data transformation yang konsisten
  - Mudah menambah/mengurangi field yang di-return tanpa mengubah model
  - Reusable (UserResource bisa dipakai di AuthController dan EventResource)
  - Conditional field rendering (participants hanya tampil jika loaded)

**3. Policy untuk Authorization**
- **Alasan**: Centralized authorization logic yang reusable
- **Benefit**:
  - Clear separation of concerns
  - Mudah di-maintain dan di-test
  - Auto-discovery di Laravel 11 (tidak perlu manual register)
  - Bisa dipanggil di controller dengan `$this->authorize()`

**4. Centralized Error Handling**
- **Alasan**: Consistency dan DRY principle
- **Benefit**:
  - Satu tempat untuk handle semua jenis error
  - Response format yang konsisten di seluruh aplikasi
  - Mudah menambah custom exception handling
  - User-friendly error messages

**5. UUID sebagai Primary Key**
- **Alasan**: Security dan compatibility dengan distributed systems
- **Benefit**:
  - Tidak expose jumlah data (auto-increment bisa ditebak)
  - URL-safe dan globally unique
  - Baik untuk future scalability (sharding, replication)

**6. Docker untuk Development Environment**
- **Alasan**: Environment consistency dan easy setup
- **Benefit**:
  - "Works on my machine" problem solved
  - Mudah onboarding untuk developer baru
  - Production-like environment di development
  - Isolated dependencies

**7. Sanctum untuk Authentication**
- **Alasan**: Lightweight, Laravel native, cocok untuk SPA dan mobile apps
- **Benefit**:
  - Simple token-based auth
  - Built-in CSRF protection
  - Tidak perlu JWT complexity untuk use case ini
  - Well integrated dengan Laravel ecosystem

**8. Pagination**
- **Alasan**: Performance dan UX
- **Benefit**:
  - Prevent loading too much data at once
  - Better performance untuk large datasets
  - Standard REST API practice
  - Configurable per-page limit

**Note**: Pastikan Docker dan Docker Compose sudah terinstall sebelum menjalankan aplikasi ini.
