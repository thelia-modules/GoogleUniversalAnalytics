<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace GoogleUniversalAnalytics;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;
use Thelia\Model\ConfigQuery;
use Thelia\Module\BaseModule;

class GoogleUniversalAnalytics extends BaseModule
{
    const ANALYTICS_UA = 'analytics_UA';
    /*
     * You may now override BaseModuleInterface methods, such as:
     * install, destroy, preActivation, postActivation, preDeactivation, postDeactivation
     *
     * Have fun !
     */

    public function postActivation(ConnectionInterface $con = null)
    {
        if (null === ConfigQuery::read(self::ANALYTICS_UA)) {
            ConfigQuery::write(self::ANALYTICS_UA, '', 1, 1);
        }

        $database = new Database($con);

        $database->insertSql(null, array(__DIR__ . '/Config/thelia.sql'));
    }
}
