-- FeedTrack — clean schema + seed data
-- Import via phpMyAdmin or:  mysql -u root < app/schema.sql

CREATE DATABASE IF NOT EXISTS `feedtrack`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `feedtrack`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `activity_log`;
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `production`;
DROP TABLE IF EXISTS `recipe_items`;
DROP TABLE IF EXISTS `recipes`;
DROP TABLE IF EXISTS `inventory`;
DROP TABLE IF EXISTS `suppliers`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- ------------------------------------------------------------------
CREATE TABLE `users` (
  `id`            INT AUTO_INCREMENT PRIMARY KEY,
  `name`          VARCHAR(120) NOT NULL,
  `email`         VARCHAR(190) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role`          ENUM('admin','staff') NOT NULL DEFAULT 'staff',
  `active`        TINYINT(1) NOT NULL DEFAULT 1,
  `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `suppliers` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `name`       VARCHAR(150) NOT NULL,
  `contact`    VARCHAR(120) DEFAULT NULL,
  `email`      VARCHAR(190) DEFAULT NULL,
  `address`    VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `inventory` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `name`        VARCHAR(150) NOT NULL,
  `category`    ENUM('ingredient','finished') NOT NULL DEFAULT 'ingredient',
  `feed_type`   VARCHAR(80) NOT NULL DEFAULT 'All',
  `quantity`    DECIMAL(16,2) NOT NULL DEFAULT 0,
  `unit`        VARCHAR(20) NOT NULL DEFAULT 'kg',
  `price`       DECIMAL(12,2) NOT NULL DEFAULT 0,
  `min_level`   DECIMAL(16,2) NOT NULL DEFAULT 0,
  `max_level`   DECIMAL(16,2) NOT NULL DEFAULT 0,
  `supplier_id` INT DEFAULT NULL,
  `updated_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_inv_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- A finished-product formula.
CREATE TABLE `recipes` (
  `id`           INT AUTO_INCREMENT PRIMARY KEY,
  `product_name` VARCHAR(150) NOT NULL UNIQUE,
  `yield_qty`    DECIMAL(16,2) NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE `recipe_items` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `recipe_id`  INT NOT NULL,
  `ingredient` VARCHAR(150) NOT NULL,
  `quantity`   DECIMAL(16,2) NOT NULL DEFAULT 0,
  CONSTRAINT `fk_ri_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `production` (
  `id`           INT AUTO_INCREMENT PRIMARY KEY,
  `product_name` VARCHAR(150) NOT NULL,
  `feed_type`    VARCHAR(80) NOT NULL DEFAULT 'All',
  `quantity`     DECIMAL(16,2) NOT NULL DEFAULT 0,
  `ingredients`  TEXT DEFAULT NULL,
  `start_date`   DATE NOT NULL,
  `end_date`     DATE NOT NULL,
  `status`       ENUM('pending','late','complete') NOT NULL DEFAULT 'pending',
  `created_by`   INT DEFAULT NULL,
  `created_at`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_prod_user` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `orders` (
  `id`             INT AUTO_INCREMENT PRIMARY KEY,
  `customer`       VARCHAR(150) NOT NULL,
  `item`           VARCHAR(150) NOT NULL,
  `quantity`       DECIMAL(16,2) NOT NULL DEFAULT 0,
  `unit_price`     DECIMAL(12,2) NOT NULL DEFAULT 0,
  `total`          DECIMAL(14,2) NOT NULL DEFAULT 0,
  `status`         ENUM('pending','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `created_by`     INT DEFAULT NULL,
  `order_date`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delivered_date` TIMESTAMP NULL DEFAULT NULL,
  CONSTRAINT `fk_order_user` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `activity_log` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `user_id`     INT DEFAULT NULL,
  `type`        VARCHAR(40) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ------------------------------------------------------------------
-- Seed data. All demo passwords are "123" (bcrypt hashes below).
-- admin1 / admin2 hashes are password_hash('123', PASSWORD_BCRYPT).
INSERT INTO `users` (`name`, `email`, `password_hash`, `role`, `active`) VALUES
('admin1', 'admin1@feedtrack.test', '$2y$12$duWGQAXqIIcZrp28t5gxleFzL97zX5dz.zbLqI1mB.pGg6Bvey/xe', 'admin', 1),
('admin2', 'admin2@feedtrack.test', '$2y$12$duWGQAXqIIcZrp28t5gxleFzL97zX5dz.zbLqI1mB.pGg6Bvey/xe', 'staff', 1);

INSERT INTO `suppliers` (`name`, `contact`, `email`, `address`) VALUES
('AgriGrains Corp.', '0917-555-0101', 'sales@agrigrains.test', 'Batangas City'),
('FarmMix Supply',   '0917-555-0102', 'orders@farmmix.test',  'Lipa City');

INSERT INTO `inventory` (`name`, `category`, `feed_type`, `quantity`, `unit`, `price`, `min_level`, `max_level`, `supplier_id`) VALUES
('Corn',                 'ingredient', 'All', 12000, 'kg', 25, 8000, 40000, 1),
('Soybean Meal',         'ingredient', 'All',  2250, 'kg', 33, 8000, 50000, 1),
('Fish Meal',            'ingredient', 'All',  9300, 'kg', 15, 7000, 30000, 2),
('Limestone',            'ingredient', 'All',  7405, 'kg', 17, 5000, 20000, 2),
('Wheat Bran',           'ingredient', 'Hog',  5000, 'kg', 55, 10000, 20000, 1),
('Vitamin Premix',       'ingredient', 'All',  1200, 'kg', 90, 500, 3000, 2),
('Salt',                 'ingredient', 'All',  3000, 'kg',  8, 1000, 6000, 2),
('Molasses',             'ingredient', 'All',  4000, 'kg', 20, 2000, 8000, 1),
('Hog Starter Feed',     'finished',   'Hog',  1000, 'kg', 72, 200, 5000, NULL),
('Hog Grower Feed',      'finished',   'Hog',   800, 'kg', 70, 200, 5000, NULL),
('Chicken Starter Feed', 'finished',   'Chicken', 600, 'kg', 68, 200, 5000, NULL);

INSERT INTO `recipes` (`product_name`, `yield_qty`) VALUES
('Hog Starter Feed', 1000),
('Chicken Starter Feed', 1000);

INSERT INTO `recipe_items` (`recipe_id`, `ingredient`, `quantity`) VALUES
(1, 'Corn', 450), (1, 'Soybean Meal', 350), (1, 'Fish Meal', 70),
(1, 'Molasses', 50), (1, 'Limestone', 10), (1, 'Vitamin Premix', 5), (1, 'Salt', 5),
(2, 'Corn', 500), (2, 'Soybean Meal', 300), (2, 'Fish Meal', 70),
(2, 'Limestone', 20), (2, 'Vitamin Premix', 10), (2, 'Salt', 5);

INSERT INTO `production` (`product_name`, `feed_type`, `quantity`, `ingredients`, `start_date`, `end_date`, `status`, `created_by`) VALUES
('Hog Starter Feed', 'Hog', 1000, 'Corn 450, Soybean Meal 350, Fish Meal 70', '2026-09-10', '2026-09-12', 'complete', 1),
('Chicken Starter Feed', 'Chicken', 1000, 'Corn 500, Soybean Meal 300', '2026-09-15', '2026-09-20', 'pending', 1);

INSERT INTO `orders` (`customer`, `item`, `quantity`, `unit_price`, `total`, `status`, `created_by`, `delivered_date`) VALUES
('Santos Piggery', 'Hog Starter Feed', 200, 72, 14400, 'delivered', 1, '2026-09-12 09:00:00'),
('Cruz Poultry',   'Chicken Starter Feed', 150, 68, 10200, 'pending', 1, NULL);

INSERT INTO `activity_log` (`user_id`, `type`, `description`) VALUES
(1, 'auth', 'Seed data loaded');
