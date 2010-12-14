FixtureHelper for Yii Framework
===============================

FixtureHelper is a command application lets you work with your fixtures outside 
testing. Currently what it does is just helping you to load you fixtures from your
fixture files to your database, without the need to invoke PHPUnit.

INSTALL
-------
Copy FixtureHelperCommand.php and place it under `protected/extensions/fixtureHelper/`

Edit `protected/config/console.php`, add the following to the config array under 
first dimension:

	'commandMap' => array(
		'fixture' => array(
		'class'=>'application.extensions.fixtureHelper.FixtureHelperCommand',
		),
	),
	
Configure your database by setting up your db under `components`.

Add the following inside `components`.

	'fixture'=>array(
		'class'=>'system.test.CDbFixtureManager',
	),

USAGE
------
fixture [load]

PARAMETERS
-----------
* load: Load fixtures into the database
* --alias: The alias to the directory that contains "models" and "tests" 
  folders. Please note that folder "models" should contain the Model class of 
  the fixtures to be loaded. Defaults to "application". Optional for "load".
* --tables: Name of the tables to be loaded with your defined fixtures. Name  
  values are comma separated. Required for "load".  
  
EXAMPLES
--------

	yiic fixture load --alias=application.modules.mymodule --tables=fruit,transport,country