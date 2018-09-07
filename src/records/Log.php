<?php
/**
 * Research plugin for Craft CMS 3.x
 *
 * Extending the native Craft search
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\research\records;

use ournameismud\research\Research;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    @cole007
 * @package   Research
 * @since     1.0.0
 */
class Log extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%research_log}}';
    }
}
