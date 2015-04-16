<?php

  function check_logged_in() {
    BaseController::check_logged_in();
  }

  $routes->get('/', 'check_logged_in', function() {
    MuistiinpanoController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/suunnitelmat/lista', function() {
	HelloWorldController::lista();
  });
  
  $routes->get('/suunnitelmat/tiedot/1', function() {
	HelloWorldController::tiedot();
  });
  
  $routes->get('/suunnitelmat/muokkaa/1', function() {
	HelloWorldController::muokkaa();
  });
  
  $routes->get('/suunnitelmat/kirjautuminen', function() {
	HelloWorldController::kirjautuminen();
  });
  
  $routes->get('/muistiinpanot', 'check_logged_in', function() {
	MuistiinpanoController::index();
  });
  
  $routes->post('/muistiinpano', 'check_logged_in', function() {
    MuistiinpanoController::store();
  });

  $routes->get('/muistiinpano/uusi', 'check_logged_in', function() {
    MuistiinpanoController::uusi();
  });
  
  $routes->get('/muistiinpano/:id', 'check_logged_in', function($id) {
	MuistiinpanoController::show($id);
  });

  $routes->get('/muistiinpano/:id/muokkaa', 'check_logged_in', function($id) {
    MuistiinpanoController::muokkaa($id);
  });

  $routes->post('/muistiinpano/:id/muokkaa', 'check_logged_in', function($id) {
    MuistiinpanoController::paivita($id);
  });

  $routes->post('/muistiinpano/:id/poista', 'check_logged_in', function($id) {
    MuistiinpanoController::poista($id);
  });

  $routes->get('/kirjautuminen', function() {
    KayttajaController::kirjautuminen();
  });

  $routes->post('/kirjautuminen', function() {
    KayttajaController::kasittele_kirjautuminen();
  });

  $routes->post('/kirjaudu_ulos', function() {
    KayttajaController::kirjaudu_ulos();
  });