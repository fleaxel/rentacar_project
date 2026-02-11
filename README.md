# 🚗 Rent-A-Car Website Project

A basic Rent-A-Car web application built using **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**. It allows users to rent and return cars, while admins can manage the fleet.

---

## 🔧 Features

* User/Admin login
* Car rental and release system
* Admin can add/remove cars
* Admin dashboard: car list and rental history
* Car rental history tracking
* Dark mode interface
* Responsive layout

---

## 💻 How to Run This Project (Windows + XAMPP)

### ✅ 1. Install XAMPP

* Download: [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
* Install and run it
* Start both:

  * ✅ Apache
  * ✅ MySQL

---

### ✅ 2. Set Up the Project

* Clone or download this repo
* Move the folder to:

```
C:\xampp\htdocs\rentacar
```

(You can rename the folder `rentacar` for simplicity)

---

### ✅ 3. Import the Database

1. Visit: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Create a new database:

   ```
   rentacar
   ```
3. Click **Import** tab
4. Choose `init_rentacar.sql` from the `/database` folder
5. Click **Go**

---

### ✅ 4. Run the Website

In your browser, go to:

```
http://localhost/rentacar/index.php
```

---

### 🔐 Demo Accounts

| Username | Password | Role  |
| -------- | -------- | ----- |
| admin    | admin    | Admin |
| user1    | user1    | User  |
| user2    | user2    | User  |

---

## 📁 Folder Structure

```
rentacar/
├── css/              # Styling (dark mode)
├── js/               # Row toggle logic and enhancements
├── images/           # Logo (and future car images)
├── includes/         # DB connection
├── database/         # init_rentacar.sql
├── index.php         # Login page
├── user.php          # User dashboard
├── admin.php         # Admin panel
├── rent_car.php      # Rent action
├── release_car.php   # Release action
├── add_car.php       # Admin: add vehicle
├── remove_car.php    # Admin: delete vehicle
├── admin_cars.php    # Admin: view all cars
└── admin_rentals.php # Admin: view rental records
```

---

## ✅ Requirements

* PHP 7+
* MySQL
* Apache (via XAMPP)

---

## 📸 Screenshots *(optional)*

> Add screenshots of login, user panel, admin panel, etc.

---

## 📄 License

This project is for educational/demo use. Feel free to fork or expand it.
