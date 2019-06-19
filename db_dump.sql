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
    phone VARCHAR(32) NOT NULL,
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
    stage ENUM('assigned', 'not assigned', 'done') NULL, 
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

CREATE TABLE ticket_offers (
    ticket_id INT NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (ticket_id) 
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

--inserts
INSERT INTO competencies(id, name) VALUES
(1, 'Математика'),
(2, 'Русский язык'),
(3, 'Информатика'),
(4, 'Английский язык'),
(5, 'Немецкий язык'),
(6, 'Программирование'),
(7, 'История');


INSERT INTO roles(id, name) VALUES
(1,'admin'),
(2,'call'),
(3,'teacher');


INSERT INTO users(id, last_name, first_name, middle_name, login, password, gender) VALUES
(6,'Попов', 'Степан', 'Алексеевич','popov', '9b56ca8566a48b98a8c29a7fd307038ed555123439a937eb85d9c45166881e6e', 'male'),
(7,'Морозова', 'Марина', 'Михайловна','morozova', '9b56ca8566a48b98a8c29a7fd307038ed555123439a937eb85d9c45166881e6e', 'female'),
(8,'Орлов', 'Евгений', 'Павлович','orlov', '9b56ca8566a48b98a8c29a7fd307038ed555123439a937eb85d9c45166881e6e', 'male'),
(9,'Андреев', 'Борис', 'Николаевич','andreev', '9b56ca8566a48b98a8c29a7fd307038ed555123439a937eb85d9c45166881e6e', 'male'),
(10,'Зайцева', 'Людмила', 'Олеговна','zaiceva', '9b56ca8566a48b98a8c29a7fd307038ed555123439a937eb85d9c45166881e6e', 'female'),
(11,'Белов', 'Павел', 'Александрович','belov', '9b56ca8566a48b98a8c29a7fd307038ed555123439a937eb85d9c45166881e6e', 'male'),
(12,'Ковалева', 'Анна', 'Петровна','kovaleva', '9b56ca8566a48b98a8c29a7fd307038ed555123439a937eb85d9c45166881e6e', 'female');


INSERT INTO user_competencies(user_id, comp_id)
VALUES (10, 3),
(11, 3),(11, 4);

INSERT INTO user_roles(user_id, role_id)
VALUES (1,2),(2,1),(10,3),(11,3);