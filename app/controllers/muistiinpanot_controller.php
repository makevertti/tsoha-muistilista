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
		$luokat = Luokka::all();
		$valitut = $muistiinpano->luokat;
		View::make('muistiinpano/uusi.html', array('virheet' => $virheet, 'parametrit' => $parametrit, 'luokat' => $luokat, 'valitut' => $valitut));
	  }
	}
	
	public static function uusi() {
	  $luokat = Luokka::all();
	  View::make('muistiinpano/uusi.html', array('luokat' => $luokat));
	}

	public static function muokkaa($id) {
	  $muistiinpano = Muistiinpano::find($id);
	  $luokat = Luokka::all();
	  $muistiinpanon_luokat = array();
	  foreach($muistiinpano->luokat as $luokka) {
	    $muistiinpanon_luokat[] = $luokka->id;
	  }
	  View::make('muistiinpano/muokkaa.html', array('muistiinpano' => $muistiinpano, 'luokat' => $luokat, 'muistiinpanon_luokat' => $muistiinpanon_luokat));
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
		$luokat = Luokka::all();
		$muistiinpanon_luokat = array();
		foreach($muistiinpano->luokat as $luokka) {
		  $muistiinpanon_luokat[] = $luokka;
		}
		View::make('muistiinpano/muokkaa.html', array('virheet' => $virheet, 'muistiinpano' => $muistiinpano, 'luokat' => $luokat, 'muistiinpanon_luokat' => $muistiinpanon_luokat));
	  }
	}

	public static function poista($id) {
	  $muistiinpano = new Muistiinpano(array('id' => $id));
	  $muistiinpano->poista();
	  Redirect::to('/muistiinpanot', array('viesti' => 'Muistiinpano poistettu'));
	}
  }