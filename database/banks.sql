insert into sismenu VALUES (null, 'Bancos', 'fa fa-university', 'bank', 'index',null);
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Bancos'),(select actId from sisactions where actDescription = 'Add'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Bancos'),(select actId from sisactions where actDescription = 'Edit'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Bancos'),(select actId from sisactions where actDescription = 'Del'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Bancos'),(select actId from sisactions where actDescription = 'View'));
