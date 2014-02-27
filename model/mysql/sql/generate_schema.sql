DROP DATABASE IF EXISTS umanly;
CREATE DATABASE umanly;
USE umanly;

CREATE TABLE user
(
  id INT NOT NULL AUTO_INCREMENT,
  login VARCHAR(25) NOT NULL,
  first_name VARCHAR(25) NOT NULL,
  last_name VARCHAR(25) NOT NULL,
  password VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

