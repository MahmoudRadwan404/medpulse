# MedPulse API Documentation

A comprehensive medical conference and content management system API built with Laravel.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Installation](#installation)
- [Authentication](#authentication)
- [API Endpoints](#api-endpoints)
- [Database Schema](#database-schema)
- [Usage Examples](#usage-examples)
- [Contributing](#contributing)
- [License](#license)

## 🔍 Overview

MedPulse is a robust API designed to manage medical conferences, articles, experts, events, and related content. It provides a complete solution for medical content management with role-based access control and comprehensive data management capabilities.

## ✨ Features

### Core Functionality
- **User Management** - Complete user authentication and authorization system
- **Role-Based Access Control** - Granular permissions system with customizable roles
- **Medical Content Management** - Articles, events, and expert profiles
- **Conference Management** - Event tracking, analysis, and speaker management
- **Media Handling** - Image and video upload capabilities
- **Contact Management** - Expert contacts and general inquiry forms
- **Multilingual Support** - Arabic and English content support

### Advanced Features
- JWT-based authentication
- Password reset functionality
- Event analysis and rating system
- Article categorization
- Expert specialization tracking
- Contact form management
- Frontend configuration system

## 🛠 Technology Stack

- **Framework**: Laravel (PHP 8.2.12)
- **Database**: PostgreSQL
- **Authentication**: JWT (JSON Web Tokens)
- **API Architecture**: RESTful

## 📦 Installation

### Prerequisites
- PHP >= 8.2.12
- PostgreSQL
- Composer

### Setup Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd medpulse
```

2. **Install dependencies**
```bash
composer install
```

3. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure Database**
Update your `.env` file with PostgreSQL credentials:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=medpulse
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Run Migrations**
```bash
php artisan migrate
```

6. **Seed Database (Optional)**
```bash
php artisan db:seed
```

7. **Start Development Server**
```bash
php artisan serve
```

The API will be available at `http://127.0.0.1:8000`

## 🔐 Authentication

### Login
```http
POST /api/login
Content-Type: application/x-www-form-urlencoded

email=user@example.com&password=yourpassword
```

**Response:**
```json
{
    "access token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "expiresIn": "604800 s"
}
```

### Using the Token
Include the JWT token in subsequent requests:
```http
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

## 📚 API Endpoints

### Authentication & Users

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/create-user` | Create new user | ✅ |
| POST | `/api/login` | User login | ❌ |
| GET | `/api/users` | List all users | ✅ |
| GET | `/api/user/{id}` | Get user details | ✅ |
| POST | `/api/update-user/{id}` | Update user | ✅ |
| DELETE | `/api/user/{id}` | Delete user | ✅ |
| POST | `/api/forget` | Request password reset | ❌ |

### Permissions

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/create-permission` | Create permission |
| GET | `/api/permissions` | List permissions |
| GET | `/api/permission/{id}` | Get permission |
| POST | `/api/permission/{id}` | Update permission |
| DELETE | `/api/permission/{id}` | Delete permission |

### Roles

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/create-role` | Create role |
| GET | `/api/roles` | List all roles |
| GET | `/api/role/{id}` | Get role details |
| POST | `/api/role/{id}` | Update role |
| DELETE | `/api/role/{id}` | Delete role |
| POST | `/api/role/attach-permission/{id}` | Attach permissions to role |
| POST | `/api/role/deattach-permission/{id}` | Detach permissions from role |

### Articles

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/create-article` | Create article |
| GET | `/api/articles` | List all articles |
| GET | `/api/article/{id}` | Get article details |
| POST | `/api/article/{id}` | Update article |
| DELETE | `/api/article/{id}` | Delete article |

### Article Categories

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/create-category` | Create category |
| GET | `/api/article-categories` | List categories |
| GET | `/api/article-category/{id}` | Get category |

### Events

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/event` | Create event |
| GET | `/api/events` | List all events (paginated) |
| GET | `/api/event/{id}` | Get event details |
| POST | `/api/event/{id}` | Update event |
| DELETE | `/api/event/{id}` | Delete event |

### Event Analysis

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/event-analysis` | Create event analysis |
| POST | `/api/event-analysis/update/{id}` | Update analysis |

### Experts

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/expert` | Create expert profile |
| GET | `/api/experts` | List all experts (paginated) |
| GET | `/api/expert/{id}` | Get expert details |
| POST | `/api/expert/{id}` | Update expert |
| DELETE | `/api/expert/{id}` | Delete expert |

### Authors

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/create-author` | Create author |
| GET | `/api/authors` | List all authors |
| GET | `/api/author/{id}` | Get author details |
| POST | `/api/author/{id}` | Update author |
| DELETE | `/api/author/{id}` | Delete author |

### Media Management

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/image` | Upload images |
| DELETE | `/api/image/{id}` | Delete image |
| POST | `/api/video` | Add video |

### Contact Management

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/contact` | Create expert contact |
| GET | `/api/contact/{id}` | Get contact details |
| POST | `/api/contact-form` | Submit contact form |
| GET | `/api/contact-form` | List contact forms (paginated) |
| GET | `/api/contact-form/{id}` | Get contact form |
| POST | `/api/contact-form/{id}` | Update contact form status |
| DELETE | `/api/contact-form/{id}` | Delete contact form |

### Frontend Settings

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/create-front-mode` | Create frontend mode setting |
| GET | `/api/get-front-data/{id}` | Get frontend settings |

## 📊 Database Schema

### Key Tables

#### Users
- `id`, `name`, `email`, `password`, `role_id`
- Relationships: belongs to Role

#### Roles
- `id`, `name`, `description`
- Relationships: has many Permissions (many-to-many)

#### Permissions
- `id`, `name`, `description`
- 69 predefined permissions covering all system operations

#### Articles
- `id`, `category_id`, `title_en`, `title_ar`, `description_en`, `description_ar`
- Relationships: belongs to Category, has many Authors

#### Events
- `id`, `title_en`, `title_ar`, `location`, `date_of_happening`, `stars`, `rate`, `organizer_en`, `organizer_ar`, `subjects`, `description_en`, `description_ar`
- Relationships: has one EventAnalysis, has many Images/Videos

#### Experts
- `id`, `name_en`, `name_ar`, `job_en`, `job_ar`, `medpulse_role_en`, `medpulse_role_ar`, `evaluated_specialties`, `number_of_events`, `years_of_experience`
- Relationships: has many Contacts, Images, Videos

#### Event Analysis
- `id`, `event_id`, `content_rate`, `organisation_rate`, `speaker_rate`, `sponsering_rate`, `scientific_impact_rate`, `total`
- Calculated total rating from component ratings

## 💡 Usage Examples

### Creating a User

```bash
curl -X POST http://127.0.0.1:8000/api/create-user \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "name=Ahmed" \
  -F "email=ahmed@example.com" \
  -F "password=securepassword" \
  -F "role_id=4"
```

### Creating an Article

```json
POST /api/create-article
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json

{
    "category_id": 1,
    "title_en": "Advances in Cardiology",
    "title_ar": "تطورات في طب القلب",
    "description_en": "Latest developments in cardiac care...",
    "description_ar": "أحدث التطورات في رعاية القلب..."
}
```

### Creating an Event

```json
POST /api/event
Content-Type: application/json

{
    "title_en": "International Cardiology Conference 2024",
    "title_ar": "المؤتمر الدولي لأمراض القلب ٢٠٢٤",
    "location": "Dubai, UAE",
    "date_of_happening": "2024-05-15",
    "stars": 5,
    "rate": 9.5,
    "organizer_en": "World Heart Federation",
    "organizer_ar": "الاتحاد العالمي للقلب",
    "subjects": ["Cardiology", "Heart Failure"],
    "description_en": "Annual gathering of cardiology experts...",
    "description_ar": "الاجتماع السنوي لخبراء أمراض القلب..."
}
```

### Uploading Images

```bash
curl -X POST http://127.0.0.1:8000/api/image \
  -F "images[0][file]=@/path/to/image1.jpg" \
  -F "images[0][type]=profile" \
  -F "images[0][expert_id]=1" \
  -F "images[1][file]=@/path/to/image2.jpg" \
  -F "images[1][type]=content" \
  -F "images[1][expert_id]=1"
```

### Role Permissions

**Owner Role** (Full System Access):
- All 69 permissions including:
  - Permission management (create, read, update, delete)
  - Role management