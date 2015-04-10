<?php

  class Kayttaja extends BaseModel {
      public $id, $kayttajatunnus, $salasana;

      public function __construct($attributes) {
        parent::__construct($attributes);
      }

      public static function tarkista($kayttajatunnus, $salasana) {
        $kysely = DB::connection()->prepare('select * from kayttaja where kayttajatunnus = :kayttajatunnus and salasana = :salasana limit 1');
        $kysely->execute(array('kayttajatunnus' => $kayttajatunnus, 'salasana' => $salasana));
        $rivi = $kysely->fetch();

        if($rivi) {
          return new Kayttaja(array(
            'id' => $rivi['id'],
            'kayttajatunnus' => $rivi['kayttajatunnus'],
            'salasana' => $rivi['salasana']
          ));
        } else {
          return null;
        }
      }

      public static function find($id) {
        $kysely = DB::connection()->prepare('select * from kayttaja where id = :id limit 1');
        $kysely->execute(array('id' => $id));
        $rivi = $kysely->fetch();

        if ($rivi) {
          $kayttaja = new Kayttaja(array(
            'id' => $rivi['id'],
            'kayttajatunnus' => $rivi['kayttajatunnus'],
            'salasana' => $rivi['salasana']
            ));
        }
        return $kayttaja;
      }
    }