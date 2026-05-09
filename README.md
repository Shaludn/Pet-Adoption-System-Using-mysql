# PET ADOPTION SYSTEM

A full-stack web application for managing pet adoption activities, including pet listings, adoption requests, user management, appointment scheduling, and adoption tracking.

## Features

- **User Authentication**: Secure login and registration system for adopters and admins
- **Pet Management**: Add, update, delete, and manage pet details
- **Pet Listings**: Browse available pets with images and detailed information
- **Adoption Requests**: Users can send adoption requests for pets
- **Appointment Booking**: Schedule visits and appointments for pet adoption
- **Admin Dashboard**: Manage pets, users, and adoption requests
- **Adoption Tracking**: Track adopted pets and request statuses
- **Responsive Design**: Compatible with desktop and mobile devices

---

## Tech Stack

### Frontend
- HTML5
- CSS3
- JavaScript

### Backend
- PHP
- MySQL

### Server
- Apache (XAMPP)

---

## Project Structure

```bash
pet_adoption/
├── uploads/                 # Uploaded pet images
├── about.php                # About page
├── add_adopter.php          # Add adopter page
├── add_pet.php              # Add pet functionality
├── admin_dashboard.php      # Admin dashboard
├── adopt_pets.php           # Pet adoption page
├── adopted_pets.php         # Adopted pets records
├── appointments.php         # Appointment booking
├── db.php                   # Database connection
├── delete_pet.php           # Delete pet functionality
├── index.php                # Home page
├── login.php                # User login
├── logout.php               # Logout functionality
├── manage_pets.php          # Manage pets page
├── mark_adopted.php         # Mark pets as adopted
├── mark_appointment.php     # Manage appointments
├── pet_detail.php           # Pet details page
├── pets.php                 # Pet listing page
├── request_visit.php        # Visit request functionality
├── thank_you.php            # Thank you page
└── view_requests.php        # View adoption requests
```

## Setup and Installation
Prerequisites
- **XAMPP
- **PHP 8+
- **MySQL
- **VS Code (optional)

## Database Setup
Open phpMyAdmin:
http://localhost/phpmyadmin

## Create a database:

CREATE DATABASE pet_adoption;
Create required tables:
- **pets
- **adopters
- **admins
- **appointments
- **Import SQL files if available.

## XAMPP Setup
Move project folder to:
C:\xampp\htdocs\
Final project path:
C:\xampp\htdocs\pet_adoption
Start:
- **Apache
- **MySQL

from XAMPP Control Panel.

Running the Project

Open browser and run:

http://localhost/pet_adoption

Or directly:

http://localhost/pet_adoption/login.php

## Database Connection
Example db.php configuration:

<?php
$conn = mysqli_connect("localhost", "root", "", "pet_adoption");

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>

## Main Functionalities
- **Admin
- **Add pets
- **Delete pets
- **Manage adoption requests
- **View appointments
- **Mark pets as adopted
- **User
- **View available pets
- **Request adoption
- **Book appointments
- **View pet details


## Sample SQL Table (pets)
- **CREATE TABLE pets (
    - **pet_id INT AUTO_INCREMENT PRIMARY KEY,
    - **name VARCHAR(100) NOT NULL,
    - **breed VARCHAR(100) NOT NULL,
    - **age FLOAT NOT NULL,
    - **gender ENUM('Male', 'Female') NOT NULL,
   - ** type ENUM('Dog', 'Cat', 'Bird', 'Rabbit', 'Other') NOT NULL,
    - **color VARCHAR(50),
    - **vaccination TEXT,
    - **medical_condition TEXT,
    - **image VARCHAR(255),
    - **status ENUM('Available', 'Pending', 'Adopted') DEFAULT 'Available',
    - **created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

## Future Enhancements
- **Email notifications
- **Online payment for adoption fees
- **AI-based pet recommendation system
- **Live chat support
- **Veterinary appointment integration

## License
This project is developed for educational purposes.

## Acknowledgements
- **XAMPP
- **PHP Documentation
- **MySQL Documentation
- **VS Code
