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
	  $muistiinpano = new Muistiinpano(array(
	    'nimi' => $params['nimi'],
		'lisatiedot' => $params['lisatiedot'],
		'prioriteetti' => (int)$params['prioriteetti']
	  ));
      $muistiinpano->save();
      Redirect::to('/muistiinpano/' . $muistiinpano->id, array('message' => 'muistiinpano lisätty'));
	}
	
	public static function uusi() {
	  View::make('muistiinpano/uusi.html');
	}
  }