<?php

namespace Map;

use \Games;
use \GamesQuery;
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
 * This class defines the structure of the 'games' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class GamesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.GamesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'games';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Games';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Games';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the id field
     */
    const COL_ID = 'games.id';

    /**
     * the column name for the gamenb field
     */
    const COL_GAMENB = 'games.gamenb';

    /**
     * the column name for the map_id field
     */
    const COL_MAP_ID = 'games.map_id';

    /**
     * the column name for the gametype_id field
     */
    const COL_GAMETYPE_ID = 'games.gametype_id';

    /**
     * the column name for the timelimit field
     */
    const COL_TIMELIMIT = 'games.timelimit';

    /**
     * the column name for the roundtime field
     */
    const COL_ROUNDTIME = 'games.roundtime';

    /**
     * the column name for the nbplayers field
     */
    const COL_NBPLAYERS = 'games.nbplayers';

    /**
     * the column name for the redscore field
     */
    const COL_REDSCORE = 'games.redscore';

    /**
     * the column name for the bluescore field
     */
    const COL_BLUESCORE = 'games.bluescore';

    /**
     * the column name for the redscore2 field
     */
    const COL_REDSCORE2 = 'games.redscore2';

    /**
     * the column name for the bluescore2 field
     */
    const COL_BLUESCORE2 = 'games.bluescore2';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'games.created';

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
        self::TYPE_PHPNAME       => array('Id', 'GameNB', 'MapId', 'GametypeId', 'Timelimit', 'Roundtime', 'Nbplayers', 'RedScore', 'BlueScore', 'RedScore2', 'BlueScore2', 'Created', ),
        self::TYPE_CAMELNAME     => array('id', 'gameNB', 'mapId', 'gametypeId', 'timelimit', 'roundtime', 'nbplayers', 'redScore', 'blueScore', 'redScore2', 'blueScore2', 'created', ),
        self::TYPE_COLNAME       => array(GamesTableMap::COL_ID, GamesTableMap::COL_GAMENB, GamesTableMap::COL_MAP_ID, GamesTableMap::COL_GAMETYPE_ID, GamesTableMap::COL_TIMELIMIT, GamesTableMap::COL_ROUNDTIME, GamesTableMap::COL_NBPLAYERS, GamesTableMap::COL_REDSCORE, GamesTableMap::COL_BLUESCORE, GamesTableMap::COL_REDSCORE2, GamesTableMap::COL_BLUESCORE2, GamesTableMap::COL_CREATED, ),
        self::TYPE_FIELDNAME     => array('id', 'gamenb', 'map_id', 'gametype_id', 'timelimit', 'roundtime', 'nbplayers', 'redscore', 'bluescore', 'redscore2', 'bluescore2', 'created', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'GameNB' => 1, 'MapId' => 2, 'GametypeId' => 3, 'Timelimit' => 4, 'Roundtime' => 5, 'Nbplayers' => 6, 'RedScore' => 7, 'BlueScore' => 8, 'RedScore2' => 9, 'BlueScore2' => 10, 'Created' => 11, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'gameNB' => 1, 'mapId' => 2, 'gametypeId' => 3, 'timelimit' => 4, 'roundtime' => 5, 'nbplayers' => 6, 'redScore' => 7, 'blueScore' => 8, 'redScore2' => 9, 'blueScore2' => 10, 'created' => 11, ),
        self::TYPE_COLNAME       => array(GamesTableMap::COL_ID => 0, GamesTableMap::COL_GAMENB => 1, GamesTableMap::COL_MAP_ID => 2, GamesTableMap::COL_GAMETYPE_ID => 3, GamesTableMap::COL_TIMELIMIT => 4, GamesTableMap::COL_ROUNDTIME => 5, GamesTableMap::COL_NBPLAYERS => 6, GamesTableMap::COL_REDSCORE => 7, GamesTableMap::COL_BLUESCORE => 8, GamesTableMap::COL_REDSCORE2 => 9, GamesTableMap::COL_BLUESCORE2 => 10, GamesTableMap::COL_CREATED => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'gamenb' => 1, 'map_id' => 2, 'gametype_id' => 3, 'timelimit' => 4, 'roundtime' => 5, 'nbplayers' => 6, 'redscore' => 7, 'bluescore' => 8, 'redscore2' => 9, 'bluescore2' => 10, 'created' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Games.Id' => 'ID',
        'id' => 'ID',
        'games.id' => 'ID',
        'GamesTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'GameNB' => 'GAMENB',
        'Games.GameNB' => 'GAMENB',
        'gameNB' => 'GAMENB',
        'games.gameNB' => 'GAMENB',
        'GamesTableMap::COL_GAMENB' => 'GAMENB',
        'COL_GAMENB' => 'GAMENB',
        'gamenb' => 'GAMENB',
        'games.gamenb' => 'GAMENB',
        'MapId' => 'MAP_ID',
        'Games.MapId' => 'MAP_ID',
        'mapId' => 'MAP_ID',
        'games.mapId' => 'MAP_ID',
        'GamesTableMap::COL_MAP_ID' => 'MAP_ID',
        'COL_MAP_ID' => 'MAP_ID',
        'map_id' => 'MAP_ID',
        'games.map_id' => 'MAP_ID',
        'GametypeId' => 'GAMETYPE_ID',
        'Games.GametypeId' => 'GAMETYPE_ID',
        'gametypeId' => 'GAMETYPE_ID',
        'games.gametypeId' => 'GAMETYPE_ID',
        'GamesTableMap::COL_GAMETYPE_ID' => 'GAMETYPE_ID',
        'COL_GAMETYPE_ID' => 'GAMETYPE_ID',
        'gametype_id' => 'GAMETYPE_ID',
        'games.gametype_id' => 'GAMETYPE_ID',
        'Timelimit' => 'TIMELIMIT',
        'Games.Timelimit' => 'TIMELIMIT',
        'timelimit' => 'TIMELIMIT',
        'games.timelimit' => 'TIMELIMIT',
        'GamesTableMap::COL_TIMELIMIT' => 'TIMELIMIT',
        'COL_TIMELIMIT' => 'TIMELIMIT',
        'Roundtime' => 'ROUNDTIME',
        'Games.Roundtime' => 'ROUNDTIME',
        'roundtime' => 'ROUNDTIME',
        'games.roundtime' => 'ROUNDTIME',
        'GamesTableMap::COL_ROUNDTIME' => 'ROUNDTIME',
        'COL_ROUNDTIME' => 'ROUNDTIME',
        'Nbplayers' => 'NBPLAYERS',
        'Games.Nbplayers' => 'NBPLAYERS',
        'nbplayers' => 'NBPLAYERS',
        'games.nbplayers' => 'NBPLAYERS',
        'GamesTableMap::COL_NBPLAYERS' => 'NBPLAYERS',
        'COL_NBPLAYERS' => 'NBPLAYERS',
        'RedScore' => 'REDSCORE',
        'Games.RedScore' => 'REDSCORE',
        'redScore' => 'REDSCORE',
        'games.redScore' => 'REDSCORE',
        'GamesTableMap::COL_REDSCORE' => 'REDSCORE',
        'COL_REDSCORE' => 'REDSCORE',
        'redscore' => 'REDSCORE',
        'games.redscore' => 'REDSCORE',
        'BlueScore' => 'BLUESCORE',
        'Games.BlueScore' => 'BLUESCORE',
        'blueScore' => 'BLUESCORE',
        'games.blueScore' => 'BLUESCORE',
        'GamesTableMap::COL_BLUESCORE' => 'BLUESCORE',
        'COL_BLUESCORE' => 'BLUESCORE',
        'bluescore' => 'BLUESCORE',
        'games.bluescore' => 'BLUESCORE',
        'RedScore2' => 'REDSCORE2',
        'Games.RedScore2' => 'REDSCORE2',
        'redScore2' => 'REDSCORE2',
        'games.redScore2' => 'REDSCORE2',
        'GamesTableMap::COL_REDSCORE2' => 'REDSCORE2',
        'COL_REDSCORE2' => 'REDSCORE2',
        'redscore2' => 'REDSCORE2',
        'games.redscore2' => 'REDSCORE2',
        'BlueScore2' => 'BLUESCORE2',
        'Games.BlueScore2' => 'BLUESCORE2',
        'blueScore2' => 'BLUESCORE2',
        'games.blueScore2' => 'BLUESCORE2',
        'GamesTableMap::COL_BLUESCORE2' => 'BLUESCORE2',
        'COL_BLUESCORE2' => 'BLUESCORE2',
        'bluescore2' => 'BLUESCORE2',
        'games.bluescore2' => 'BLUESCORE2',
        'Created' => 'CREATED',
        'Games.Created' => 'CREATED',
        'created' => 'CREATED',
        'games.created' => 'CREATED',
        'GamesTableMap::COL_CREATED' => 'CREATED',
        'COL_CREATED' => 'CREATED',
    ];

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
        $this->setName('games');
        $this->setPhpName('Games');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Games');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('gamenb', 'GameNB', 'INTEGER', true, null, null);
        $this->addForeignKey('map_id', 'MapId', 'INTEGER', 'maps', 'id', true, null, null);
        $this->addForeignKey('gametype_id', 'GametypeId', 'INTEGER', 'gametypes', 'id', true, null, null);
        $this->addColumn('timelimit', 'Timelimit', 'INTEGER', true, null, null);
        $this->addColumn('roundtime', 'Roundtime', 'INTEGER', true, null, null);
        $this->addColumn('nbplayers', 'Nbplayers', 'INTEGER', true, null, null);
        $this->addColumn('redscore', 'RedScore', 'INTEGER', false, null, null);
        $this->addColumn('bluescore', 'BlueScore', 'INTEGER', false, null, null);
        $this->addColumn('redscore2', 'RedScore2', 'INTEGER', false, null, null);
        $this->addColumn('bluescore2', 'BlueScore2', 'INTEGER', false, null, null);
        $this->addColumn('created', 'Created', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations()
    {
        $this->addRelation('Maps', '\\Maps', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':map_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Gamestypes', '\\Gametypes', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':gametype_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Round', '\\Gamerounds', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':game_id',
    1 => ':id',
  ),
), null, null, 'Rounds', false);
        $this->addRelation('Score', '\\Gamescores', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':game_id',
    1 => ':id',
  ),
), null, null, 'Scores', false);
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
     * @param boolean $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? GamesTableMap::CLASS_DEFAULT : GamesTableMap::OM_CLASS;
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
     * @return array           (Games object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GamesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GamesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GamesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GamesTableMap::OM_CLASS;
            /** @var Games $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GamesTableMap::addInstanceToPool($obj, $key);
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
            $key = GamesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GamesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Games $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GamesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(GamesTableMap::COL_ID);
            $criteria->addSelectColumn(GamesTableMap::COL_GAMENB);
            $criteria->addSelectColumn(GamesTableMap::COL_MAP_ID);
            $criteria->addSelectColumn(GamesTableMap::COL_GAMETYPE_ID);
            $criteria->addSelectColumn(GamesTableMap::COL_TIMELIMIT);
            $criteria->addSelectColumn(GamesTableMap::COL_ROUNDTIME);
            $criteria->addSelectColumn(GamesTableMap::COL_NBPLAYERS);
            $criteria->addSelectColumn(GamesTableMap::COL_REDSCORE);
            $criteria->addSelectColumn(GamesTableMap::COL_BLUESCORE);
            $criteria->addSelectColumn(GamesTableMap::COL_REDSCORE2);
            $criteria->addSelectColumn(GamesTableMap::COL_BLUESCORE2);
            $criteria->addSelectColumn(GamesTableMap::COL_CREATED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.gamenb');
            $criteria->addSelectColumn($alias . '.map_id');
            $criteria->addSelectColumn($alias . '.gametype_id');
            $criteria->addSelectColumn($alias . '.timelimit');
            $criteria->addSelectColumn($alias . '.roundtime');
            $criteria->addSelectColumn($alias . '.nbplayers');
            $criteria->addSelectColumn($alias . '.redscore');
            $criteria->addSelectColumn($alias . '.bluescore');
            $criteria->addSelectColumn($alias . '.redscore2');
            $criteria->addSelectColumn($alias . '.bluescore2');
            $criteria->addSelectColumn($alias . '.created');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria object containing the columns to remove.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function removeSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(GamesTableMap::COL_ID);
            $criteria->removeSelectColumn(GamesTableMap::COL_GAMENB);
            $criteria->removeSelectColumn(GamesTableMap::COL_MAP_ID);
            $criteria->removeSelectColumn(GamesTableMap::COL_GAMETYPE_ID);
            $criteria->removeSelectColumn(GamesTableMap::COL_TIMELIMIT);
            $criteria->removeSelectColumn(GamesTableMap::COL_ROUNDTIME);
            $criteria->removeSelectColumn(GamesTableMap::COL_NBPLAYERS);
            $criteria->removeSelectColumn(GamesTableMap::COL_REDSCORE);
            $criteria->removeSelectColumn(GamesTableMap::COL_BLUESCORE);
            $criteria->removeSelectColumn(GamesTableMap::COL_REDSCORE2);
            $criteria->removeSelectColumn(GamesTableMap::COL_BLUESCORE2);
            $criteria->removeSelectColumn(GamesTableMap::COL_CREATED);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.gamenb');
            $criteria->removeSelectColumn($alias . '.map_id');
            $criteria->removeSelectColumn($alias . '.gametype_id');
            $criteria->removeSelectColumn($alias . '.timelimit');
            $criteria->removeSelectColumn($alias . '.roundtime');
            $criteria->removeSelectColumn($alias . '.nbplayers');
            $criteria->removeSelectColumn($alias . '.redscore');
            $criteria->removeSelectColumn($alias . '.bluescore');
            $criteria->removeSelectColumn($alias . '.redscore2');
            $criteria->removeSelectColumn($alias . '.bluescore2');
            $criteria->removeSelectColumn($alias . '.created');
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
        return Propel::getServiceContainer()->getDatabaseMap(GamesTableMap::DATABASE_NAME)->getTable(GamesTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Games or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Games object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(GamesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Games) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GamesTableMap::DATABASE_NAME);
            $criteria->add(GamesTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = GamesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            GamesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                GamesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the games table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GamesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Games or Criteria object.
     *
     * @param mixed               $criteria Criteria or Games object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Games object
        }

        if ($criteria->containsKey(GamesTableMap::COL_ID) && $criteria->keyContainsValue(GamesTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GamesTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = GamesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // GamesTableMap
