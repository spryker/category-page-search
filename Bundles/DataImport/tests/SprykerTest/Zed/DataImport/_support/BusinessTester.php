<?php
namespace SprykerTest\Zed\DataImport;

use Codeception\Actor;
use Spryker\Zed\DataImport\Business\DataImportBusinessFactory;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class BusinessTester extends Actor
{

    use _generated\BusinessTesterActions;

    /**
     * @return \Spryker\Zed\DataImport\Business\DataImportBusinessFactory
     */
    public function getFactory()
    {
        return new DataImportBusinessFactory();
    }

}