CREATE DATABASE repetitors_project;

USE repetitors_project;

--users table 
CREATE TABLE users (
    id INT AUTO_INCREMENT,
    last_name VARCHAR(256) NOT NULL, -- разделить фио 
    first_name VARCHAR(256) NOT NULL,
    middle_name VARCHAR(256) NOT NULL,
    login VARCHAR(64) NOT NULL,
    password VARCHAR(256) NOT NULL,
    gender ENUM('male','female') NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE roles (
    id INT AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE user_roles (
   -- id INT AUTO_INCREMENT, так как он нигде не используется
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (user_id, role_id)
);

CREATE TABLE competencies (
    id INT AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE user_competencies (
    id INT AUTO_INCREMENT,
    user_id INT NOT NULL,
    comp_id INT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE tickets (
    id INT AUTO_INCREMENT,
    creator_id INT NOT NULL,
    staff_id INT NOT NULL,
    comp_id INT NOT NULL,
    student_id INT NOT NULL, --
    create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,  
    PRIMARY KEY (id)
);

CREATE TABLE clients (
    id INT AUTO_INCREMENT,
    last_name VARCHAR(256) NULL, 
    first_name VARCHAR(256) NULL,
    middle_name VARCHAR(256) NULL,
    phone VARCHAR(11) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE student (
    id INT AUTO_INCREMENT,
    last_name VARCHAR(256) NULL, 
    first_name VARCHAR(256) NULL,
    middle_name VARCHAR(256) NULL,
    age INT NULL,
    gender ENUM('male','female') NULL, 
    PRIMARY KEY (id)  
);

CREATE TABLE tickets_clients (
    ticket_id INT NOT NULL,
    client_id INT NOT NULL
);

CREATE TABLE ticket_stages (
    id INT AUTO_INCREMENT,
    stage ENUM('assigned', 'not assigned', 'processing') NULL, -- исправить на enum
    ticket_id INT NOT NULL,
    create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT,
    ticket_id INT NOT NULL,
    comment_text TEXT NOT NULL,
    user_id INT NOT NULL,
    create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

drop table if exists users,
roles,
user_roles,
competencies,
user_competencies,
tickets,
clients,
student,
tickets_clients,
ticket_stages,
comments;













