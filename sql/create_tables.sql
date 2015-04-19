create table kayttaja(
	id serial primary key,
	kayttajatunnus varchar(50) not null,
	salasana varchar(50) not null
);

create table muistiinpano(
	id serial primary key,
	kayttaja integer references kayttaja(id),
	nimi varchar(50) not null,
	lisatiedot varchar(500),
	prioriteetti integer,
	lisayspaiva date
);

create table luokka(
	id serial primary key,
	nimi varchar(50),
	kayttaja integer references kayttaja(id)
);

create table luokat(
	muistiinpano integer references muistiinpano(id),
	luokka integer references luokka(id)
);