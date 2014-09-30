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

namespace GoogleUniversalAnalytics\Measurement;


/**
 * Class Transaction
 * @package GoogleUniversalAnalytics\Measurement
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class Transaction extends BaseMeasurement
{
    public function __construct()
    {
        parent::__construct();

        $this->data['t'] = 'transaction';
    }
}
