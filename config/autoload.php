<?php 
   /*  HELPERS */
   AppLoader::load_helper('_');
   AppLoader::load_helper('String');
   AppLoader::load_helper('Number');
   AppLoader::load_helper('Time');
   AppLoader::load_helper('Array');
   AppLoader::load_helper('Session');
   AppLoader::load_helper('Sql');
   AppLoader::load_helper('Html');
   AppLoader::load_helper('Route');

    /* LIBS**/
   AppLoader::load('db/DB');
   AppLoader::load('parsers/CSV');
   AppLoader::load('parsers/JSON');
   AppLoader::load('logger/Logger');
   AppLoader::load('formatters/Markdown');
   AppLoader::load('menu/MenuFactory');
   
   AppLoader::load_config('constants');
   
   AppLoader::load_model('TBaseModel');
   
   AppLoader::load('Vista');
   
   AppLoader::load('app/AppContext');
   AppLoader::load('app/Config');
   AppLoader::load('app/AppConfig');
   AppLoader::load('app/ModuleConfig');
   
   AppLoader::load('app/AppUser');
   AppLoader::load('app/WebRequest');
 
   AppLoader::load('app/AppDispatcher');
?>
