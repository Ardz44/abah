CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') DEFAULT 'user'
);

CREATE TABLE ulasan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  komentar TEXT
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id VARCHAR(100),
  username VARCHAR(100),
  total FLOAT,
  status VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id VARCHAR(100),
  item_name VARCHAR(100),
  price FLOAT,
  quantity INT DEFAULT 1
);

ALTER TABLE ulasan ADD COLUMN rating INT DEFAULT 5;



