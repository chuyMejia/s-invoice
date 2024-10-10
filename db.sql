CREATE DATABASE IF NOT EXISTS invoicedb;
USE invoicedb;

CREATE TABLE IF NOT EXISTS users(
id              int(255) auto_increment not null,
role            varchar(50),
name            varchar(100),
surname         varchar(200),
email           varchar(255),
password        varchar(255),
create_at       datetime,
imagen          varchar(255),

CONSTRAINT pk_users PRIMARY KEY(id)

)ENGINE=InnoDb;


INSERT INTO users VALUES(NULL,'ROLE_USER','Jesus','Mejia','j@gmail.com','chuy120',CURTIME(),'');
INSERT INTO users VALUES(NULL,'ROLE_USER','Manolo','Perez','m@gmail.com','chuy120',CURTIME(),'');
INSERT INTO users VALUES(NULL,'ROLE_USER','Carmen','Ramos','c@gmail.com','chuy120',CURTIME(),'');



CREATE TABLE IF NOT EXISTS invoice(
id              int(255) auto_increment not null,  
user_id         int(255) not null,
ninvoice        varchar(255),
comment         text,
priority        varchar(20),
date_invoice    datetime,
create_at       datetime,
rfc             varchar(255),
imagen          varchar(255),
mount           DECIMAL(10, 4),
CONSTRAINT pk_invoice PRIMARY KEY(id),
CONSTRAINT pk_invoice_user FOREIGN KEY(user_id) references users(id),
)ENGINE=InnoDb;



INSERT INTO invoice VALUES(NULL,1,'FQ1557067','Prueba','alta',CURTIME(),CURTIME(),'MERJ951114HD4','generic',100.15);
INSERT INTO invoice VALUES(NULL,2,'FQ1557067','Prueba','alta',CURTIME(),CURTIME(),'MERJ951114HD4','generic',100.15);
INSERT INTO invoice VALUES(NULL,3,'FQ1557067','Prueba','alta',CURTIME(),CURTIME(),'MERJ951114HD4','generic',100.15);



