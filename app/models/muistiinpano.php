<?php

  class Muistiinpano extends BaseModel {
    public $id, $nimi, $lisatiedot, $prioriteetti, $lisayspaiva, $kayttaja, $luokat;
    
    public function __construct($attributes) {
      parent::__construct($attributes);
	  $this->tarkistukset = array('tarkista_nimi', 'tarkista_nimi2', 'tarkista_prioriteetti', 'tarkista_kuvaus');
    }

    public static function all() {
      $kysely = DB::connection()->prepare('select * from muistiinpano where kayttaja = :kayttaja');
      $kysely->execute(array('kayttaja' => $_SESSION['kayttaja']));
      $rivit = $kysely->fetchAll();
      $muistiinpanot = array();
	  $luokat = array();

      foreach($rivit as $rivi) {
		$luokkakysely = DB::connection()->prepare('select luokka.id, luokka.nimi from muistiinpano, luokka, luokat where luokat.muistiinpano = muistiinpano.id and luokat.luokka = luokka.id and muistiinpano.nimi = :nimi');
		$luokkakysely->execute(array('nimi' => $rivi['nimi']));
		$luokkarivit = $luokkakysely->fetchAll();
		foreach($luokkarivit as $luokkarivi) {
		  $luokat[] = new Luokka(array(
		  'id' => $luokkarivi['id'],
		  'nimi' => $luokkarivi['nimi']
		  ));
		}

        $muistiinpanot[] = new Muistiinpano(array(
	    'id' => $rivi['id'],
	    'nimi' => $rivi['nimi'],
	    'lisatiedot' => $rivi['lisatiedot'],
	    'prioriteetti' => $rivi['prioriteetti'],
	    'lisayspaiva' => $rivi['lisayspaiva'],
	    'kayttaja' => $rivi['kayttaja'],
		'luokat' => $luokat
	    ));
	  }
      return $muistiinpanot;
    }

    public static function find($id) {
      $kysely = DB::connection()->prepare('select * from muistiinpano where id = :id limit 1');
      $kysely->execute(array('id' => $id));
      $rivi = $kysely->fetch();

	  $luokkakysely = DB::connection()->prepare('select luokka.id, luokka.nimi from muistiinpano, luokka, luokat where luokat.muistiinpano = muistiinpano.id and luokat.luokka = luokka.id and muistiinpano.nimi = :nimi');
	  $luokkakysely->execute(array('nimi' => $rivi['nimi']));
	  $luokkarivit = $luokkakysely->fetchAll();
	  $luokat = array();
	  foreach($luokkarivit as $luokkarivi) {
		$luokat[] = new Luokka(array(
		'id' => $luokkarivi['id'],
		'nimi' => $luokkarivi['nimi']
		));
	  }

      if($rivi) {
        $muistiinpano = new Muistiinpano(array(
	    'id' => $rivi['id'],
	    'nimi' => $rivi['nimi'],
	    'lisatiedot' => $rivi['lisatiedot'],
	    'prioriteetti' => $rivi['prioriteetti'],
	    'lisayspaiva' => $rivi['lisayspaiva'],
	    'kayttaja' => $rivi['kayttaja'],
		'luokat' => $luokat
	    ));
      }

      return $muistiinpano;
    }
	
	public function save() {
	  $kysely = DB::connection()->prepare('insert into muistiinpano (kayttaja, nimi, lisatiedot, prioriteetti, lisayspaiva) values (:kayttaja, :nimi, :lisatiedot, :prioriteetti, now()) returning id');
	  $kysely->execute(array('kayttaja' => $_SESSION['kayttaja'], 'nimi' => $this->nimi, 'lisatiedot' => $this->lisatiedot, 'prioriteetti' => $this->prioriteetti));
	  $rivi = $kysely->fetch();
	  $this->id = $rivi['id'];

	  $luokat =$this->luokat;
	  foreach($luokat as $luokka) {
		$luokkakysely = DB::connection()->prepare('insert into luokat (luokka, muistiinpano) values (:luokka, :muistiinpano)');
		$luokkakysely->execute(array('luokka' => $luokka->id, 'muistiinpano' => $this->id));
		$rivi = $kysely->fetch();
		$this->id = $rivi['id'];
	  }
	}
	
	public function tarkista_nimi() {
	  $virheet = array();
	  if($this->nimi == '' || $this->nimi == null) {
	    $virheet[] = 'Muistiinpanolla pitää olla nimi';
	  }
	  return $virheet;
	}

	public function tarkista_nimi2() {
	  $virheet = array();
	  if(strlen($this->nimi) > 50) {
	  	$virheet[] = 'Muistiinpanon nimen enimmäispituus on 50 merkkiä';
	  }
	  return $virheet;
	}
	
	public function tarkista_prioriteetti() {
	  $virheet = array();
	  if($this->prioriteetti < 1 || $this->prioriteetti > 5) {
		$virheet[] = 'Prioriteetin on oltava välillä 1-5';
	  }
	  return $virheet;
	}

	public function tarkista_kuvaus() {
	  $virheet = array();
	  if(strlen($this->lisatiedot) > 500) {
		$virheet[] = 'Kuvauksen enimmäispituus on 500 merkkiä';
	  }
	  return $virheet;
	}

	public function paivita() {
	  $kysely = DB::connection()->prepare('update muistiinpano set (nimi, lisatiedot, prioriteetti) = (:nimi, :lisatiedot, :prioriteetti) where id = :id');
	  $kysely->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'lisatiedot' => $this->lisatiedot, 'prioriteetti' => $this->prioriteetti));
	  $rivi = $kysely->fetch();

	  $tyhjenna_luokat = DB::connection()->prepare('delete from luokat where muistiinpano = :muistiinpano');
	  $tyhjenna_luokat->execute(array('muistiinpano' => $this->id));
	  $rivi = $kysely->fetch();

	  $luokat =$this->luokat;
	  foreach($luokat as $luokka) {
		$luokkakysely = DB::connection()->prepare('insert into luokat (luokka, muistiinpano) values (:luokka, :muistiinpano)');
		$luokkakysely->execute(array('luokka' => $luokka->id, 'muistiinpano' => $this->id));
		$rivi = $kysely->fetch();
	  }
	}

	public function poista() {
	  $kysely = DB::connection()->prepare('delete from muistiinpano where id = :id');
	  $kysely->execute(array('id' => $this->id));
	  $rivi = $kysely->fetch();

	  $luokkakysely = DB::connection()->prepare('delete from luokat where muistiinpano = :muistiinpano');
	  $luokkakysely->execute(array('muistiinapno' => $this->id));
	  $rivi = $kysely->fetch();
	}
  }