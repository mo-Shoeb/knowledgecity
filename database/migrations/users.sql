-- up 
CREATE TABLE users (
            id int AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            password CHAR(60) NOT NULL,
            type ENUM('user', 'admin') DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, type) VALUES ('admin','$password','admin')
        
-- down
DROP TABLE `users`;