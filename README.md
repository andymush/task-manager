# Laravel Task Management Web Application
This guide walks you through creating a simple Laravel web application for task management, including features like creating, editing, deleting, and reordering tasks with drag-and-drop functionality.


## Prerequisites
- PHP (>= 8.0 recommended)
- Composer
- MySQL
- Node.js & NPM (for frontend dependencies)
- Laravel >= v10 
  
Laravel is accessible, powerful, and provides tools required for large, robust applications.

### Step 1: Set Up Laravel Project

    composer create-project laravel/laravel task-manager
    cd task-manager

### Step 2: Set Up Database

Edit the .env file to configure database connection:
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=task_manager
    DB_USERNAME=root
    DB_PASSWORD=yourpassword

Then, create the database in MySQL:
        
    CREATE DATABASE task_manager;

### Step 3: Run Migrations 

Run the migration files:

    php artisan migrate

Optional: Seed the database with sample data
    
    php artisan db:seed

### Step 4: Run the Application Locally

    php artisan serve

Visit `http://localhost:8000` or `http://127.0.0.1:8000` in your browser to see the application running.

## Deployment Instructions

### Prerequisites
- A web server with PHP 8.1+ (Apache, Nginx, etc.)
- MySQL database server
- Composer installed on the server
- Git (optional, for deployment via Git)

### Deployment

1. **Prepare the server environment**:
   - Install PHP 8.1+ with required extensions (BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
   - Install and configure MySQL
   - Install Composer
   - Install Node.js and NPM (for frontend assets)

2. **Upload the application**:
   - Upload the entire project directory to your server via SFTP
   - Or clone directly from your Git repository:
     ```bash
     git clone [your-repository-url]
     cd task-manager
     ```

3. **Install dependencies**:
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

4. **Set up environment variables**:
   - Copy `.env.example` to `.env`
   - Configure your database connection details
   - Generate application key:
     ```bash
     php artisan key:generate
     ```

5. **Set directory permissions**:
   ```bash
   chmod -R 755 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

6. **Set up the database**:
   ```bash
   php artisan migrate
   # Optional: Seed the database with sample data
   php artisan db:seed
   ```

7. **Configure web server**:
   - For Apache, ensure mod_rewrite is enabled and .htaccess is working
   - For Nginx, configure the server block to point to the public directory

8. **Optimize the application**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## System Requirements

- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Node.js and NPM
- Web server (Apache/Nginx)

## Features

1. **Tasks Management**:
   - Create, edit, and delete tasks
   - Each task has a name and priority
   - Tasks are automatically assigned a new priority when created

2. **Drag-and-Drop Reordering**:
   - SortableJS is used to implement drag-and-drop functionality
   - Priority is automatically updated based on the order (top = #1 priority)

3. **Project Functionality**:
   - Create, edit, and delete projects
   - Associate tasks with projects
   - Filter tasks by project
   - View task count per project

4. **Database Structure**:
   - MySQL tables for tasks and projects
   - Foreign key relationship between tasks and projects
   - Automatic timestamps for creation and updates

5. **Clean and Responsive UI**:
   - Bootstrap-based layout
   - Responsive design that works on mobile and desktop
   - Confirmation for deletion operations
