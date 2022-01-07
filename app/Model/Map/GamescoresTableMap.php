<?php

namespace Map;

use \Gamescores;
use \GamescoresQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'gamescores' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class GamescoresTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.GamescoresTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'gamescores';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Gamescores';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Gamescores';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the id field
     */
    const COL_ID = 'gamescores.id';

    /**
     * the column name for the game_id field
     */
    const COL_GAME_ID = 'gamescores.game_id';

    /**
     * the column name for the player_id field
     */
    const COL_PLAYER_ID = 'gamescores.player_id';

    /**
     * the column name for the kills field
     */
    const COL_KILLS = 'gamescores.kills';

    /**
     * the column name for the deaths field
     */
    const COL_DEATHS = 'gamescores.deaths';

    /**
     * the column name for the score field
     */
    const COL_SCORE = 'gamescores.score';

    /**
     * the column name for the ping field
     */
    const COL_PING = 'gamescores.ping';

    /**
     * the column name for the winner field
     */
    const COL_WINNER = 'gamescores.winner';

    /**
     * the column name for the team field
     */
    const COL_TEAM = 'gamescores.team';

    /**
     * the column name for the half field
     */
    const COL_HALF = 'gamescores.half';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'gamescores.created';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'GameID', 'PlayerId', 'Kills', 'Deaths', 'Score', 'Ping', 'Winner', 'Team', 'Half', 'Created', ),
        self::TYPE_CAMELNAME     => array('id', 'gameID', 'playerId', 'kills', 'deaths', 'score', 'ping', 'winner', 'team', 'half', 'created', ),
        self::TYPE_COLNAME       => array(GamescoresTableMap::COL_ID, GamescoresTableMap::COL_GAME_ID, GamescoresTableMap::COL_PLAYER_ID, GamescoresTableMap::COL_KILLS, GamescoresTableMap::COL_DEATHS, GamescoresTableMap::COL_SCORE, GamescoresTableMap::COL_PING, GamescoresTableMap::COL_WINNER, GamescoresTableMap::COL_TEAM, GamescoresTableMap::COL_HALF, GamescoresTableMap::COL_CREATED, ),
        self::TYPE_FIELDNAME     => array('id', 'game_id', 'player_id', 'kills', 'deaths', 'score', 'ping', 'winner', 'team', 'half', 'created', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'GameID' => 1, 'PlayerId' => 2, 'Kills' => 3, 'Deaths' => 4, 'Score' => 5, 'Ping' => 6, 'Winner' => 7, 'Team' => 8, 'Half' => 9, 'Created' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'gameID' => 1, 'playerId' => 2, 'kills' => 3, 'deaths' => 4, 'score' => 5, 'ping' => 6, 'winner' => 7, 'team' => 8, 'half' => 9, 'created' => 10, ),
        self::TYPE_COLNAME       => array(GamescoresTableMap::COL_ID => 0, GamescoresTableMap::COL_GAME_ID => 1, GamescoresTableMap::COL_PLAYER_ID => 2, GamescoresTableMap::COL_KILLS => 3, GamescoresTableMap::COL_DEATHS => 4, GamescoresTableMap::COL_SCORE => 5, GamescoresTableMap::COL_PING => 6, GamescoresTableMap::COL_WINNER => 7, GamescoresTableMap::COL_TEAM => 8, GamescoresTableMap::COL_HALF => 9, GamescoresTableMap::COL_CREATED => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'game_id' => 1, 'player_id' => 2, 'kills' => 3, 'deaths' => 4, 'score' => 5, 'ping' => 6, 'winner' => 7, 'team' => 8, 'half' => 9, 'created' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('gamescores');
        $this->setPhpName('Gamescores');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Gamescores');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('game_id', 'GameID', 'INTEGER', 'games', 'id', true, null, null);
        $this->addForeignKey('player_id', 'PlayerId', 'INTEGER', 'players', 'id', true, null, null);
        $this->addColumn('kills', 'Kills', 'INTEGER', false, null, null);
        $this->addColumn('deaths', 'Deaths', 'INTEGER', false, null, null);
        $this->addColumn('score', 'Score', 'INTEGER', true, null, null);
        $this->addColumn('ping', 'Ping', 'INTEGER', true, null, null);
        $this->addColumn('winner', 'Winner', 'BOOLEAN', false, 1, null);
        $this->addColumn('team', 'Team', 'INTEGER', false, 11, null);
        $this->addColumn('half', 'Half', 'INTEGER', false, 11, null);
        $this->addColumn('created', 'Created', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Games', '\\Games', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':game_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Players', '\\Players', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':player_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? GamescoresTableMap::CLASS_DEFAULT : GamescoresTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Gamescores object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GamescoresTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GamescoresTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GamescoresTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GamescoresTableMap::OM_CLASS;
            /** @var Gamescores $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GamescoresTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = GamescoresTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GamescoresTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Gamescores $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GamescoresTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(GamescoresTableMap::COL_ID);
            $criteria->addSelectColumn(GamescoresTableMap::COL_GAME_ID);
            $criteria->addSelectColumn(GamescoresTableMap::COL_PLAYER_ID);
            $criteria->addSelectColumn(GamescoresTableMap::COL_KILLS);
            $criteria->addSelectColumn(GamescoresTableMap::COL_DEATHS);
            $criteria->addSelectColumn(GamescoresTableMap::COL_SCORE);
            $criteria->addSelectColumn(GamescoresTableMap::COL_PING);
            $criteria->addSelectColumn(GamescoresTableMap::COL_WINNER);
            $criteria->addSelectColumn(GamescoresTableMap::COL_TEAM);
            $criteria->addSelectColumn(GamescoresTableMap::COL_HALF);
            $criteria->addSelectColumn(GamescoresTableMap::COL_CREATED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.game_id');
            $criteria->addSelectColumn($alias . '.player_id');
            $criteria->addSelectColumn($alias . '.kills');
            $criteria->addSelectColumn($alias . '.deaths');
            $criteria->addSelectColumn($alias . '.score');
            $criteria->addSelectColumn($alias . '.ping');
            $criteria->addSelectColumn($alias . '.winner');
            $criteria->addSelectColumn($alias . '.team');
            $criteria->addSelectColumn($alias . '.half');
            $criteria->addSelectColumn($alias . '.created');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(GamescoresTableMap::DATABASE_NAME)->getTable(GamescoresTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(GamescoresTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(GamescoresTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new GamescoresTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Gamescores or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Gamescores object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamescoresTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Gamescores) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GamescoresTableMap::DATABASE_NAME);
            $criteria->add(GamescoresTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = GamescoresQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            GamescoresTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                GamescoresTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the gamescores table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GamescoresQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Gamescores or Criteria object.
     *
     * @param mixed               $criteria Criteria or Gamescores object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamescoresTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Gamescores object
        }

        if ($criteria->containsKey(GamescoresTableMap::COL_ID) && $criteria->keyContainsValue(GamescoresTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GamescoresTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = GamescoresQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // GamescoresTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
GamescoresTableMap::buildTableMap();
