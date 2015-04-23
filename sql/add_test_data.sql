insert into kayttaja (kayttajatunnus, salasana) values ('käyttäjä', 'sala');
insert into kayttaja (kayttajatunnus, salasana) values ('käyttäjä2', 'sala2');

insert into muistiinpano (kayttaja, nimi, lisatiedot, prioriteetti, lisayspaiva) values ((select id from kayttaja where kayttajatunnus='käyttäjä'), 'testimuistio1', 'kuvaus', 5, '2015-04-23');
insert into muistiinpano (kayttaja, nimi, lisatiedot, prioriteetti, lisayspaiva) values ((select id from kayttaja where kayttajatunnus='käyttäjä2'), 'testimuistio2', 'lisätietoa', 4, '2015-04-23');

insert into luokka (nimi, kayttaja) values ('testiluokka1', (select id from kayttaja where kayttajatunnus='käyttäjä'));
insert into luokka (nimi, kayttaja) values ('testiluokka2', (select id from kayttaja where kayttajatunnus='käyttäjä'));
insert into luokka (nimi, kayttaja) values ('testiluokka3', (select id from kayttaja where kayttajatunnus='käyttäjä2'));

insert into luokat (muistiinpano, luokka) values ((select id from muistiinpano where nimi='testimuistio1'), (select id from luokka where nimi='testiluokka1'));
insert into luokat (muistiinpano, luokka) values ((select id from muistiinpano where nimi='testimuistio1'), (select id from luokka where nimi='testiluokka2'));
insert into luokat (muistiinpano, luokka) values ((select id from muistiinpano where nimi='testimuistio2'), (select id from luokka where nimi='testiluokka3'));