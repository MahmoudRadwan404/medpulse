MedPulse API Documentation
A comprehensive RESTful API for managing medical conferences, articles, experts, and events. Built with Laravel and PostgreSQL.
📋 Table of Contents

Features
Prerequisites
Installation
API Endpoints
Authentication
Usage Examples
Database Schema
Contributing

✨ Features

User Management: Role-based access control with JWT authentication
Permission System: Granular permissions for all resources
Medical Content: Articles with categories, authors, and multilingual support
Event Management: Medical conferences and events with analysis
Expert Profiles: Comprehensive expert information with specialties and contacts
Media Handling: Images and videos for articles, events, and experts
Contact Forms: User inquiry management system
Frontend Settings: Configurable landing page modes

🔧 Prerequisites

PHP 8.2 or higher
PostgreSQL
Composer
Laravel 10.x

🚀 Installation

Clone the repository

bashgit clone <repository-url>
cd medpulse

Install dependencies

bashcomposer install

Environment setup

bashcp .env.example .env
php artisan key:generate

Configure database

envDB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=medpulse
DB_USERNAME=your_username
DB_PASSWORD=your_password

Run migrations

bashphp artisan migrate

Start the server

bashphp artisan serve
The API will be available at http://127.0.0.1:8000
🔐 Authentication
This API uses JWT (JSON Web Tokens) for authentication.
Login
httpPOST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
Response:
json{
  "access token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "expiresIn": "604800 s"
}
Using the token
Include the token in subsequent requests:
httpAuthorization: Bearer <your_token_here>
📡 API Endpoints
Users
MethodEndpointDescriptionAuth RequiredPOST/api/create-userCreate a new userYesGET/api/usersGet all usersYesGET/api/user/{id}Get specific userYesPOST/api/update-user/{id}Update userYesDELETE/api/user/{id}Delete userYesPOST/api/loginUser loginNoPOST/api/forgetPassword resetNo
Permissions
MethodEndpointDescriptionPOST/api/create-permissionCreate permissionGET/api/permissionsList all permissionsGET/api/permission/{id}Get specific permissionPOST/api/permission/{id}Update permissionDELETE/api/permission/{id}Delete permission
Roles
MethodEndpointDescriptionPOST/api/create-roleCreate roleGET/api/rolesList all rolesGET/api/role/{id}Get specific rolePOST/api/role/{id}Update roleDELETE/api/role/{id}Delete rolePOST/api/role/attach-permission/{id}Attach permissions to rolePOST/api/role/deattach-permission/{id}Detach permissions from role
Articles
MethodEndpointDescriptionAuth RequiredPOST/api/create-articleCreate articleYesGET/api/articlesList all articlesNoGET/api/article/{id}Get specific articleNoPOST/api/article/{id}Update articleYesDELETE/api/article/{id}Delete articleYes
Article Categories
MethodEndpointDescriptionPOST/api/create-categoryCreate categoryGET/api/article-categoriesList categoriesGET/api/article-category/{id}Get category
Events
MethodEndpointDescriptionPOST/api/eventCreate eventGET/api/eventsList all eventsGET/api/event/{id}Get specific eventPOST/api/event/{id}Update eventDELETE/api/event/{id}Delete event
Event Analysis
MethodEndpointDescriptionPOST/api/event-analysisCreate analysisPOST/api/event-analysis/update/{id}Update analysis
Experts
MethodEndpointDescriptionPOST/api/expertCreate expertGET/api/expertsList all expertsGET/api/expert/{id}Get specific expertPOST/api/expert/{id}Update expertDELETE/api/expert/{id}Delete expert
Authors
MethodEndpointDescriptionPOST/api/create-authorCreate authorGET/api/authorsList all authorsGET/api/author/{id}Get specific authorPOST/api/author/{id}Update authorDELETE/api/author/{id}Delete author
Media
MethodEndpointDescriptionPOST/api/imageUpload imagesDELETE/api/image/{id}Delete imagePOST/api/videoCreate video entry
Contact
MethodEndpointDescriptionPOST/api/contactCreate expert contactGET/api/contact/{id}Get contact details
Contact Forms
MethodEndpointDescriptionPOST/api/contact-formSubmit contact formGET/api/contact-formList all formsGET/api/contact-form/{id}Get specific formPOST/api/contact-form/{id}Update form statusDELETE/api/contact-form/{id}Delete form
Frontend Settings
MethodEndpointDescriptionPOST/api/create-front-modeSet display modeGET/api/get-front-data/{id}Get frontend settings
📝 Usage Examples
Create an Article
httpPOST /api/create-article
Authorization: Bearer <token>
Content-Type: application/json

{
  "category_id": 1,
  "title_en": "Advances in Heart Surgery",
  "title_ar": "تطورات في جراحة القلب",
  "description_en": "Recent innovations in cardiovascular surgery...",
  "description_ar": "الابتكارات الحديثة في جراحة القلب..."
}
Create an Event
httpPOST /api/event
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
  "description_en": "Annual gathering of cardiology experts...",
  "description_ar": "الاجتماع السنوي لخبراء أمراض القلب...",
  "subjects": ["Cardiology", "Interventional Procedures"]
}
Upload Images
httpPOST /api/image
Content-Type: multipart/form-data

images[0][file]: <file>
images[0][type]: profile
images[0][expert_id]: 1
images[1][file]: <file>
images[1][type]: content
images[1][expert_id]: 1
Submit Contact Form
httpPOST /api/contact-form
Content-Type: application/json

{
  "full_name": "John Smith",
  "organisation": "ABC Medical Center",
  "email": "john.smith@example.com",
  "number": "+12345678901",
  "asking_type": "General Inquiry",
  "details": "I would like to inquire about...",
  "status": "new"
}
🗄️ Database Schema
Key Tables

users: User accounts with role assignments
roles: User roles (owner, admin, editor, etc.)
permissions: Granular permission definitions
articles: Medical articles with multilingual support
article_categories: Article categorization
events: Medical conferences and events
event_analyses: Detailed event evaluations
experts: Medical expert profiles
authors: Article and content authors
images: Media storage for all entities
videos: Video content references
contacts: Expert contact information
contact_forms: User inquiry submissions

Relationships

Users → Roles (many-to-one)
Roles → Permissions (many-to-many)
Articles → Categories (many-to-one)
Articles → Authors (many-to-many)
Events → Event Analysis (one-to-one)
Experts → Contacts (one-to-many)
All entities → Images/Videos (polymorphic)

🔒 Permission System
The API includes 69 granular permissions across categories:

Permissions Management: create, list, show, update, delete
Roles Management: create, list, show, update, delete, attach/detach permissions
Users Management: create, login, update, show, delete, list, password reset
Article Categories: create, show, update, delete, list
Articles: create, list, show, delete, update, attach/detach authors
Authors: create, list, show, update, delete
Media: create images, delete images, create/update/delete/show videos
Events: create, list, show, delete, update, attach/detach authors
Event Analysis: create, update, delete
Experts: show, list, create, update, delete
Contacts: create, show, update
Contact Forms: create, list, show, update, delete
Settings: get-or-create, update, events-articles

🌐 Multilingual Support
The API supports bilingual content (English/Arabic) for:

Article titles and descriptions
Event details
Expert information
Author profiles
Category names
Contact information

All text fields have _en and _ar suffixes for language-specific content.
📦 Response Format
Success Response
json{
  "message": "Operation successful",
  "data": {
    // Response data
  }
}
Error Response
json{
  "message": "Error description",
  "errors": {
    // Validation errors if applicable
  }
}
Paginated Response
json{
  "data": {
    "current_page": 1,
    "data": [...],
    "first_page_url": "...",
    "last_page": 2,
    "per_page": 6,
    "total": 12
  }
}
🛠️ Development
Running Tests
bashphp artisan test
Database Seeding
bashphp artisan db:seed