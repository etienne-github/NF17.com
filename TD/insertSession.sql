begin Transaction
update tGroupe set fkSession = NULL;
Delete from tSession;
Insert into tSession Values(1,'2008-01-12 09:00:00','2008-01-12 11:00:00');
Insert into tSession Values(2,'2008-01-12 11:30:00','2008-01-12 13:30:00');
Insert into tSession Values(3,'2008-01-12 14:00:00','2008-01-12 16:00:00');
Insert into tSession Values(4,'2008-01-12 16:30:00','2008-01-12 18:30:00');
Insert into tSession Values(5,'2008-01-13 09:00:00','2008-01-13 11:00:00');
Insert into tSession Values(6,'2008-01-13 11:30:00','2008-01-13 13:30:00');
Insert into tSession Values(7,'2008-01-13 14:00:00','2008-01-13 16:00:00');
Insert into tSession Values(8,'2008-01-13 16:30:00','2008-01-13 18:30:00');
commit;

