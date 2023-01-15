CREATE DATABASE IF NOT EXISTS `economia`;
USE `economia`;

CREATE TABLE IF NOT EXISTS `users`(
`user_id` int NOT NULL auto_increment unique,
`user_email` varchar(50) NOT NULL,
`user_pass` varchar(100) NOT NULL,
`user_token` text NULL,
`user_token_expiration` datetime NULL,
PRIMARY KEY (user_id)
)ENGINE=INNODB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `categories`(

`category_id` int NOT NULL auto_increment unique,
`category_name` varchar(50) NOT NULL,
# 0 es false y 1 es true (Gatos=0 , ingresos=1)
`category_expense_type` tinyint(1) NOT NULL,
`category_user_id` int NOT NULL,
PRIMARY KEY(category_id),
FOREIGN KEY (category_user_id) references users(user_id) on delete cascade on update cascade
) ENGINE=INNODB DEFAULT CHARSET=UTF8;



CREATE TABLE IF NOT EXISTS `invoices`(

`invoice_id` int NOT NULL auto_increment unique,
`invoice_amount`double NOT NULL,
`invoice_description` text NULL,
`invoice_user_id`int NOT NULL,
`invoice_category_id` int NOT NULL,
`invoice_date` datetime default CURRENT_TIMESTAMP,
PRIMARY KEY(invoice_id),
FOREIGN KEY (invoice_user_id) references users(user_id) on delete cascade on update cascade,
FOREIGN KEY (invoice_category_id) references categories(category_id) on delete cascade on update cascade

)ENGINE=INNODB DEFAULT CHARSET=UTF8;

INSERT INTO USERS (USER_EMAIL, USER_PASS) VALUES("frank@gmail.com", 123456);
INSERT INTO USERS (USER_EMAIL, USER_PASS) VALUES("edgar@gmail.com", 123456);

insert into categories (category_name,category_expense_type, category_user_id) values("gastos", 0,  1);
insert into categories (category_name,category_expense_type, category_user_id) values("ingresos", 1,  1);

insert into categories (category_name,category_expense_type, category_user_id) values("gastos", 0, 2);
insert into categories (category_name,category_expense_type, category_user_id) values("ingresos", 1, 2);

insert into invoices(invoice_amount, invoice_user_id, invoice_category_id) values(19.8, 1, 1);
insert into invoices(invoice_amount, invoice_user_id, invoice_category_id) values(10.8, 1, 2);