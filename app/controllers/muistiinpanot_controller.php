<?php

  class MuistiinpanoController extends BaseController {
    public static function index() {
      $muistiinpanot = Muistiinpano::all();
      View::make('muistiinpano/index.html', array('muistiinpanot' => $muistiinpanot));
    }
  }
