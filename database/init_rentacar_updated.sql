-- Updated with is_active column
-- Create the database (if not already existing)
CREATE DATABASE IF NOT EXISTS `rentacar`;
USE `rentacar`;

-- Create users table
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','user') NOT NULL
);

-- Create cars table
CREATE TABLE `cars` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `manufacturer` VARCHAR(100) NOT NULL,
  `brand` VARCHAR(100) NOT NULL,
  `model` VARCHAR(100) NOT NULL,
  `registration_plate` VARCHAR(50) NOT NULL,
  `type` VARCHAR(50) NOT NULL,
  `fuel_type` VARCHAR(50) NOT NULL,
  `transmission` VARCHAR(50) NOT NULL,
  `mileage` INT NOT NULL,
  `notes` TEXT,
  `image` VARCHAR(255)
);

-- Create rentals table (tracks each rental transaction)
CREATE TABLE `rentals` (
  `rental_id` INT AUTO_INCREMENT PRIMARY KEY,
  `car_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `rent_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `return_date` DATETIME DEFAULT NULL
);

-- Insert initial users
INSERT INTO `users` (username, password, role) VALUES
('admin', 'admin', 'admin'),
('user1', 'user1', 'user'),
('user2', 'user2', 'user');

-- Insert initial cars (10 cars preloaded)
INSERT INTO `cars` (manufacturer, brand, model, registration_plate, type, fuel_type, transmission, mileage, notes, image) VALUES
('Toyota', 'Corolla', '2020', 'WX-1234', 'Sedan', 'Gasoline', 'Automatic', 30000, 'Reliable family car', 'images/placeholder.png'),
('Honda', 'Civic', '2019', 'WX-2345', 'Sedan', 'Gasoline', 'Automatic', 40000, 'Compact and fuel efficient', 'images/placeholder.png'),
('Ford', 'Mustang', '2018', 'WX-3456', 'Coupe', 'Gasoline', 'Manual', 25000, 'Sporty two-door', 'images/placeholder.png'),
('Tesla', 'Model 3', '2021', 'WX-4567', 'Sedan', 'Electric', 'Automatic', 15000, 'Electric vehicle', 'images/placeholder.png'),
('BMW', 'X5', '2017', 'WX-5678', 'SUV', 'Diesel', 'Automatic', 50000, 'Luxury SUV', 'images/placeholder.png'),
('Audi', 'A4', '2016', 'WX-6789', 'Sedan', 'Gasoline', 'Automatic', 60000, 'Comfortable sedan', 'images/placeholder.png'),
('Chevrolet', 'Impala', '2015', 'WX-7890', 'Sedan', 'Gasoline', 'Automatic', 80000, 'Spacious interior', 'images/placeholder.png'),
('Ford', 'F-150', '2020', 'WX-8901', 'Truck', 'Gasoline', 'Automatic', 30000, 'Pickup truck', 'images/placeholder.png'),
('Volkswagen', 'Golf', '2018', 'WX-9012', 'Hatchback', 'Gasoline', 'Manual', 40000, 'Compact hatchback', 'images/placeholder.png'),
('Nissan', 'Leaf', '2020', 'WX-0123', 'Hatchback', 'Electric', 'Automatic', 10000, 'Electric hatchback', 'images/placeholder.png');
