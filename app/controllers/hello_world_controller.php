<?php

  class HelloWorldController extends BaseController{

    public static function index() {
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
	  View::make('suunnitelmat/index.html');
    }

    public static function sandbox() {
      // Testaa koodiasi täällä
	  $muistiinpano = Muistiinpano::find(1);
	  $muistiinpanot = Muistiinpano::all();

	  Kint::dump($muistiinpano);
	  Kint::dump($muistiinpanot);
    }
	
	public static function lista() {
	  View::make('suunnitelmat/lista.html');
	}
	
	public static function tiedot() {
	  View::make('suunnitelmat/tiedot.html');
	}
	
	public static function muokkaa() {
	  View::make('suunnitelmat/muokkaa.html');
	}
	
	public static function kirjautuminen() {
	  View::make('suunnitelmat/kirjautuminen.html');
	}
  }
