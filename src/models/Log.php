<?php
/**
 * Research plugin for Craft CMS 3.x
 *
 * Extending the native Craft search
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\research\models;

use ournameismud\research\Research;

use Craft;
use craft\base\Model;

/**
 * @author    @cole007
 * @package   Research
 * @since     1.0.0
 */
class Log extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $member,
        $results,
        $ip_address,
        $q;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerId','results'], 'number'],
            ['filters', 'mixed'],
            [['ip_address','q','type','context'], 'string'],
        ];
    }
}
