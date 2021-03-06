<?php

namespace Map;

use \Hits;
use \HitsQuery;
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
 * This class defines the structure of the 'hits' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class HitsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.HitsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'hits';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Hits';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Hits';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'hits.id';

    /**
     * the column name for the hitter_id field
     */
    const COL_HITTER_ID = 'hits.hitter_id';

    /**
     * the column name for the hitted_id field
     */
    const COL_HITTED_ID = 'hits.hitted_id';

    /**
     * the column name for the bodypart_id field
     */
    const COL_BODYPART_ID = 'hits.bodypart_id';

    /**
     * the column name for the round_id field
     */
    const COL_ROUND_ID = 'hits.round_id';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'hits.created';

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
        self::TYPE_PHPNAME       => array('Id', 'HitterId', 'HittedId', 'BodypartId', 'RoundId', 'Created', ),
        self::TYPE_CAMELNAME     => array('id', 'hitterId', 'hittedId', 'bodypartId', 'roundId', 'created', ),
        self::TYPE_COLNAME       => array(HitsTableMap::COL_ID, HitsTableMap::COL_HITTER_ID, HitsTableMap::COL_HITTED_ID, HitsTableMap::COL_BODYPART_ID, HitsTableMap::COL_ROUND_ID, HitsTableMap::COL_CREATED, ),
        self::TYPE_FIELDNAME     => array('id', 'hitter_id', 'hitted_id', 'bodypart_id', 'round_id', 'created', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'HitterId' => 1, 'HittedId' => 2, 'BodypartId' => 3, 'RoundId' => 4, 'Created' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'hitterId' => 1, 'hittedId' => 2, 'bodypartId' => 3, 'roundId' => 4, 'created' => 5, ),
        self::TYPE_COLNAME       => array(HitsTableMap::COL_ID => 0, HitsTableMap::COL_HITTER_ID => 1, HitsTableMap::COL_HITTED_ID => 2, HitsTableMap::COL_BODYPART_ID => 3, HitsTableMap::COL_ROUND_ID => 4, HitsTableMap::COL_CREATED => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'hitter_id' => 1, 'hitted_id' => 2, 'bodypart_id' => 3, 'round_id' => 4, 'created' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Hits.Id' => 'ID',
        'id' => 'ID',
        'hits.id' => 'ID',
        'HitsTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'HitterId' => 'HITTER_ID',
        'Hits.HitterId' => 'HITTER_ID',
        'hitterId' => 'HITTER_ID',
        'hits.hitterId' => 'HITTER_ID',
        'HitsTableMap::COL_HITTER_ID' => 'HITTER_ID',
        'COL_HITTER_ID' => 'HITTER_ID',
        'hitter_id' => 'HITTER_ID',
        'hits.hitter_id' => 'HITTER_ID',
        'HittedId' => 'HITTED_ID',
        'Hits.HittedId' => 'HITTED_ID',
        'hittedId' => 'HITTED_ID',
        'hits.hittedId' => 'HITTED_ID',
        'HitsTableMap::COL_HITTED_ID' => 'HITTED_ID',
        'COL_HITTED_ID' => 'HITTED_ID',
        'hitted_id' => 'HITTED_ID',
        'hits.hitted_id' => 'HITTED_ID',
        'BodypartId' => 'BODYPART_ID',
        'Hits.BodypartId' => 'BODYPART_ID',
        'bodypartId' => 'BODYPART_ID',
        'hits.bodypartId' => 'BODYPART_ID',
        'HitsTableMap::COL_BODYPART_ID' => 'BODYPART_ID',
        'COL_BODYPART_ID' => 'BODYPART_ID',
        'bodypart_id' => 'BODYPART_ID',
        'hits.bodypart_id' => 'BODYPART_ID',
        'RoundId' => 'ROUND_ID',
        'Hits.RoundId' => 'ROUND_ID',
        'roundId' => 'ROUND_ID',
        'hits.roundId' => 'ROUND_ID',
        'HitsTableMap::COL_ROUND_ID' => 'ROUND_ID',
        'COL_ROUND_ID' => 'ROUND_ID',
        'round_id' => 'ROUND_ID',
        'hits.round_id' => 'ROUND_ID',
        'Created' => 'CREATED',
        'Hits.Created' => 'CREATED',
        'created' => 'CREATED',
        'hits.created' => 'CREATED',
        'HitsTableMap::COL_CREATED' => 'CREATED',
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
        $this->setName('hits');
        $this->setPhpName('Hits');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Hits');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('hitter_id', 'HitterId', 'INTEGER', 'players', 'id', true, null, null);
        $this->addForeignKey('hitted_id', 'HittedId', 'INTEGER', 'players', 'id', true, null, null);
        $this->addForeignKey('bodypart_id', 'BodypartId', 'INTEGER', 'bodyparts', 'id', true, null, null);
        $this->addForeignKey('round_id', 'RoundId', 'INTEGER', 'gamerounds', 'id', true, null, null);
        $this->addColumn('created', 'Created', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations()
    {
        $this->addRelation('Hitter', '\\Players', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':hitter_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Hitted', '\\Players', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':hitted_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Bodyparts', '\\Bodyparts', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':bodypart_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Rounds', '\\Gamerounds', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':round_id',
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
     * @param boolean $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? HitsTableMap::CLASS_DEFAULT : HitsTableMap::OM_CLASS;
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
     * @return array           (Hits object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = HitsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = HitsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + HitsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = HitsTableMap::OM_CLASS;
            /** @var Hits $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            HitsTableMap::addInstanceToPool($obj, $key);
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
            $key = HitsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = HitsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Hits $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                HitsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(HitsTableMap::COL_ID);
            $criteria->addSelectColumn(HitsTableMap::COL_HITTER_ID);
            $criteria->addSelectColumn(HitsTableMap::COL_HITTED_ID);
            $criteria->addSelectColumn(HitsTableMap::COL_BODYPART_ID);
            $criteria->addSelectColumn(HitsTableMap::COL_ROUND_ID);
            $criteria->addSelectColumn(HitsTableMap::COL_CREATED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.hitter_id');
            $criteria->addSelectColumn($alias . '.hitted_id');
            $criteria->addSelectColumn($alias . '.bodypart_id');
            $criteria->addSelectColumn($alias . '.round_id');
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
            $criteria->removeSelectColumn(HitsTableMap::COL_ID);
            $criteria->removeSelectColumn(HitsTableMap::COL_HITTER_ID);
            $criteria->removeSelectColumn(HitsTableMap::COL_HITTED_ID);
            $criteria->removeSelectColumn(HitsTableMap::COL_BODYPART_ID);
            $criteria->removeSelectColumn(HitsTableMap::COL_ROUND_ID);
            $criteria->removeSelectColumn(HitsTableMap::COL_CREATED);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.hitter_id');
            $criteria->removeSelectColumn($alias . '.hitted_id');
            $criteria->removeSelectColumn($alias . '.bodypart_id');
            $criteria->removeSelectColumn($alias . '.round_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(HitsTableMap::DATABASE_NAME)->getTable(HitsTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Hits or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Hits object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(HitsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Hits) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(HitsTableMap::DATABASE_NAME);
            $criteria->add(HitsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = HitsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            HitsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                HitsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the hits table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return HitsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Hits or Criteria object.
     *
     * @param mixed               $criteria Criteria or Hits object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HitsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Hits object
        }

        if ($criteria->containsKey(HitsTableMap::COL_ID) && $criteria->keyContainsValue(HitsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.HitsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = HitsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // HitsTableMap
