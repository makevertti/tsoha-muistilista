<?php

  class Muistiinpano extends BaseModel {
    public $id, $nimi, $lisatiedot, $prioriteetti, $lisayspaiva, $kayttaja;
    
   public function __construct($attributes) {
     parent::__construct($attributes);
   }

    public static function all() {
      $kysely = DB::connection()->prepare('select * from muistiinpano');
      $kysely->execute();
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
  }
