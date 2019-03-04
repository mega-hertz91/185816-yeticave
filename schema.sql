CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nikname CHAR (128) UNIQUE,
  email CHAR(128) NOT NULL UNIQUE,
  password CHAR(64),
  contact TEXT,
  avatar TEXT,
  date_db DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(128) UNIQUE,
  class TEXT
);

CREATE TABLE lots (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name CHAR(128),
  description TEXT,
  image TEXT,
  category_id INT,
  user_id INT,
  start_price FLOAT NOT NULL,
  step_bet INT NOT NULL,
  start_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  finish_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bets (
  id INT PRIMARY KEY AUTO_INCREMENT,
  price_bet FLOAT,
  user_id INT,
  lot_id INT,
  date_bet DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE FULLTEXT INDEX lots_search
  ON lots(name, description);
