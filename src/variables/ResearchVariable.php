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
    public $searchField = 'searchBoost';
    public $scoreBoost = 50;
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
        
        $results = [];
        // foreach ($ids->searchScores AS )
        foreach($ids AS $id) {
            // do weighted search here
            $searchField = $this->searchField;
            if ($id->$searchField) {
                foreach ($id->$searchField->all() AS $tag) {
                    $keywords = $tag->keywords;
                    $score = $tag->score;
                    foreach($keywords AS $keyword) {                        
                        if (strpos($keyword, strtolower($term)) !== false) {
                            $id->searchScore += $score;
                        } 
                    }                    
                }                
            }
            $tmp = [];
            $tmp['id'] = $id->id;
            $tmp['title'] = $id->title;
            $tmp['class'] = $type;
            if ($type == 'entries') $tmp['type'] = $id->type;
            elseif ($type == 'categories') $tmp['type'] = $id->group->handle;
            $tmp['product_preview'] = $id->product_preview;
            $tmp['searchScore'] = $id->searchScore;
            $tmp['url'] = $id->url;
            $results[] = $tmp;
        }
        usort($results, function($a, $b) {
            if ($a['searchScore'] == $b['searchScore']) {
                return 0;
            }
            return ($a['searchScore'] > $b['searchScore']) ? -1 : 1;
        });
        
        Research::getInstance()->log->save( array(
            'q' => $q, 
            'results' => count($ids), 
            'type' => $type 
        ) );
        return $results;
    }
    public function logs($criteria = null)
    {
        $logs = Research::getInstance()->log->get($criteria);
        return $logs;
    }

}
