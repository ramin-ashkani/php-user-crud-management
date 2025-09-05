# User Management System

A complete **CRUD (Create, Read, Update, Delete)** web application built with **PHP** and **MySQL** for managing users.

---

## Features

- Add new users with validation
- View all users in a responsive table
- Edit existing user information
- Delete users with confirmation
- Automatic database and table creation
- CSRF protection for all forms
- Responsive design compatible with mobile devices
- Comprehensive error handling

---

## Technologies Used

- PHP 7.4+
- MySQL 5.7+
- HTML5
- CSS3 (Flexbox & Grid)
- Vanilla JavaScript

---

## Installation

1. Place the project folder in your web server directory (e.g., `htdocs` for XAMPP)
2. Ensure your MySQL server is running
3. Open the application in your browser
4. The database and table will be created automatically

---

## Configuration

The application uses the following default database credentials. Edit them in `includes/constant.php` if needed:

- Host: `localhost`
- Username: `root`
- Password: `` (empty)
- Database: `my_crud`

---

## Security Features

- Prepared statements to prevent SQL injection
- CSRF tokens for all form submissions
- Input validation and sanitization
- HTML special character escaping
- Secure session management

---

## File Structure

mycrud/
├── index.php # Main page listing all users
├── add_user.php # Form to add a new user
├── edit_user.php # Form to edit an existing user
├── style.css # Styles for the application
├── README.md # This file
└── includes/
├── constant.php # Database connection and functions
├── add_user_process.php # Process adding a new user
├── edit_user_process.php # Process editing a user
└── delete_user_process.php# Process deleting a user


---

## Usage

- **View Users:** The main page displays all users in the system.
- **Add User:** Click the "Add User" button, fill the form, and submit.
- **Edit User:** Click "Edit" next to any user, modify information, and submit.
- **Delete User:** Click "Delete" next to any user and confirm the action.

---

## Browser Support

Works on all modern browsers, including:

- Chrome (recommended)
- Firefox
- Safari
- Edge

---

## License

This project is open source and available under the **MIT License**.
