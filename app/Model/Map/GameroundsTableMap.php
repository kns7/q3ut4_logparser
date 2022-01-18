<?php

namespace Map;

use \Gamerounds;
use \GameroundsQuery;
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
 * This class defines the structure of the 'gamerounds' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class GameroundsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.GameroundsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'gamerounds';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Gamerounds';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Gamerounds';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    const COL_ID = 'gamerounds.id';

    /**
     * the column name for the roundnb field
     */
    const COL_ROUNDNB = 'gamerounds.roundnb';

    /**
     * the column name for the game_id field
     */
    const COL_GAME_ID = 'gamerounds.game_id';

    /**
     * the column name for the half field
     */
    const COL_HALF = 'gamerounds.half';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'gamerounds.created';

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
        self::TYPE_PHPNAME       => array('Id', 'RoundNB', 'GameID', 'Half', 'Created', ),
        self::TYPE_CAMELNAME     => array('id', 'roundNB', 'gameID', 'half', 'created', ),
        self::TYPE_COLNAME       => array(GameroundsTableMap::COL_ID, GameroundsTableMap::COL_ROUNDNB, GameroundsTableMap::COL_GAME_ID, GameroundsTableMap::COL_HALF, GameroundsTableMap::COL_CREATED, ),
        self::TYPE_FIELDNAME     => array('id', 'roundnb', 'game_id', 'half', 'created', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'RoundNB' => 1, 'GameID' => 2, 'Half' => 3, 'Created' => 4, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'roundNB' => 1, 'gameID' => 2, 'half' => 3, 'created' => 4, ),
        self::TYPE_COLNAME       => array(GameroundsTableMap::COL_ID => 0, GameroundsTableMap::COL_ROUNDNB => 1, GameroundsTableMap::COL_GAME_ID => 2, GameroundsTableMap::COL_HALF => 3, GameroundsTableMap::COL_CREATED => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'roundnb' => 1, 'game_id' => 2, 'half' => 3, 'created' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Gamerounds.Id' => 'ID',
        'id' => 'ID',
        'gamerounds.id' => 'ID',
        'GameroundsTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'RoundNB' => 'ROUNDNB',
        'Gamerounds.RoundNB' => 'ROUNDNB',
        'roundNB' => 'ROUNDNB',
        'gamerounds.roundNB' => 'ROUNDNB',
        'GameroundsTableMap::COL_ROUNDNB' => 'ROUNDNB',
        'COL_ROUNDNB' => 'ROUNDNB',
        'roundnb' => 'ROUNDNB',
        'gamerounds.roundnb' => 'ROUNDNB',
        'GameID' => 'GAME_ID',
        'Gamerounds.GameID' => 'GAME_ID',
        'gameID' => 'GAME_ID',
        'gamerounds.gameID' => 'GAME_ID',
        'GameroundsTableMap::COL_GAME_ID' => 'GAME_ID',
        'COL_GAME_ID' => 'GAME_ID',
        'game_id' => 'GAME_ID',
        'gamerounds.game_id' => 'GAME_ID',
        'Half' => 'HALF',
        'Gamerounds.Half' => 'HALF',
        'half' => 'HALF',
        'gamerounds.half' => 'HALF',
        'GameroundsTableMap::COL_HALF' => 'HALF',
        'COL_HALF' => 'HALF',
        'Created' => 'CREATED',
        'Gamerounds.Created' => 'CREATED',
        'created' => 'CREATED',
        'gamerounds.created' => 'CREATED',
        'GameroundsTableMap::COL_CREATED' => 'CREATED',
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
        $this->setName('gamerounds');
        $this->setPhpName('Gamerounds');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Gamerounds');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('roundnb', 'RoundNB', 'INTEGER', true, null, null);
        $this->addForeignKey('game_id', 'GameID', 'INTEGER', 'games', 'id', true, null, null);
        $this->addColumn('half', 'Half', 'INTEGER', false, 11, null);
        $this->addColumn('created', 'Created', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
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
        $this->addRelation('Bomb', '\\Bombs', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':round_id',
    1 => ':id',
  ),
), null, null, 'Bombs', false);
        $this->addRelation('Flag', '\\Flags', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':round_id',
    1 => ':id',
  ),
), null, null, 'Flags', false);
        $this->addRelation('Frag', '\\Frags', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':round_id',
    1 => ':id',
  ),
), null, null, 'Frags', false);
        $this->addRelation('Hit', '\\Hits', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':round_id',
    1 => ':id',
  ),
), null, null, 'Hits', false);
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
        return $withPrefix ? GameroundsTableMap::CLASS_DEFAULT : GameroundsTableMap::OM_CLASS;
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
     * @return array           (Gamerounds object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GameroundsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GameroundsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GameroundsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GameroundsTableMap::OM_CLASS;
            /** @var Gamerounds $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GameroundsTableMap::addInstanceToPool($obj, $key);
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
            $key = GameroundsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GameroundsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Gamerounds $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GameroundsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(GameroundsTableMap::COL_ID);
            $criteria->addSelectColumn(GameroundsTableMap::COL_ROUNDNB);
            $criteria->addSelectColumn(GameroundsTableMap::COL_GAME_ID);
            $criteria->addSelectColumn(GameroundsTableMap::COL_HALF);
            $criteria->addSelectColumn(GameroundsTableMap::COL_CREATED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.roundnb');
            $criteria->addSelectColumn($alias . '.game_id');
            $criteria->addSelectColumn($alias . '.half');
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
            $criteria->removeSelectColumn(GameroundsTableMap::COL_ID);
            $criteria->removeSelectColumn(GameroundsTableMap::COL_ROUNDNB);
            $criteria->removeSelectColumn(GameroundsTableMap::COL_GAME_ID);
            $criteria->removeSelectColumn(GameroundsTableMap::COL_HALF);
            $criteria->removeSelectColumn(GameroundsTableMap::COL_CREATED);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.roundnb');
            $criteria->removeSelectColumn($alias . '.game_id');
            $criteria->removeSelectColumn($alias . '.half');
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
        return Propel::getServiceContainer()->getDatabaseMap(GameroundsTableMap::DATABASE_NAME)->getTable(GameroundsTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Gamerounds or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Gamerounds object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(GameroundsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Gamerounds) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GameroundsTableMap::DATABASE_NAME);
            $criteria->add(GameroundsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = GameroundsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            GameroundsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                GameroundsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the gamerounds table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GameroundsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Gamerounds or Criteria object.
     *
     * @param mixed               $criteria Criteria or Gamerounds object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameroundsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Gamerounds object
        }

        if ($criteria->containsKey(GameroundsTableMap::COL_ID) && $criteria->keyContainsValue(GameroundsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GameroundsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = GameroundsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // GameroundsTableMap
