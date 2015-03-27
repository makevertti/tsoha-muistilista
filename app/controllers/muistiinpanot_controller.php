<?php

  class MuistiinpanoController extends BaseController {
    public static function index() {
      $muistiinpanot = Muistiinpano::all();
      View::make('muistiinpano/index.html', array('muistiinpanot' => $muistiinpanot));
    }
	
	public static function show($id) {
	  $muistiinpano = Muistiinpano::find($id);
	  $muistiinpanoTaulukossa = array($muistiinpano);
	  View::make('muistiinpano/tiedot.html', $muistiinpanoTaulukossa);
	}
  }
