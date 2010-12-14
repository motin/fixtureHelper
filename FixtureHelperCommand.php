<?php
/**
 * FixtureHelper is a command application lets you work with your fixtures outside 
 * testing. Currently what it does is just helping you to load you fixtures from your
 * fixture files to your database, without the need to invoke PHPUnit.
 * 
 * @author Sum-Wai Low
 * @link https://github.com/sumwai/fixtureHelper
 * @copyright Copyright &copy; 2010 Sum-Wai Low
 */
class FixtureHelperCommand extends CConsoleCommand {
	private $fixture;
	function getHelp() {
		return <<<EOD
USAGE
  fixture load [--alias=folderalias] --table=tablename1[,tablename2[,...]]
	
DESCRIPTION
  This command lets you work with your fixtures outside testing
	
PARAMETERS
  * load: Load fixtures into the database
  * --alias: The alias to the directory that contains "models" and "tests" 
	folders. Please note that folder "models" should contain the Model class of 
	the fixtures to be loaded. Defaults to "application". Optional for "load".
  * --tables: Name of the tables to be loaded with your defined fixtures. Name  
	values are comma separated. Required for "load".  
	
EXAMPLES
  yiic fixture load --alias=application.modules.mymodule --tables=fruit,transport,country


EOD;
	}
	
	/**
	 * Loads fixtures into the database tables from fixtures.
	 * @param string $alias alias to the path that contains both models and tests folders
	 * @param string $tables comma separated value of table names that should be loaded with fixtures
	 */
	function actionLoad($tables, $alias='application'){
		Yii::import($alias.'.models.*');
		$this->fixture = Yii::app()->getComponent('fixture');
		$this->fixture->basePath = Yii::getPathOfAlias($alias.'.tests.fixtures');
		$this->fixture->init();
		
		$tables = explode(',', $tables);
		foreach ($tables as $table) {
			try {
				$this->fixture->resetTable($table);
				$this->fixture->loadFixture($table);		
			} catch (Exception $e) {
				echo "ERROR: There is a problem working with the table $table. ".
					"Is it spelled correctly or exist?\n\n";
			}
		}
		echo "Done.\n\n";
	}

}