create table Movie
	(id 		int not null,
	 title 		varchar(100) not null,
	 year		int not null,
	 rating		varchar(10),
	 company	varchar(50),
	 primary key(id)) ENGINE=INNODB; 	#each movie has its own identifier number: Primary constraint (1)

create table Actor
	(id 		int not null,
	 last		varchar(20) not null,
	 first		varchar(20) not null,
	 sex		varchar(6) not null,
	 dob		date not null,
	 dod		date,
	 primary key(id),			#each actor has his/her own identifier number: Primary constraint (2)
	 check(dod is null OR dod > dob)) 	#date of death is either null or has to be bigger than date of birth: Check constraint (1)
	 ENGINE=INNODB;

create table Director
	(id		int not null,
	 last		varchar(20) not null,
	 first		varchar(20) not null,
	 dob		date not null,
	 dod		date,
       	 primary key(id),			#each director has his/her own identifier number: Primary constraint (3)
	 check(dod is null OR dod > dob)) 	#same check as actor table check: Check constraint (2)
	 ENGINE=INNODB;

create table MovieGenre
	(mid		int not null,
	 genre		varchar(20) not null,
	 foreign key(mid) references Movie(id))	#identifier number of movie is referenced by this table: referential integrity constraint (1)
 	 ENGINE=INNODB;

create table MovieDirector
	(mid		int not null,
	 did		int not null,
	 foreign key(mid) references Movie(id), #referential integrity constraint (2)
	 foreign key(did) references Director(id))	#both movie id and director id are referenced :referential integrity constraint (3)
	 ENGINE=INNODB;

create table MovieActor
	(mid 		int not null,
	 aid		int not null,
	 role		varchar(50) not null,
	 foreign key(mid) references Movie(id), #referential integrity constraint (4)
	 foreign key(aid) references Actor(id))	#both movie id and actor id are referenced: referential integrity constraint (5)
	 ENGINE=INNODB;

create table Review
	(name		varchar(20) not null,
	 time		timestamp not null,
	 mid		int not null,
	 rating		int not null,
	 comment	varchar(500),
	 foreign key(mid) references Movie(id),	#refrences movie id: referential integrity constraint(6)
	 check(rating >= 0 and rating <= 5)) 	#rating must be between 0 and 5: Check constraint (3)
	 ENGINE = INNODB;

create table MaxPersonID
	(id		int not null) ENGINE=INNODB;

create table MaxMovieID
	(id		int not null) ENGINE=INNODB;
