<?php

  class MuistiinpanoController extends BaseController {
    public static function index() {
      $muistiinpanot = Muistiinpano::all();
      View::make('muistiinpano/index.html', array('muistiinpanot' => $muistiinpanot));
    }
	
	public static function show($id) {
	  $muistiinpano = Muistiinpano::find($id);
	  View::make('muistiinpano/tiedot.html', array('muistiinpano' => $muistiinpano));
	}
	
	public static function store() {
	  $params = $_POST;
	  $luokat = $params['luokat'];
	  $parametrit = array(
		'nimi' => $params['nimi'],
		'lisatiedot' => $params['lisatiedot'],
		'prioriteetti' => (int)$params['prioriteetti'],
		'kayttaja' => $_SESSION['kayttaja'],
		'luokat' => array()
	  );
	  foreach($luokat as $luokka) {
		$parametrit['luokat'][] = $luokka;
	  }

	  $muistiinpano = new Muistiinpano($parametrit);
	  $virheet = $muistiinpano->errors();

	  if(count($virheet) == 0) {
	    $muistiinpano->save();
	    Redirect::to('/muistiinpano/' . $muistiinpano->id, array('viesti' => 'Muistiinpano lisätty'));
	  } else {
		View::make('muistiinpano/uusi.html', array('virheet' => $virheet, 'parametrit' => $parametrit));
	  }
	}
	
	public static function uusi() {
	  $luokat = Luokka::all();
	  View::make('muistiinpano/uusi.html', array('luokat' => $luokat));
	}

	public static function muokkaa($id) {
	  $muistiinpano = Muistiinpano::find($id);
	  $luokat = Luokka::all();
	  View::make('muistiinpano/muokkaa.html', array('muistiinpano' => $muistiinpano, 'luokat' => $luokat));
	}

	public static function paivita($id) {
	  $params = $_POST;
	  $luokat = $params['luokat'];
	  $parametrit = array(
		'id' => $id,
		'nimi' => $params['nimi'],
		'lisatiedot' => $params['lisatiedot'],
		'prioriteetti' => $params['prioriteetti'],
		'kayttaja' => $_SESSION['kayttaja'],
		'luokat' => array()
	  );
	  foreach($luokat as $luokka) {
		$parametrit['luokat'][] = $luokka;
	  }

	  $muistiinpano = new Muistiinpano($parametrit);
	  $virheet = $muistiinpano->errors();

	  if(count($virheet) == 0) {
		$muistiinpano->paivita();
		Redirect::to('/muistiinpano/' . $muistiinpano->id, array('viesti' => 'Muutokset tallennettu'));
	  } else {
		View::make('muistiinpano/muokkaa.html', array('virheet' => $virheet, 'muistiinpano' => $muistiinpano));
	  }
	}

	public static function poista($id) {
	  $muistiinpano = new Muistiinpano(array('id' => $id));
	  $muistiinpano->poista();
	  Redirect::to('/muistiinpanot', array('viesti' => 'Muistiinpano poistettu'));
	}
  }