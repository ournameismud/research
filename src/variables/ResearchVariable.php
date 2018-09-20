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
    public function get($term, $criteria = null, $type = 'entries')
    {
        if(is_array($term) && array_key_exists('search', $term)) {
            $q = $term['search'];
        } elseif(is_string($term)) {
            $q = $term;
        } else {
            $q = '';    
        }
        
        switch ($type) {
            case 'assets':
                $ids = Entry::find();
            break;
            case 'categories':
                $ids = Category::find();
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
        if ($criteria) {
            foreach ($criteria AS $key => $value) {
                $ids->$key = $value;    
            }
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
