DROP DATABASE team10_social;

CREATE DATABASE team10_social;

use team10_social;

CREATE TABLE users(
    UID int NOT NULL AUTO_INCREMENT,
    FirstName varchar(255) NOT NULL,
    LastName varchar(255) NOT NULL,
    Email varchar(255) NOT NULL,
    Pasword varchar(255) NOT NULL,
    ImageID int NOT NULL,
    Gender varchar(255),
    Age int,
    PRIMARY KEY (UID),
    FOREIGN KEY (ImageID) REFERENCES images(IID)
    );

CREATE TABLE statuses(
    SID int NOT NULL AUTO_INCREMENT,
    UID int NOT NULL,
    Content varchar(150) NOT NULL,
    Privacy int NOT NULL,
    PRIMARY KEY (SID),
    FOREIGN KEY (UID) REFERENCES users(UID)
    );
    
CREATE TABLE friendships(
    FID int NOT NULL AUTO_INCREMENT,
    User int NOT NULL,
    Target int NOT NULL,
    PRIMARY KEY (FID),
    FOREIGN KEY (user) REFERENCES users(UID),
    FOREIGN KEY (target) REFERENCES users(UID)
    );
    
CREATE TABLE images(
    IID int NOT NULL AUTO_INCREMENT,
    Type varchar(25) NOT NULL,
    Data blob NOT NULL,
    Dimensions varchar(25) NOT NULL,
    Name varchar(255) NOT NULL,
    PRIMARY KEY (IID)
    );
