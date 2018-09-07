<?php
/**
 * Research plugin for Craft CMS 3.x
 *
 * Extending the native Craft search
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\research\services;

use ournameismud\research\Research;
use ournameismud\research\records\Log AS LogRecord;

use Craft;
use craft\base\Component;

/**
 * @author    @cole007
 * @package   Research
 * @since     1.0.0
 */
class Log extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function get($criteria = null)
    {
        $logs = ($criteria) ? LogRecord::find()->where( $criteria ) : LogRecord::find();
        $logs->orderBy('dateUpdated desc');
        return $logs->all();
    }
    public function save( $criteria )
    {
        $site = Craft::$app->getSites()->getCurrentSite();
        $user = Craft::$app->getUser();

        $log = new LogRecord;
        
        foreach ($criteria AS $key => $value) {
            $log->$key = $value;
        }
        $log->siteId = $site->id;
        $log->context = Craft::$app->getRequest()->getPathInfo();
        $log->ip_address = Craft::$app->getRequest()->getUserIP();
        if ($user) $log->ownerId = $user->id;
        if( $log->save() ) return true;
        return false;
    }
}
