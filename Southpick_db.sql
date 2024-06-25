-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2024 at 07:21 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `southpick_db`
--
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`) VALUES
(13, 'Admin Resort', 'admin1@gmail.com', '$2y$10$Py9A2wmIQGbrp9QP5AKhtOGqkmd0hbemzT3jppVmf0cUm7KAClAdW'),
(14, 'alliah forteza', 'alliahf@gmail.com', '$2y$10$2bYb.IsNXwppbDvRD06/deYLIzdGOq7LAzZQAmRwqCMYMSP3O8qNm');



-- Table structure for table `rooms`
--
CREATE TABLE `food` (
  `food_id` int(11) NOT NULL,
  `food_name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `food` (`food_id`, `food_name`, `description`, `image_path`) VALUES
(1, 'Chicken Adobo', 'A Filipino dish of pork or chicken stewed in a marinade of vinegar,soy sauce, garlic, herbs, and spices; the national dish of the Philippines: ', '../Food/adobo.jpg'),
(2, 'Shrimp Sinigang', 'A Filipino soup or stew characterized by its sour and savory taste. It is most often associated with tamarind (Filipino: sampalok).', '../Food/sinigang.jpg'),
(3, 'Crispy Lechon', 'The slowly-roasted suckling pig is usually stuffed with lemongrass, tamarind, garlic, onions, and chives, and is then roasted on a large bamboo spit over an open fire.', '../Food/lechon.jpg'),
(4, 'Inihaw', 'Group of skewered meat dishes, usually offal, that are basted with a sauce and grilled over charcoal. Commonly used cuts of meat include marinated pork, chicken or pork intestines, and pig ears.', '../Food/isaw.jpg'),
(5, 'Kakanin', 'These are sweet munchies or sometimes desserts made from rice, sweet rice or root vegetables that are slow cooked and usually made with coconut or coconut milk.', '../Food/puto.jpg'),
(6, 'Halo Halo', 'Halo-halo is a favorite Filipino dessert or snack because it is cold and refreshing, perfect for beating the tropical heat that exists almost year round in the Philippines.', '../Food/halo-halo.png');

CREATE TABLE `places` (
  `place_id` int(11) NOT NULL,
  `place_name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `places` (`place_id`, `place_name`, `description`, `image_path`) VALUES
(1, 'Baguio','Baguio, known as the Summer Capital of the Philippines, is the ideal location for anyone looking to escape the tropical heat of the lowlands. Even during the warmest months of the year, the city rarely sees temperatures beyond 26°C.','../places/baguio.jpg'),
(2, 'Bohol','The home of the famous Chocolate Hills, Bohol is one of the most visited destinations in the Central Visayas region of the Philippines. The island province offers breathtaking spots for history buffs, beach lovers, and adrenaline junkies.','../places/bohol.jpg'),
(3, 'Boracay','With glorious White Beach and the countrys best island nightlife on its resume, its easy to understand why Boracay is the Philippines top tourist draw. Learn more about the new Boracay and be prepared to fall in love all over again.','../places/boracay.jpg'),
(4, 'Cebu','Beyond its historical sites, luxury resorts, and vibrant nightlife, this urban destination also offers eco-adventures. Within the forests of interior Cebu, waterfalls and rare birds await those adventurous enough to seek them out. ','../places/cebu.jpg'),
(5, 'Ilocos','In Ilocos Sur, you’ll be delighted to step into the picturesque Vigan, a UNESCO World Heritage site. It feels like time traveling to the past, as the Spanish-era houses have been well-preserved over the years. ','../places/ilocos.png'),
(6, 'Palawan','The paradisal province of Palawan is a constant feature in many international “Best In The World” lists, thanks to its rich and diverse flora and fauna, and much-preserved natural attractions.','../places/palawan.jpg');


-- Indexes for table `rooms`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`);


--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `places`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;



CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(500) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `id_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password_hash`, `phone`, `birthdate`, `address`, `postal_code`, `id_image`) VALUES
(32, 'myle', 'myleab@gmail.com', '$2y$10$XMGJ7Vuz/2JffkMmM6uEi.RiUmN15/AMiFWzOFelaEKGrP3lqOIxa', '09216564825', '2002-04-29', 'ph21 lo3', '4026', '../uploads/Yellow and Black Fun Modern Restaurant Food Logo (1).png'),
(36, 'Test User', 'trisha@gmail.com', '$2y$10$8Fz7CsKRoxwIeYLKX2HB3uBqT6pSw69.7aYbpJjIklusnB73BYqmO', '946689297', '2001-12-10', 'Santa Rosa\r\n1', '112312', '../uploads/home.png');




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
