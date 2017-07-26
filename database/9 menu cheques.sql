insert into sismenu VALUES (null, 'Cheques', '', 'check', 'index',(Select menuId from sismenu where menuName = 'Administración'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Cheques'),(select actId from sisactions where actDescription = 'Add'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Cheques'),(select actId from sisactions where actDescription = 'Edit'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Cheques'),(select actId from sisactions where actDescription = 'Del'));
insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Cheques'),(select actId from sisactions where actDescription = 'View'));