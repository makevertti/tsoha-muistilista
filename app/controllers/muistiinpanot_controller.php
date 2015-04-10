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
	  $parametrit = array(
		'nimi' => $params['nimi'],
		'lisatiedot' => $params['lisatiedot'],
		'prioriteetti' => (int)$params['prioriteetti']
	  );
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
	  View::make('muistiinpano/uusi.html');
	}

	public static function muokkaa($id) {
	  $muistiinpano = Muistiinpano::find($id);
	  View::make('muistiinpano/muokkaa.html', array('muistiinpano' => $muistiinpano));
	}

	public static function paivita($id) {
	  $params = $_POST;

	  $parametrit = array(
		'id' => $id,
		'nimi' => $params['nimi'],
		'lisatiedot' => $params['lisatiedot'],
		'prioriteetti' => $params['prioriteetti'],
		'kayttaja' => $_SESSION['kayttaja']
	  );

	  $muistiinpano = new Muistiinpano($parametrit);
	  $virheet = $muistiinpano->errors();

	  if(count($virheet) == 0) {
		$muistiinpano->paivita();
		Redirect::to('/muistiinpano/' . $muistiinpano->id, array('viesti' => 'Muutokset tallennettu'));
	  } else {
		View::make('muistiinpano/muokkaa.html', array('virheet' => $virheet, 'parametrit' => $parametrit));
	  }
	}

	public static function poista($id) {
	  $muistiinpano = new Muistiinpano(array('id' => $id));
	  $muistiinpano->poista();
	  Redirect::to('/muistiinpanot', array('viesti' => 'Muistiinpano poistettu'));
	}
  }