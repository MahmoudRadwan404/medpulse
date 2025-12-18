```markdown
# MedPulse API Documentation

## Overview

MedPulse API is a comprehensive backend system for medical information management with RBAC (Role-Based Access Control), multi-language support (English/Arabic), and full CRUD operations across multiple domains including users, permissions, articles, events, experts, and media management.

**Base URL:** `http://127.0.0.1:8000/api/`

---

## Table of Contents

-   [Permissions Management](#permissions-management)
-   [Roles Management](#roles-management)
-   [Users Management](#users-management)
-   [Article Categories Management](#article-categories-management)
-   [Images Management](#images-management)
-   [Videos Management](#videos-management)
-   [Experts Management](#experts-management)
-   [Events Management](#events-management)
-   [Event Analysis Management](#event-analysis-management)
-   [Articles Management](#articles-management)
-   [Authors Management](#authors-management)

---

## Authentication

Most endpoints require Bearer Token authentication. Obtain a token via the login endpoint.

**Authorization Header:**
```

Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...

````

---

## Permissions Management

### Create Permission
- **Method:** `POST`
- **URL:** `/create-permission`
- **Description:** Create a new permission for RBAC system
- **Input:**
  - `name` (string, required): Permission name (e.g., "permissions.create")
  - `description` (string, required): Detailed description of permission
- **Request Example:**
  ```json
  {
    "name": "creating_permission_2_3_4_5",
    "description": "testing the creating route"
  }
````

-   **Response Example (201 Created):**
    ```json
    {
        "message": "Permission created successfully",
        "data": {
            "name": "creating_permission_2_3_4_5",
            "description": "testing the creating route",
            "updated_at": "2025-12-08T10:15:43.000000Z",
            "created_at": "2025-12-08T10:15:43.000000Z",
            "id": 1
        }
    }
    ```

### Get All Permissions

-   **Method:** `GET`
-   **URL:** `/permissions`
-   **Description:** Retrieve list of all permissions
-   **Response Example (200 OK):**
    ```json
    {
        "data": [
            {
                "id": 1,
                "name": "permissions.create",
                "description": "Create new permission",
                "created_at": null,
                "updated_at": null
            },
            {
                "id": 2,
                "name": "permissions.list",
                "description": "View all permissions",
                "created_at": null,
                "updated_at": null
            }
            // ... more permissions
        ]
    }
    ```

### Get Single Permission

-   **Method:** `GET`
-   **URL:** `/permission/{id}`
-   **Description:** Retrieve details of a specific permission
-   **Parameters:**
    -   `id` (integer, required): Permission ID
-   **Response Example (200 OK):**
    ```json
    {
        "id": 1,
        "name": "permissions.create",
        "description": "Create new permission",
        "created_at": null,
        "updated_at": null
    }
    ```

### Update Permission

-   **Method:** `POST`
-   **URL:** `/permission/{id}`
-   **Description:** Update permission details
-   **Parameters:**
    -   `id` (integer, required): Permission ID
-   **Input:**
    -   `name` (string, optional): New permission name
    -   `description` (string, optional): New description
-   **Request Example:**
    ```json
    {
        "name": "updating_permission",
        "description": "updated description"
    }
    ```

### Delete Permission

-   **Method:** `DELETE`
-   **URL:** `/permission/{id}`
-   **Description:** Delete a permission
-   **Parameters:**
    -   `id` (integer, required): Permission ID
-   **Response Example (200 OK):**
    ```json
    {
        "message": "Permission deleted successfully"
    }
    ```

---

## Roles Management

### Create Role

-   **Method:** `POST`
-   **URL:** `/create-role`
-   **Description:** Create a new role with optional permissions
-   **Input:**
    -   `name` (string, required): Role name
    -   `description` (string, required): Role description
    -   `permissions` (array, optional): Array of permission IDs
-   **Request Example:**
    ```json
    {
        "name": "owner",
        "description": "All permissions - Full system access with complete control over all features and settings"
    }
    ```
-   **Response Example (201 Created):**
    ```json
    {
        "message": "Role created successfully",
        "data": {
            "id": 4,
            "name": "owner",
            "description": "All permissions - Full system access with complete control over all features and settings",
            "created_at": "2025-12-08T15:00:02.000000Z",
            "updated_at": "2025-12-08T15:00:02.000000Z",
            "permissions": [
                {
                    "id": 1,
                    "name": "permissions.create",
                    "description": "Create new permission",
                    "created_at": null,
                    "updated_at": null
                }
                // ... 68 more permissions
            ]
        }
    }
    ```

### Get All Roles

-   **Method:** `GET`
-   **URL:** `/roles`
-   **Description:** Retrieve list of all roles with their permissions
-   **Response Example (200 OK):** Returns array of role objects with permissions array

### Get Single Role

-   **Method:** `GET`
-   **URL:** `/role/{id}`
-   **Description:** Get detailed information about a specific role including all permissions
-   **Parameters:**
    -   `id` (integer, required): Role ID
-   **Response Example (200 OK):** Returns role object with complete permissions list

### Update Role

-   **Method:** `POST`
-   **URL:** `/role/{id}`
-   **Description:** Update role information and permissions
-   **Parameters:**
    -   `id` (integer, required): Role ID
-   **Input:**
    -   `name` (string, optional): New role name
    -   `description` (string, optional): New description
    -   `permissions[]` (array, optional): Array of permission IDs to attach
-   **Request Example (Form Data):**
    ```
    name: small_master_update
    description: testing the creating route
    permissions[]: 5
    ```

### Attach Permissions to Role

-   **Method:** `POST`
-   **URL:** `/role/attach-permission/{id}`
-   **Description:** Attach multiple permissions to a role
-   **Parameters:**
    -   `id` (integer, required): Role ID
-   **Input:**
    -   `permissions` (array, required): Array of permission IDs
-   **Request Example:**
    ```json
    {
        "permissions": [
            1, 2, 3, 4, 5, 6, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36,
            37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53,
            54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69
        ]
    }
    ```
-   **Response Example (200 OK):** Returns role object with updated permissions including pivot data

### Detach Permissions from Role

-   **Method:** `POST`
-   **URL:** `/role/deattach-permission/{id}`
-   **Description:** Remove permissions from a role
-   **Parameters:**
    -   `id` (integer, required): Role ID
-   **Input (Form Data):**
    -   `permissions[]` (array, required): Permission IDs to detach

### Delete Role

-   **Method:** `DELETE`
-   **URL:** `/role/{id}`
-   **Description:** Delete a role
-   **Parameters:**
    -   `id` (integer, required): Role ID
-   **Response Example (200 OK):**
    ```json
    {
        "message": "Role deleted successfully"
    }
    ```

---

## Users Management

### Create User

-   **Method:** `POST`
-   **URL:** `/create-user`
-   **Description:** Register a new user with role assignment
-   **Input (Form Data):**
    -   `name` (string, required): User's full name
    -   `email` (string, required): User's email address
    -   `password` (string, required): User's password
    -   `role_id` (integer, required): Role ID to assign
-   **Request Example:**
    ```
    name: Ahmed
    email: ahmed_program@gmail.com
    password: 123123123
    role_id: 4
    ```
-   **Response Example (201 Created):**
    ```json
    {
        "name": "sameh",
        "email": "sameh@gmail.com",
        "role_id": "3",
        "updated_at": "2025-12-06T18:42:29.000000Z",
        "created_at": "2025-12-06T18:42:29.000000Z",
        "id": 35
    }
    ```

### Get User

-   **Method:** `GET`
-   **URL:** `/user/{id}`
-   **Description:** Retrieve user details including role information
-   **Parameters:**
    -   `id` (integer, required): User ID
-   **Response Example (200 OK):**
    ```json
    [
        {
            "id": 2,
            "name": "ahmed",
            "email": "ahmed@gmail.com",
            "role_id": 3,
            "created_at": "2025-12-06T17:46:09.000000Z",
            "updated_at": "2025-12-06T17:46:09.000000Z",
            "role": {
                "id": 3,
                "name": "small_mster_update",
                "description": "have some credentials",
                "created_at": "2025-12-06T14:41:21.000000Z",
                "updated_at": "2025-12-06T14:57:24.000000Z"
            }
        }
    ]
    ```

### Get All Users

-   **Method:** `GET`
-   **URL:** `/users`
-   **Description:** Retrieve list of all users with their roles
-   **Response Example (200 OK):** Returns array of user objects with role details

### User Login

-   **Method:** `POST`
-   **URL:** `/login`
-   **Description:** Authenticate user and return JWT token
-   **Input (Form Data):**
    -   `email` (string, required): User's email
    -   `password` (string, required): User's password
-   **Request Example:**
    ```
    email: medpulseuae@gmail.com
    password: 456456456
    ```
-   **Response Example (200 OK):**
    ```json
    {
        "access token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzY1MDQ2NDcxLCJleHAiOjE3NjU2NTEyNzEsIm5iZiI6MTc2NTA0NjQ3MSwianRpIjoieHB6d1k3aWJVS01EelZNWiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.olHiptf8QD5tejKSPbFgzLPuKMPI4FI42FX08OepXtM",
        "expiresIn": "604800 s"
    }
    ```

### Update User

-   **Method:** `POST`
-   **URL:** `/update-user/{id}`
-   **Description:** Update user information
-   **Parameters:**
    -   `id` (integer, required): User ID
-   **Input (Form Data):**
    -   `name` (string, optional): New name
    -   `email` (string, optional): New email
    -   `password` (string, optional): New password
    -   `role_id` (integer, optional): New role ID
-   **Response Example (200 OK):**
    ```json
    {
        "message": "User updated successfully",
        "user": {
            "id": 1,
            "name": "Medpulse",
            "email": "medpulseuae@gmail.com",
            "role_id": "3",
            "created_at": "2025-12-06T17:42:56.000000Z",
            "updated_at": "2025-12-06T18:40:09.000000Z"
        }
    }
    ```

### Delete User

-   **Method:** `DELETE`
-   **URL:** `/user/{id}`
-   **Description:** Delete a user account
-   **Parameters:**
    -   `id` (integer, required): User ID
-   **Response Example (200 OK):**
    ```json
    [
        {
            "id": 35,
            "name": "sameh",
            "email": "sameh@gmail.com",
            "role_id": 3,
            "created_at": "2025-12-06T18:42:29.000000Z",
            "updated_at": "2025-12-06T18:42:29.000000Z"
        }
    ]
    ```

### Forgot Password

-   **Method:** `POST`
-   **URL:** `/forget`
-   **Description:** Request password reset link
-   **Input (Form Data):**
    -   `email` (string, required): User's email address

---

## Article Categories Management

### Create Category

-   **Method:** `POST`
-   **URL:** `/create-category`
-   **Description:** Create a new article category with bilingual support
-   **Input:**
    -   `name_en` (string, required): Category name in English
    -   `name_ar` (string, required): Category name in Arabic
-   **Request Example:**
    ```json
    {
        "name_en": "Cardiology",
        "name_ar": "طب القلب"
    }
    ```
-   **Response Example (201 Created):**
    ```json
    {
        "message": "Category created successfully",
        "data": {
            "name_en": "Cardiology",
            "name_ar": "طب القلب",
            "updated_at": "2025-12-08T10:15:43.000000Z",
            "created_at": "2025-12-08T10:15:43.000000Z",
            "id": 1
        }
    }
    ```

### Get Category

-   **Method:** `GET`
-   **URL:** `/article-category/{id}`
-   **Description:** Retrieve specific category details
-   **Parameters:**
    -   `id` (integer, required): Category ID
-   **Response Example (200 OK):**
    ```json
    {
        "data": {
            "id": 1,
            "name_en": "Cardiology",
            "name_ar": "طب القلب",
            "created_at": "2025-12-08T10:15:43.000000Z",
            "updated_at": "2025-12-08T10:15:43.000000Z"
        }
    }
    ```

### Get All Categories

-   **Method:** `GET`
-   **URL:** `/article-categories`
-   **Description:** Retrieve list of all article categories
-   **Response Example (200 OK):**
    ```json
    {
        "data": [
            {
                "id": 1,
                "name_en": "Cardiology",
                "name_ar": "طب القلب",
                "created_at": "2025-12-08T10:15:43.000000Z",
                "updated_at": "2025-12-08T10:15:43.000000Z"
            },
            {
                "id": 2,
                "name_en": "Neurology",
                "name_ar": "طب الأعصاب",
                "created_at": "2025-12-08T10:16:04.000000Z",
                "updated_at": "2025-12-08T10:16:04.000000Z"
            },
            {
                "id": 3,
                "name_en": "Surgery",
                "name_ar": "الجراحة",
                "created_at": "2025-12-08T10:16:12.000000Z",
                "updated_at": "2025-12-08T10:16:12.000000Z"
            }
        ]
    }
    ```

---

## Images Management

### Upload Images

-   **Method:** `POST`
-   **URL:** `/image`
-   **Description:** Upload multiple images with metadata
-   **Input (Form Data):**
    -   `images[0][file]` (file, required): Image file
    -   `images[0][type]` (string, required): Image type - "profile" or "content"
    -   `images[0][expert_id]` (integer, optional): Associated expert ID
    -   `images[1][file]` (file, optional): Additional images
    -   `images[1][type]` (string, optional): Type for additional images
-   **Request Example:**
    ```
    images[0][file]: [file selection]
    images[0][type]: profile
    images[0][expert_id]: 1
    images[1][file]: [file selection]
    images[1][type]: content
    images[1][expert_id]: 1
    ```
-   **Response Example (201 Created):**
    ```json
    {
        "success": true,
        "message": "Images uploaded successfully",
        "data": [
            {
                "id": 1,
                "url": "http://127.0.0.1:8000/storage/newPhoto/vW2D01WtHifIzzcLVDgIlPSvOYAD5YrXbNmKzLk7.jpg",
                "type": "profile"
            },
            {
                "id": 2,
                "url": "http://127.0.0.1:8000/storage/newPhoto/nw9QoBlctWWRIiO6bKg53NIxCFh34xsEgKHrjBCE.jpg",
                "type": "content"
            }
        ]
    }
    ```

### Delete Image

-   **Method:** `DELETE`
-   **URL:** `/image/{id}`
-   **Description:** Delete an uploaded image
-   **Parameters:**
    -   `id` (integer, required): Image ID
-   **Response Example (200 OK):**
    ```json
    {
        "success": true,
        "message": "Image deleted successfully"
    }
    ```

---

## Videos Management

### Add Video

-   **Method:** `POST`
-   **URL:** `/video`
-   **Description:** Add a video reference (YouTube embed or similar)
-   **Input:**
    -   `name` (string, required): Video identifier/title
    -   `type` (string, required): Video type - "article_featured", "event_featured", etc.
    -   `article_id` (integer, optional): Associated article ID
    -   `expert_id` (integer, optional): Associated expert ID
    -   `event_id` (integer, optional): Associated event ID
    -   `front_sittings_id` (integer, optional): Front settings ID
    -   `author_id` (integer, optional): Author ID
-   **Request Example:**
    ```json
    {
        "name": "heart_surgery_techniques.jpg",
        "type": "article_featured",
        "article_id": 2,
        "expert_id": null,
        "event_id": null,
        "front_sittings_id": null,
        "author_id": null
    }
    ```
-   **Response Example (201 Created):**
    ```json
    {
        "message": "Video created successfully",
        "data": {
            "base_url": "https://www.youtube.com/embed/",
            "name": "heart_surgery_techniques.jpg",
            "type": "article_featured",
            "expert_id": null,
            "event_id": null,
            "article_id": 2,
            "front_sittings_id": null,
            "updated_at": "2025-12-08T10:49:44.000000Z",
            "created_at": "2025-12-08T10:49:44.000000Z",
            "id": 6
        }
    }
    ```

---

## Experts Management

### Create Expert

-   **Method:** `POST`
-   **URL:** `/expert`
-   **Description:** Create a new medical expert profile with comprehensive bilingual details
-   **Input:**
    -   `name_en`, `name_ar` (string, required): Expert name in English and Arabic
    -   `job_en`, `job_ar` (string, required): Job title in both languages
    -   `medpulse_role_en`, `medpulse_role_ar` (string, required): Role at MedPulse
    -   `medpulse_role_description_en`, `medpulse_role_description_ar` (string, required): Role description
    -   `current_job_en`, `current_job_ar` (string, required): Current position
    -   `coverage_type_en`, `coverage_type_ar` (string, required): Geographic coverage
    -   `evaluated_specialties_en`, `evaluated_specialties_ar` (array, required): Array of specialties
    -   `number_of_events` (integer, required): Number of events participated
    -   `description_en`, `description_ar` (string, required): Detailed biography
    -   `years_of_experience` (integer, required): Years of experience
    -   `subspecialities_en`, `subspecialities_ar` (array, required): Subspecialties
    -   `membership_en`, `membership_ar` (array, required): Professional memberships
-   **Request Example:**
    ```json
    {
        "name_en": "Dr. John Smith",
        "name_ar": "الدكتور جون سميث",
        "job_en": "Senior Cardiologist",
        "job_ar": "طبيب قلب أول",
        "medpulse_role_en": "Medical Advisor",
        "medpulse_role_ar": "مستشار طبي",
        "medpulse_role_description_en": "Provides expert medical advice and consultation for cardiology cases",
        "medpulse_role_description_ar": "يوفر النصائح والاستشارات الطبية المتخصصة في حالات القلب",
        "current_job_en": "Head of Cardiology Department",
        "current_job_ar": "رئيس قسم القلب",
        "coverage_type_en": "International",
        "coverage_type_ar": "دولي",
        "evaluated_specialties_en": ["Cardiology", "Internal Medicine"],
        "evaluated_specialties_ar": ["طب القلب", "الطب الباطني"],
        "number_of_events": 50,
        "description_en": "Dr. John Smith is a renowned cardiologist with over 20 years of experience in treating complex heart conditions. He has published numerous research papers and has been a key speaker at international medical conferences.",
        "description_ar": "الدكتور جون سميث هو طبيب قلب مشهور بأكثر من 20 عامًا من الخبرة في علاج حالات القلب المعقدة. نشر العديد من الأوراق البحثية وكان متحدثًا رئيسيًا في المؤتمرات الطبية الدولية.",
        "years_of_experience": 20,
        "subspecialities_en": ["Interventional Cardiology", "Heart Failure"],
        "membership_en": [
            "American College of Cardiology",
            "European Society of Cardiology"
        ],
        "subspecialities_ar": ["طب القلب التدخلي", "فشل القلب"],
        "membership_ar": [
            "الكلية الأمريكية لأمراض القلب",
            "الجمعية الأوروبية لأمراض القلب"
        ]
    }
    ```
-   **Response Example (201 Created):**
    ```json
    {
        "message": "Expert created successfully",
        "data": {
            "name_en": "Dr. John Smith",
            "name_ar": "الدكتور جون سميث",
            "job_en": "Senior Cardiologist",
            "job_ar": "طبيب قلب أول",
            "medpulse_role_en": "Medical Advisor",
            "medpulse_role_ar": "مستشار طبي",
            "medpulse_role_description_en": "Provides expert medical advice and consultation for cardiology cases",
            "medpulse_role_description_ar": "يوفر النصائح والاستشارات الطبية المتخصصة في حالات القلب",
            "current_job_en": "Head of Cardiology Department",
            "current_job_ar": "رئيس قسم القلب",
            "coverage_type_en": "International",
            "coverage_type_ar": "دولي",
            "evaluated_specialties_en": ["Cardiology", "Internal Medicine"],
            "evaluated_specialties_ar": ["طب القلب", "الطب الباطني"],
            "number_of_events": 50,
            "description_en": "Dr. John Smith is a renowned cardiologist with over 20 years of experience in treating complex heart conditions. He has published numerous research papers and has been a key speaker at international medical conferences.",
            "description_ar": "الدكتور جون سميث هو طبيب قلب مشهور بأكثر من 20 عامًا من الخبرة في علاج حالات القلب المعقدة. نشر العديد من الأوراق البحثية وكان متحدثًا رئيسيًا في المؤتمرات الطبية الدولية.",
            "years_of_experience": 20,
            "subspecialities_en": [
                "Interventional Cardiology",
                "Heart Failure"
            ],
            "membership_en": [
                "American College of Cardiology",
                "European Society of Cardiology"
            ],
            "subspecialities_ar": ["طب القلب التدخلي", "فشل القلب"],
            "membership_ar": [
                "الكلية الأمريكية لأمراض القلب",
                "الجمعية الأوروبية لأمراض القلب"
            ],
            "updated_at": "2025-12-08T09:10:40.000000Z",
            "created_at": "2025-12-08T09:10:40.000000Z",
            "id": 1
        }
    }
    ```

### Get All Experts

-   **Method:** `GET`
-   **URL:** `/experts`
-   **Description:** Retrieve paginated list of experts
-   **Query Parameters:**
    -   `page` (integer, optional): Page number (default: 1)
-   **Response Example (200 OK):**
    ```json
    {
      "data": {
        "current_page": 1,
        "data": [
          {
            "id": 1,
            "name_en": "Dr. John Smith",
            "name_ar": "الدكتور جون سميث",
            "job_en": "Senior Cardiologist",
            "job_ar": "طبيب قلب أول",
            "medpulse_role_en": "Medical Advisor",
            "medpulse_role_ar": "مستشار طبي",
            "medpulse_role_description_en": "Provides expert medical advice and consultation for cardiology cases",
            "medpulse_role_description_ar": "يوفر النصائح والاستشارات الطبية المتخصصة في حالات القلب",
            "current_job_en": "Head of Cardiology Department",
            "current_job_ar": "رئيس قسم القلب",
            "coverage_type_en": "International",
            "coverage_type_ar": "دولي",
            "evaluated_specialties_en": ["Cardiology", "Internal Medicine"],
            "evaluated_specialties_ar": ["طب القلب", "الطب الباطني"],
            "number_of_events": 50,
            "description_en": "Dr. John Smith is a renowned cardiologist with over 20 years of experience in treating complex heart conditions...",
            "description_ar": "الدكتور جون سميث هو طبيب قلب مشهور بأكثر من 20 عامًا من الخبرة في علاج حالات القلب المعقدة...",
            "years_of_experience": 20,
            "subspecialities_en": ["Interventional Cardiology", "Heart Failure"],
            "membership_en": ["American College of Cardiology", "European Society of Cardiology"],
            "subspecialities_ar": ["طب القلب التدخلي", "فشل القلب"],
            "membership_ar": ["الكلية الأمريكية لأمراض القلب", "الجمعية الأوروبية لأمراض القلب"],
            "created_at": "2025-12-08T09:10:40.000000Z",
            "updated_at": "2025-12-08T09:10:40.000000Z",
            "images": []
          }
        ],
        "first_page_url": "http://127.0.0.1:8000/api/experts?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://127.0.0.1:8000/api/experts?page=1",
        "links": [...],
        "next_page_url": null,
        "path": "http://127.0.0.1:8000/api/experts",
        "per_page": 6,
        "prev_page_url": null,
        "to": 2,
        "total": 2
      }
    }
    ```

### Get Expert

-   **Method:** `GET`
-   **URL:** `/expert/{id}`
-   **Description:** Retrieve detailed expert information including images, videos, and contacts
-   **Parameters:**
    -   `id` (integer, required): Expert ID
-   **Response Example (200 OK):**
    ```json
    {
        "data": {
            "id": 1,
            "name_en": "Dr. John Smith",
            "name_ar": "الدكتور جون سميث",
            "job_en": "Senior Cardiologist",
            "job_ar": "طبيب قلب أول",
            // ... other expert fields
            "images": [],
            "videos": [],
            "contacts": []
        }
    }
    ```

### Update Expert

-   **Method:** `POST`
-   **URL:** `/expert/{id}`
-   **Description:** Update expert information (partial updates allowed)
-   **Parameters:**
    -   `id` (integer, required): Expert ID
-   **Input:** Any expert fields to update (partial update supported)
-   **Request Example:**
    ```json
    {
        "name_en": "Dr. Sarah Johnson",
        "name_ar": "الدكتورة سارة جونسون"
    }
    ```
-   **Response Example (200 OK):** Returns updated expert object

### Delete Expert

-   **Method:** `DELETE`
-   **URL:** `/expert/{id}`
-   **Description:** Delete an expert profile
-   **Parameters:**
    -   `id` (integer, required): Expert ID
-   **Response Example (200 OK):**
    ```json
    {
        "message": "Expert deleted successfully"
    }
    ```

---

## Events Management

### Create Event

-   **Method:** `POST`
-   **URL:** `/event`
-   **Description:** Create a new medical event/conference with bilingual details
-   **Input:**
    -   `title_en`, `title_ar` (string, required): Event title
    -   `location` (string, required): Event location
    -   `date_of_happening` (date, required): Event date (YYYY-MM-DD)
    -   `stars` (integer, required): Star rating (1-5)
    -   `rate` (float, required): Numerical rating (0-10)
    -   `organizer_en`, `organizer_ar` (string, required): Organizer name
    -   `description_en`, `description_ar` (string, required): Event description
    -   `subjects_description_en`, `subjects_description_ar` (string, required): Subjects description
    -   `subjects` (array, required): Array of subjects/topics
    -   `authors_description_en`, `authors_description_ar` (string, required): Speakers description
    -   `comments_for_medpulse_en`, `comments_for_medpulse_ar` (string, required): Internal comments
-   **Request Example:**
    ```json
    {
        "title_en": "International Cardiology Conference 2024",
        "title_ar": "المؤتمر الدولي لأمراض القلب ٢٠٢٤",
        "location": "Dubai, UAE",
        "date_of_happening": "2024-05-15",
        "stars": 5,
        "rate": 9.5,
        "organizer_en": "World Heart Federation",
        "organizer_ar": "الاتحاد العالمي للقلب",
        "description_en": "Annual gathering of cardiology experts from around the world to discuss the latest advancements...",
        "description_ar": "الاجتماع السنوي لخبراء أمراض القلب من جميع أنحاء العالم لمناقشة أحدث التطورات...",
        "subjects_description_en": "Topics include interventional cardiology, heart failure management...",
        "subjects_description_ar": "تشمل المواضيع طب القلب التدخلي، وإدارة فشل القلب...",
        "subjects": [
            "Cardiology",
            "Interventional Procedures",
            "Heart Failure",
            "Electrophysiology"
        ],
        "authors_description_en": "Featuring presentations from Dr. John Smith, Dr. Maria Garcia, and Prof. Ahmed Hassan.",
        "authors_description_ar": "يضم عروضاً تقديمية من الدكتور جون سميث والدكتورة ماريا غارسيا والبروفيسور أحمد حسن.",
        "comments_for_medpulse_en": "Excellent conference with high-quality presentations and networking opportunities.",
        "comments_for_medpulse_ar": "مؤتمر ممتاز بعروض تقديمية عالية الجودة وفرص للتواصل."
    }
    ```
-   **Response Example (201 Created):** Returns created event object

### Get All Events

-   **Method:** `GET`
-   **URL:** `/events`
-   **Description:** Retrieve paginated list of events (6 per page)
-   **Query Parameters:**
    -   `page` (integer, optional): Page number
-   **Response Example (200 OK):** Returns paginated events with images

### Get Event

-   **Method:** `GET`
-   **URL:** `/event/{id}`
-   **Description:** Retrieve detailed event information including analysis, images, and videos
-   **Parameters:**
    -   `id` (integer, required): Event ID
-   **Response Example (200 OK):**
    ```json
    {
        "data": {
            "id": 1,
            "title_en": "International Cardiology Conference 2024",
            "title_ar": "المؤتمر الدولي لأمراض القلب ٢٠٢٤",
            // ... other event fields
            "analysis": {
                "id": 1,
                "event_id": 1,
                "description_en": "Comprehensive analysis of the International Cardiology Conference 2024...",
                "description_ar": "تحليل شامل للمؤتمر الدولي لأمراض القلب ٢٠٢٤...",
                "content_rate": 9.5,
                "content_rate_description_en": "Exceptional scientific content with comprehensive coverage...",
                "content_rate_description_ar": "محتوى علمي استثنائي مع تغطية شاملة...",
                "organisation_rate": 9.2,
                "organisation_rate_description_en": "Flawless organization with efficient registration process...",
                "organisation_rate_description_ar": "تنظيم لا تشوبه شائبة مع عملية تسجيل فعالة...",
                "speaker_rate": 9.7,
                "speaker_rate_description_en": "World-class speakers including Nobel laureates...",
                "speaker_rate_description_ar": "متحدثون على مستوى عالمي بما في ذلك الحائزون على جائزة نوبل...",
                "sponsering_rate": 8.8,
                "sponsering_rate_description_en": "Strong sponsorship from major medical device companies...",
                "sponsering_rate_description_ar": "رعاية قوية من شركات الأجهزة الطبية الكبرى...",
                "scientific_impact_rate": 9.6,
                "scientific_impact_rate_description_en": "High scientific impact with presentations of groundbreaking research..."
            }
        }
    }
    ```
