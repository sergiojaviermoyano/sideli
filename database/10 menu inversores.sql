insert into sismenu VALUES (null, 'Inversores', '', 'investor', 'index',(Select menuId from sismenu where menuName = 'Agentes'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Inversores'),(select actId from sisactions where actDescription = 'Add'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Inversores'),(select actId from sisactions where actDescription = 'Edit'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Inversores'),(select actId from sisactions where actDescription = 'Del'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Inversores'),(select actId from sisactions where actDescription = 'View'));