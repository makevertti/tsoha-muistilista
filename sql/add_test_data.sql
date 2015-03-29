insert into kayttaja (kayttajatunnus, salasana) values ('testaaja1', 'salasana1');
insert into kayttaja (kayttajatunnus, salasana) values ('testaaja2', 'salasana2');

insert into muistiinpano (kayttaja, nimi, lisatiedot, prioriteetti, lisayspaiva) values ((select id from kayttaja where kayttajatunnus='testaaja1'), 'testimuistio1', 'kuvaus', 5, now());
insert into muistiinpano (kayttaja, nimi, lisatiedot, prioriteetti, lisayspaiva) values ((select id from kayttaja where kayttajatunnus='testaaja2'), 'testimuistio2', 'lisätietoa', 4, now());

insert into luokka (nimi) values ('testiluokka1');
insert into luokka (nimi) values ('testiluokka2');

insert into luokat (muistiinpano, luokka) values ((select id from muistiinpano where nimi='testimuistio1'), (select id from luokka where nimi='testiluokka1'));
insert into luokat (muistiinpano, luokka) values ((select id from muistiinpano where nimi='testimuistio2'), (select id from luokka where nimi='testiluokka1'));
insert into luokat (muistiinpano, luokka) values ((select id from muistiinpano where nimi='testimuistio2'), (select id from luokka where nimi='testiluokka2'));