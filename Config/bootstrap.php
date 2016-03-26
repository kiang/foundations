<?php
CakePlugin::loadAll();
require App::pluginPath('Permissible') . 'Config/init.php';

Configure::write('Dispatcher.filters', array(
	'CacheDispatcher'
));