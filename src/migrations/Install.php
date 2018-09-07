<?php
/**
 * Research plugin for Craft CMS 3.x
 *
 * Extending the native Craft search
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\research\migrations;

use ournameismud\research\Research;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * @author    @cole007
 * @package   Research
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            $this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

   /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%research_log}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%research_log}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                    'siteId' => $this->integer()->notNull(),
                    'ownerId' => $this->integer(),
                    'results' => $this->integer(),
                    'ip_address' => $this->string(16)->defaultValue(''),
                    'type' => $this->string(16)->defaultValue(''),
                    'context' => $this->string(255)->defaultValue(''),
                    'q' => $this->string(150)->notNull()->defaultValue(''),
                    'filters' => $this->text()
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        $this->createIndex(null, '{{%research_log}}', ['siteId'], false);
        $this->createIndex(null, '{{%research_log}}', ['ownerId'], false);        
    }

    /**
     * @return void
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey(null, '{{%research_log}}', ['siteId'], '{{%sites}}', ['id'], 'CASCADE', null);
        $this->addForeignKey(null, '{{%research_log}}', ['ownerId'], '{{%users}}', ['id'], 'CASCADE', null);
    }

    /**
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * @return void
     */
    protected function removeTables()
    {
        $this->dropTableIfExists('{{%research_log}}');
    }
}
