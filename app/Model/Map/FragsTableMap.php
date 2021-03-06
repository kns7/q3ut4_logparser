<?php

namespace Map;

use \Frags;
use \FragsQuery;
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
 * This class defines the structure of the 'frags' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class FragsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.FragsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'frags';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Frags';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Frags';

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
    const COL_ID = 'frags.id';

    /**
     * the column name for the fragger_id field
     */
    const COL_FRAGGER_ID = 'frags.fragger_id';

    /**
     * the column name for the fragged_id field
     */
    const COL_FRAGGED_ID = 'frags.fragged_id';

    /**
     * the column name for the weapon_id field
     */
    const COL_WEAPON_ID = 'frags.weapon_id';

    /**
     * the column name for the round_id field
     */
    const COL_ROUND_ID = 'frags.round_id';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'frags.created';

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
        self::TYPE_PHPNAME       => array('Id', 'FraggerId', 'FraggedId', 'WeaponId', 'RoundId', 'Created', ),
        self::TYPE_CAMELNAME     => array('id', 'fraggerId', 'fraggedId', 'weaponId', 'roundId', 'created', ),
        self::TYPE_COLNAME       => array(FragsTableMap::COL_ID, FragsTableMap::COL_FRAGGER_ID, FragsTableMap::COL_FRAGGED_ID, FragsTableMap::COL_WEAPON_ID, FragsTableMap::COL_ROUND_ID, FragsTableMap::COL_CREATED, ),
        self::TYPE_FIELDNAME     => array('id', 'fragger_id', 'fragged_id', 'weapon_id', 'round_id', 'created', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'FraggerId' => 1, 'FraggedId' => 2, 'WeaponId' => 3, 'RoundId' => 4, 'Created' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'fraggerId' => 1, 'fraggedId' => 2, 'weaponId' => 3, 'roundId' => 4, 'created' => 5, ),
        self::TYPE_COLNAME       => array(FragsTableMap::COL_ID => 0, FragsTableMap::COL_FRAGGER_ID => 1, FragsTableMap::COL_FRAGGED_ID => 2, FragsTableMap::COL_WEAPON_ID => 3, FragsTableMap::COL_ROUND_ID => 4, FragsTableMap::COL_CREATED => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'fragger_id' => 1, 'fragged_id' => 2, 'weapon_id' => 3, 'round_id' => 4, 'created' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Frags.Id' => 'ID',
        'id' => 'ID',
        'frags.id' => 'ID',
        'FragsTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'FraggerId' => 'FRAGGER_ID',
        'Frags.FraggerId' => 'FRAGGER_ID',
        'fraggerId' => 'FRAGGER_ID',
        'frags.fraggerId' => 'FRAGGER_ID',
        'FragsTableMap::COL_FRAGGER_ID' => 'FRAGGER_ID',
        'COL_FRAGGER_ID' => 'FRAGGER_ID',
        'fragger_id' => 'FRAGGER_ID',
        'frags.fragger_id' => 'FRAGGER_ID',
        'FraggedId' => 'FRAGGED_ID',
        'Frags.FraggedId' => 'FRAGGED_ID',
        'fraggedId' => 'FRAGGED_ID',
        'frags.fraggedId' => 'FRAGGED_ID',
        'FragsTableMap::COL_FRAGGED_ID' => 'FRAGGED_ID',
        'COL_FRAGGED_ID' => 'FRAGGED_ID',
        'fragged_id' => 'FRAGGED_ID',
        'frags.fragged_id' => 'FRAGGED_ID',
        'WeaponId' => 'WEAPON_ID',
        'Frags.WeaponId' => 'WEAPON_ID',
        'weaponId' => 'WEAPON_ID',
        'frags.weaponId' => 'WEAPON_ID',
        'FragsTableMap::COL_WEAPON_ID' => 'WEAPON_ID',
        'COL_WEAPON_ID' => 'WEAPON_ID',
        'weapon_id' => 'WEAPON_ID',
        'frags.weapon_id' => 'WEAPON_ID',
        'RoundId' => 'ROUND_ID',
        'Frags.RoundId' => 'ROUND_ID',
        'roundId' => 'ROUND_ID',
        'frags.roundId' => 'ROUND_ID',
        'FragsTableMap::COL_ROUND_ID' => 'ROUND_ID',
        'COL_ROUND_ID' => 'ROUND_ID',
        'round_id' => 'ROUND_ID',
        'frags.round_id' => 'ROUND_ID',
        'Created' => 'CREATED',
        'Frags.Created' => 'CREATED',
        'created' => 'CREATED',
        'frags.created' => 'CREATED',
        'FragsTableMap::COL_CREATED' => 'CREATED',
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
        $this->setName('frags');
        $this->setPhpName('Frags');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Frags');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('fragger_id', 'FraggerId', 'INTEGER', 'players', 'id', true, null, null);
        $this->addForeignKey('fragged_id', 'FraggedId', 'INTEGER', 'players', 'id', true, null, null);
        $this->addForeignKey('weapon_id', 'WeaponId', 'INTEGER', 'weapons', 'id', true, null, null);
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
        $this->addRelation('Fragger', '\\Players', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':fragger_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Fragged', '\\Players', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':fragged_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Weapons', '\\Weapons', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':weapon_id',
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
        return $withPrefix ? FragsTableMap::CLASS_DEFAULT : FragsTableMap::OM_CLASS;
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
     * @return array           (Frags object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FragsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FragsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FragsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FragsTableMap::OM_CLASS;
            /** @var Frags $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FragsTableMap::addInstanceToPool($obj, $key);
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
            $key = FragsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FragsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Frags $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FragsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(FragsTableMap::COL_ID);
            $criteria->addSelectColumn(FragsTableMap::COL_FRAGGER_ID);
            $criteria->addSelectColumn(FragsTableMap::COL_FRAGGED_ID);
            $criteria->addSelectColumn(FragsTableMap::COL_WEAPON_ID);
            $criteria->addSelectColumn(FragsTableMap::COL_ROUND_ID);
            $criteria->addSelectColumn(FragsTableMap::COL_CREATED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.fragger_id');
            $criteria->addSelectColumn($alias . '.fragged_id');
            $criteria->addSelectColumn($alias . '.weapon_id');
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
            $criteria->removeSelectColumn(FragsTableMap::COL_ID);
            $criteria->removeSelectColumn(FragsTableMap::COL_FRAGGER_ID);
            $criteria->removeSelectColumn(FragsTableMap::COL_FRAGGED_ID);
            $criteria->removeSelectColumn(FragsTableMap::COL_WEAPON_ID);
            $criteria->removeSelectColumn(FragsTableMap::COL_ROUND_ID);
            $criteria->removeSelectColumn(FragsTableMap::COL_CREATED);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.fragger_id');
            $criteria->removeSelectColumn($alias . '.fragged_id');
            $criteria->removeSelectColumn($alias . '.weapon_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(FragsTableMap::DATABASE_NAME)->getTable(FragsTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Frags or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Frags object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FragsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Frags) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FragsTableMap::DATABASE_NAME);
            $criteria->add(FragsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = FragsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FragsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                FragsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the frags table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FragsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Frags or Criteria object.
     *
     * @param mixed               $criteria Criteria or Frags object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FragsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Frags object
        }

        if ($criteria->containsKey(FragsTableMap::COL_ID) && $criteria->keyContainsValue(FragsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FragsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = FragsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // FragsTableMap
