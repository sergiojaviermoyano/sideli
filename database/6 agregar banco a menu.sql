/*Insertar opciones de banco */
Insert into sismenu (menuName, menuIcon, menuController, menuView, menuFather) VALUES ( 'Bancos', '', 'bank', 'index', 12);

/* Insertar en menu */

insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Bancos'),(select actId from sisactions where actDescription = 'Add'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Bancos'),(select actId from sisactions where actDescription = 'Edit'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Bancos'),(select actId from sisactions where actDescription = 'Del'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Bancos'),(select actId from sisactions where actDescription = 'View'));


