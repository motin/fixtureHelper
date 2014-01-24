<?php

/**
 * FixtureHelper is a command application lets you work with your fixtures outside
 * testing. Currently what it does is just helping you to load you fixtures from your
 * fixture files to your database, without the need to invoke PHPUnit.
 *
 * @author    Sum-Wai Low
 * @author    Fredrik Wollsén <fredrik@neam.se>
 * @link      https://github.com/sumwai/fixtureHelper
 * @copyright Copyright &copy; 2010 Sum-Wai Low, Fredrik Wollsén <fredrik@neam.se>
 */
class FixtureHelperCommand extends CConsoleCommand
{

    /**
     * @var string
     */
    public $defaultModelPathAlias = 'application.models';

    /**
     * @var string
     */
    public $defaultFixturePathAlias = 'application.tests.fixtures';

    private $fixture;

    function getHelp()
    {
        return <<<EOD
USAGE
  fixture load [--modelPathAlias=folderalias] [--fixturePathAlias=folderalias] --table=tablename1[,tablename2[,...]]
	
DESCRIPTION
  This command lets you work with your fixtures outside testing
	
PARAMETERS
  * load: Load fixtures into the database
  * --modelPathAlias: The alias to the directory that contains the "model" folder
	Please note that folder "models" should contain the Model class of
	the fixtures to be loaded. Defaults to "application.models". Optional for "load".
  * --fixturePathAlias: The alias to the "fixtures" directory
  * --tables: Name of the tables to be loaded with your defined fixtures. Name
	values are comma separated. Required for "load".  
	
EXAMPLES
  yiic fixture load --modelPathAlias=application.modules.mymodule.models --fixturePathAlias=application.modules.mymodule.tests.fixtures --tables=fruit,transport,country


EOD;
    }

    /**
     * Loads fixtures into the database tables from fixtures.
     *
     * @param string $fixturePathAlias alias to the "fixtures" directory
     * @param string $tables comma separated value of table names that should be loaded with fixtures,
     *                       or '*' if all fixtures should be loaded. Also calling actionLoad() without any arguments
     *                       is possible to load all fixtures.
     */
    function actionLoad($tables = '*', $modelPathAlias = null, $fixturePathAlias = null)
    {
        if (is_null($modelPathAlias)) {
            $modelPathAlias = $this->defaultModelPathAlias;
        }
        if (is_null($fixturePathAlias)) {
            $fixturePathAlias = $this->defaultFixturePathAlias;
        }
        Yii::import($modelPathAlias . '.*');
        $this->fixture = Yii::app()->getComponent('fixture');
        $this->fixture->basePath = Yii::getPathOfAlias($fixturePathAlias);
        $this->fixture->init();
        $this->fixture->checkIntegrity(false);
        if ($tables === '*') {
            $this->fixture->prepare();
        } else {
            $tables = explode(',', $tables);

            foreach ($tables as $table) {
                try {
                    $this->fixture->resetTable($table);
                    $this->fixture->loadFixture($table);
                } catch (Exception $e) {
                    echo "ERROR: There is a problem working with the table $table. " . "Is it spelled correctly or exist?\n\n";
                }
            }
        }
        $this->fixture->checkIntegrity(true);
        echo "Done.\n\n";
    }

}