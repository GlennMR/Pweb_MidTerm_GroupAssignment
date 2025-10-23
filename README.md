# Student Management System

A simple CRUD (Create, Read, Update, Delete) application for managing student data using PHP and MySQL.

## Features

- User Authentication (Login/Register)
- Student Management
  - Add new students
  - View all students
  - Update student information
  - Delete students
- Responsive design using Bootstrap

## Requirements

- PHP 7.0 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

## Installation

1. Clone the repository
```bash
git clone https://github.com/yourusername/student-management.git
```

2. Create a MySQL database named `db_mahasiswa`

3. Import the database schema
- Open phpMyAdmin
- Select the `db_mahasiswa` database
- Click on "Import"
- Choose the `database.sql` file from the project
- Click "Go" to import the schema

4. Configure database connection
- Open `includes/config.php`
- Update the database credentials if needed:
  ```php
  $host = "localhost";
  $username = "your_username";
  $password = "your_password";
  $database = "db_mahasiswa";
  ```

5. Place the files in your web server directory
   - For XAMPP: `htdocs` folder
   - For WampServer: `www` folder

6. Access the application through your web browser
```
http://localhost/your-folder-name
```

## Usage

1. Register a new account
2. Login with your credentials
3. Start managing student records:
   - Add new students using the form
   - View all students in the table
   - Edit student information using the "Edit" button
   - Delete students using the "Delete" button

## Database Structure

### Users Table
- id (Primary Key)
- username
- password
- created_at

### Mahasiswa (Students) Table
- id (Primary Key)
- NRP (Student ID)
- nama (Name)
- jurusan (Department)
- asal (Origin)
- created_by (Foreign Key to users.id)
- created_at

## Security Features

- Password hashing
- SQL injection prevention
- Session management
- Form validation

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request