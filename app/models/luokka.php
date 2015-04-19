<?php

  class Luokka extends BaseModel {
    public $id, $nimi, $kayttaja;

    public function __construct($attributes) {
      parent::__construct($attributes);
      $this->tarkistukset = array('tarkista_nimi', 'tarkista_nimi2');
    }

    public static function all() {
      $kysely = DB::connection()->prepare('select * from luokka where kayttaja = :kayttaja');
      $kysely->execute(array('kayttaja' => $_SESSION['kayttaja']));
      $rivit = $kysely->fetchAll();
      $luokat = array();

      foreach($rivit as $rivi) {
        $luokat[] = new Luokka(array(
          'id' => $rivi['id'],
          'nimi' => $rivi['nimi'],
          'kayttaja' => $rivi['kayttaja']
        ));
      }

      return $luokat;
    }

    public static function find($id) {
      $kysely = DB::connection()->prepare('select * from luokka where id = :id limit 1');
      $kysely->execute(array('id' => $id));
      $rivi = $kysely->fetch();

      if($rivi) {
        $luokka = new Luokka(array(
          'id' => $rivi['id'],
          'nimi' => $rivi['nimi'],
          'kayttaja' => $rivi['kayttaja']
        ));
      }

      return $luokka;
    }

    public function save() {
      $kysely = DB::connection()->prepare('insert into luokka (nimi, kayttaja) values (:nimi, :kayttaja) returning id');
      $kysely->execute(array('nimi' => $this->nimi, 'kayttaja' => $this->kayttaja));
      $rivi = $kysely->fetch();
      $this->id = $rivi['id'];
    }

    public function tarkista_nimi() {
      $virheet = array();
      if($this->nimi == '' || $this->nimi == null) {
        $virheet[] = 'Luokalla pitää olla nimi';
      }
      return $virheet;
    }

    public function tarkista_nimi2() {
      $virheet = array();
      if(strlen($this->nimi) > 50) {
        $virheet[] = 'Luokan nimen enimmäispituus on 50 merkkiä';
      }
      return $virheet;
    }

    public function paivita() {
      $kysely = DB::connection()->prepare('update luokka set (nimi) = (:nimi) where id = :id');
      $kysely->execute(array('id' => $this->id, 'nimi' => $this->nimi));
      $rivi = $kysely->fetch();
    }

    public function poista() {
      $kysely = DB::connection()->prepare('delete from luokka where id = :id');
      $kysely->execute(array('id' => $this->id));
      $rivi = $kysely->fetch();

      $kysely = DB::connection()->prepare('delete from luokat where luokka = :luokka');
      $kysely->execute(array('luokka' => $this->id));
      $rivi = $kysely->fetch();
    }  
  }