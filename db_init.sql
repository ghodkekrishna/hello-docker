CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Password: admin
INSERT INTO users (username, password) 
VALUES ('admin@gmail.com', '$2y$10$kVXMGA1vGOfBaIH/p4Eh0eApZ7GpmxK37Ub9FMBoFr.RVaCV7HTna');