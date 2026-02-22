# 🎓 Learning Management System (LMS)

A full-stack Learning Management System built with Laravel, Inertia.js, React, TypeScript, and TailwindCSS.

This application allows instructors to create and manage courses, students to enroll and track progress, and admins to manage the platform.

---

## 🚀 Features

### 👨‍🏫 Instructor
- Create, edit, delete courses
- Upload course thumbnails
- Add and manage lessons
- Set course level (Beginner, Intermediate, Advanced)
- Publish courses
- View enrolled students

### 🎓 Student
- Browse and enroll in courses
- Secure lesson access (only enrolled students)
- Watch lessons
- Mark lessons as complete
- Automatic progress tracking
- Dashboard showing enrolled courses
- Course completion tracking

### 🛡 Admin
- Manage all courses
- Control publishing
- Monitor platform content

---

## 🛠 Tech Stack

### Backend
- Laravel
- Eloquent ORM
- Policies & Authorization
- Pivot Tables (Many-to-Many relationships)

### Frontend
- Inertia.js
- React
- TypeScript (Strict Mode)
- TailwindCSS
- ShadCN UI

### Database
- MySQL

---

## 🧠 Architecture Highlights

- Role-based access control
- Secure lesson authorization
- Course progress tracking via pivot table
- Optimized Eloquent relationships
- SPA experience using Inertia.js
- File upload handling with storage system

---

## 📸 Screenshots

(Add screenshots here after deployment)

---

## ⚙ Installation

```bash
# Clone repository
git clone https://github.com/yourusername/lms-platform.git

# Go to project folder
cd lms-platform

# Install backend dependencies
composer install

# Install frontend dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Create storage link
php artisan storage:link

# Start development server
php artisan serve

# Start Vite
npm run dev
```

---

## 🔐 Environment Variables

Configure your `.env` file:

```
APP_NAME=LMS
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

---

## 📊 Database Structure

- users
- courses
- lessons
- enrollments (pivot)
- lesson_user (completion pivot)
- categories
- reviews

---

## 🎯 Future Improvements

- Course certificates
- Stripe payment integration
- Ratings & reviews system
- Course search & filtering
- Video streaming optimization
- Multi-tenant support

---

## 👨‍💻 Author

Built by **Piyush Prasad**

---

## 📄 License

This project is open-source and available under the MIT License.
