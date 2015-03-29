<?php

  $routes->get('/', function() {
    MuistiinpanoController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/lista', function() {
	HelloWorldController::lista();
  });
  
  $routes->get('/tiedot/1', function() {
	HelloWorldController::tiedot();
  });
  
  $routes->get('/muokkaa/1', function() {
	HelloWorldController::muokkaa();
  });
  
  $routes->get('/kirjautuminen', function() {
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