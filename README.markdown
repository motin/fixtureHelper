FixtureHelper for Yii Framework
===============================

FixtureHelper is a command application lets you work with your fixtures outside 
testing. Currently what it does is just helping you to load your fixtures from your
fixture files to your database, without the need to invoke PHPUnit.

INSTALL
-------
Copy FixtureHelperCommand.php and place it under `vendor/sumwai/yii-fixture-helper`

Edit `protected/config/console.php`, add the following to the config array under 
first dimension:

	'commandMap' => array(
		'fixture' => array(
		'class'=>'vendor.sumwai.yii-fixture-helper.FixtureHelperCommand',
		),
	),
	
Configure your database by setting up your db under `components`.

Add the following inside `components`.

    'fixture-helper'      => array(
        'class' => 'vendor.sumwai.yii-fixture-helper.FixtureHelperDbFixtureManager',
    ),

USAGE
--------
  fixture load [--modelPathAlias=folderalias] [--fixturePathAlias=folderalias] --table=tablename1[,tablename2[,...]]

PARAMETERS
--------
  * load: Load fixtures into the database
  * --modelPathAlias: The alias to the directory that contains the "model" folder
	Please note that folder "models" should contain the Model class of
	the fixtures to be loaded. Defaults to "application.models". Optional for "load".
  * --fixturePathAlias: The alias to the "fixtures" directory
  * --tables: Name of the tables to be loaded with your defined fixtures. Name
	values are comma separated. Required for "load".

EXAMPLES
--------
  yiic fixture load --modelPathAlias=application.modules.mymodule.models --fixturePathAlias=application.modules.mymodule.tests.fixtures --tables=fruit,transport,country
