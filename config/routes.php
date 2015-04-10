<?php

  $routes->get('/', function() {
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
  
  $routes->get('/muistiinpanot', function() {
	MuistiinpanoController::index();
  });
  
  $routes->post('/muistiinpano', function() {
    MuistiinpanoController::store();
  });

  $routes->get('/muistiinpano/uusi', function() {
    MuistiinpanoController::uusi();
  });
  
  $routes->get('/muistiinpano/:id', function($id) {
	MuistiinpanoController::show($id);
  });

  $routes->get('/muistiinpano/:id/muokkaa', function($id) {
    MuistiinpanoController::muokkaa($id);
  });

  $routes->post('/muistiinpano/:id/muokkaa', function($id) {
    MuistiinpanoController::paivita($id);
  });

  $routes->post('/muistiinpano/:id/poista', function($id) {
    MuistiinpanoController::poista($id);
  });

  $routes->get('/kirjautuminen', function() {
    KayttajaController::kirjautuminen();
  });

  $routes->post('/kirjautuminen', function() {
    KayttajaController::kasittele_kirjautuminen();
  });