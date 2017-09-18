insert into sismenu VALUES (null, 'Operaciones', 'fa fa-money', 'operation', 'index',null);
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Operaciones'),(select actId from sisactions where actDescription = 'Add'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Operaciones'),(select actId from sisactions where actDescription = 'Edit'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Operaciones'),(select actId from sisactions where actDescription = 'Del'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Operaciones'),(select actId from sisactions where actDescription = 'View'));