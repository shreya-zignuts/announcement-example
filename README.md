# **Feature/Announcements**

## Overview

The feature allows admins to create, edit, and delete announcements, subject to certain constraints on date and time. Users can view a list of announcements and view individual announcements, with the status updating upon viewing.

## Features

# Authentication:
- User Authentication: Users and admins are required to authenticate to access their respective functionalities.
- Role-Based Access Control: Differentiate between user and admin roles to restrict access accordingly.

# Admin Features:
- Create Announcement
- Edit Announcement:
    Past announcements are locked from editing.
- Delete Announcement:
    Admins can delete announcements, preferably before they expire.

# User Features:
- View Announcements List:
        Users can see a list of announcements.
        Announcements are filtered based on visibility (e.g., not expired).
- View Single Announcement:
        Users can view details of a specific announcement.
        Viewing an announcement updates its status to "visible" (marking it as read).

## Requirements

- PHP >= 8.1
- Composer
- Node.js >= 21.6.2
- NPM >= 10.2.4
- MySQL

## installation

Step 1: Clone the Repository

Clone the repository to your local machine using Git.

```bash
$ git clone https://github.com/shreya-zignuts/user-role-permission-crm.git
```

Step 2: Navigate to the Project Directory

Change your current directory to the project directory.

```bash
$ cd user-permission-crm
```

Step 3: Install Composer Dependencies

Install the PHP dependencies using Composer.

```bash
$ composer install
```

Step 4: Install NPM Dependencies

Install the JavaScript dependencies using NPM.

```bash
$ npm install
```

Step 5: Copy the Environment File

Copy the .env.example file to .env.

```bash
$ cp .env.example .env
```

Step 6: Generate Application Key

Generate an application key.

```bash
$ php artisan key:generate
```

Step 7: Configure Database Connection

Configure your database connection in the .env file.

```make
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

Configure your mail connection in the .env file.

```make
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME=null
```

Step 8: Run Migrations and Seeders

Run database migrations and seeders to create database tables and populate them with initial data.

```bash
$ php artisan migrate --seed
```

Step 9: Compile Assets

Compile assets using Laravel Mix.

```bash
$ npm run dev
```

Step 10: Start the Development Server

Start the development server to run the application.

```bash
$ php artisan serve
```

Step 11: Access the Application

Open your web browser and visit http://localhost:8000 to access the application.
