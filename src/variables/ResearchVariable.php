<?php
/**
 * Research plugin for Craft CMS 3.x
 *
 * Extending the native Craft search
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\research\variables;

use ournameismud\research\Research;

use Craft;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\MatrixBlock;
use craft\elements\Tag;
use craft\elements\User;

/**
 * @author    @cole007
 * @package   Research
 * @since     1.0.0
 */
class ResearchVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param null $optional
     * @return string
     */
    public function get($criteria = null, $type = 'entries')
    {
        if(is_array($criteria) && array_key_exists('search', $criteria)) {
            $q = $criteria['search'];
        } elseif(is_string($criteria)) {
            $q = $criteria;
        } else {
            $q = '';    
        }
        
        switch ($type) {
            case 'assets':
                $ids = Entry::find();
            break;
            case 'categories':
                $ids = Entry::find();
            break;
            case 'entries':
                $ids = Entry::find(); 
            break;
            case 'matrix':
                $ids = Entry::find(); 
            break;
            case 'tags':
                $ids = Entry::find(); 
            break;
            case 'users':
                $ids = Entry::find(); 
            break;
        }
        
        $ids->search($q)
            ->orderBy('score')
            ->all(); 
        Research::getInstance()->log->save( array(
            'q' => $q, 
            'results' => count($ids), 
            'type' => $type 
        ) );
        return $ids;        
    }
    public function logs($criteria = null)
    {
        $logs = Research::getInstance()->log->get($criteria);
        return $logs;
    }

}
