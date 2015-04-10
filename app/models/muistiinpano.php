<?php

  class Muistiinpano extends BaseModel {
    public $id, $nimi, $lisatiedot, $prioriteetti, $lisayspaiva, $kayttaja;
    
    public function __construct($attributes) {
      parent::__construct($attributes);
	  $this->tarkistukset = array('tarkista_nimi', 'tarkista_prioriteetti');
    }

    public static function all() {
      $kysely = DB::connection()->prepare('select * from muistiinpano where kayttaja = :kayttaja');
      $kysely->execute(array('kayttaja' => $_SESSION['kayttaja']));
      $rivit = $kysely->fetchAll();
      $muistiinpanot = array();

      foreach($rivit as $rivi) {
        $muistiinpanot[] = new Muistiinpano(array(
	    'id' => $rivi['id'],
	    'nimi' => $rivi['nimi'],
	    'lisatiedot' => $rivi['lisatiedot'],
	    'prioriteetti' => $rivi['prioriteetti'],
	    'lisayspaiva' => $rivi['lisayspaiva'],
	    'kayttaja' => $rivi['kayttaja']
	    ));
      }

      return $muistiinpanot;
    }

    public static function find($id) {
      $kysely = DB::connection()->prepare('select * from muistiinpano where id = :id limit 1');
      $kysely->execute(array('id' => $id));
      $rivi = $kysely->fetch();

      if($rivi) {
        $muistiinpano = new Muistiinpano(array(
	    'id' => $rivi['id'],
	    'nimi' => $rivi['nimi'],
	    'lisatiedot' => $rivi['lisatiedot'],
	    'prioriteetti' => $rivi['prioriteetti'],
	    'lisayspaiva' => $rivi['lisayspaiva'],
	    'kayttaja' => $rivi['kayttaja'],
	    ));
      }

      return $muistiinpano;
    }
	
	public function save() {
	  $kysely = DB::connection()->prepare('insert into muistiinpano (kayttaja, nimi, lisatiedot, prioriteetti, lisayspaiva) values (:kayttaja, :nimi, :lisatiedot, :prioriteetti, now()) returning id');
	  $kysely->execute(array('kayttaja' => $_SESSION['kayttaja'], 'nimi' => $this->nimi, 'lisatiedot' => $this->lisatiedot, 'prioriteetti' => $this->prioriteetti));
	  $rivi = $kysely->fetch();
	  $this->id = $rivi['id'];
	}
	
	public function tarkista_nimi() {
	  $virheet = array();
	  if($this->nimi == '' || $this->nimi == null) {
	    $virheet[] = 'Muistiinpanolla pitää olla nimi';
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

	public function paivita() {
	  $kysely = DB::connection()->prepare('update muistiinpano set (nimi, lisatiedot, prioriteetti) = (:nimi, :lisatiedot, :prioriteetti) where id = :id');
	  $kysely->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'lisatiedot' => $this->lisatiedot, 'prioriteetti' => $this->prioriteetti));
	  $rivi = $kysely->fetch();
	}

	public function poista() {
	  $kysely = DB::connection()->prepare('delete from muistiinpano where id = :id');
	  $kysely->execute(array('id' => $this->id));
	  $rivi = $kysely->fetch();
	}
  }