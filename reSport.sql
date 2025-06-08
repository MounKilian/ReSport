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

INSERT INTO User (username, password, email, balance, profile_photo, role) VALUES
('jdoe', 'hashed_password1', 'jdoe@example.com', 150.00, 'A4 - 6.png', 'client'),
('asmith', 'hashed_password2', 'asmith@example.com', 300.00, 'A4 - 6.png', 'client'),
('quoi', 'hashed_admin_pw', 'admin@sportshop.com', 0.00, 'A4 - 6.png', 'client');

INSERT INTO Article (name, description, price, author_id, image_link) VALUES
('Ballon de football', 'Ballon taille 5 en cuir synthétique.', 29.99, 3, 'foot.jpg'),
('Raquette de tennis', 'Raquette légère en graphite.', 89.50, 3, 'tennis.jpg'),
('Tapis de yoga', 'Tapis antidérapant, 6mm d épaisseur.', 24.00, 3, 'yoga.jpg'),
('Halteres 10kg', 'Paire d haltères pour musculation.', 45.00, 3, 'halteres.jpg'),
('Vélo elliptique', 'Appareil cardio avec écran LCD.', 499.99, 3, 'velo.jpg'),
('Chaussures de running', 'Chaussures respirantes pour course.', 75.00, 3, 'running.jpg');

INSERT INTO Stock (article_id, quantity) VALUES
(1, 100),
(2, 50),
(3, 200),
(4, 80),
(5, 20),
(6, 60);

INSERT INTO Invoice (user_id, amount, billing_address, billing_city, billing_postal_code) VALUES
(1, 53.99, '12 Rue du Sport', 'Paris', '75001'),
(2, 120.00, '45 Boulevard Athlétique', 'Lyon', '69000');