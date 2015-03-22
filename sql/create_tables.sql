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
	prioriteetti smallint,
	lisayspaiva date
);

create table luokka(
	id serial primary key,
	nimi varchar(50)
);

create table luokat(
	id serial primary key,
	muistiinpano integer references muistiinpano(id),
	luokka integer references luokka(id)
);