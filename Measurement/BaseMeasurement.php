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

use GoogleUniversalAnalytics\GoogleUniversalAnalytics;
use Thelia\Model\ConfigQuery;

/**
 * Class BaseMeasurement
 * @package GoogleUniversalAnalytics\Measurement
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class BaseMeasurement
{
    const ANALYTICS_URL = "https://ssl.google-analytics.com/collect";

    protected $data = [];

    public function __construct()
    {
        $this->data['v'] = 1;
        $this->data['tid'] = ConfigQuery::read(GoogleUniversalAnalytics::ANALYTICS_UA);
    }

    public function add($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function send()
    {
        $ch = curl_init(self::ANALYTICS_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->getData()));
        curl_setopt($ch, CURLOPT_USERAGENT, "Thelia GoogleUniversalAnalytics");

        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_status;
    }
}
