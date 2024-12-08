CREATE DATABASE pharmacy;

USE pharmacy;

CREATE TABLE medicines (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);
