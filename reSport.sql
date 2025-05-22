CREATE TABLE User (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    email VARCHAR(100) NOT NULL UNIQUE,
    balance DECIMAL(10, 2) DEFAULT 0.00,
    profile_photo VARCHAR(255), 
    role ENUM('client', 'admin') DEFAULT 'client'
);

CREATE TABLE Article (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    publish_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    author_id INT,
    image_link VARCHAR(255),
    FOREIGN KEY (author_id) REFERENCES User(id) ON DELETE SET NULL
);

CREATE TABLE Cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    article_id INT,
    FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE,
    FOREIGN KEY (article_id) REFERENCES Article(id) ON DELETE CASCADE
);

CREATE TABLE Stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT,
    quantity INT NOT NULL DEFAULT 0,
    FOREIGN KEY (article_id) REFERENCES Article(id) ON DELETE CASCADE
);

CREATE TABLE Invoice (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    transaction_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    amount DECIMAL(10, 2) NOT NULL,
    billing_address VARCHAR(255) NOT NULL,
    billing_city VARCHAR(100) NOT NULL,
    billing_postal_code VARCHAR(20) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE
);