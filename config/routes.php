<?php

  $routes->get('/', function() {
    HelloWorldController::index();
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
