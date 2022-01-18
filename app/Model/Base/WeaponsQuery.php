<?php

namespace Base;

use \Weapons as ChildWeapons;
use \WeaponsQuery as ChildWeaponsQuery;
use \Exception;
use \PDO;
use Map\WeaponsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'weapons' table.
 *
 *
 *
 * @method     ChildWeaponsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWeaponsQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildWeaponsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildWeaponsQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildWeaponsQuery orderByUrl($order = Criteria::ASC) Order by the url column
 *
 * @method     ChildWeaponsQuery groupById() Group by the id column
 * @method     ChildWeaponsQuery groupByCode() Group by the code column
 * @method     ChildWeaponsQuery groupByName() Group by the name column
 * @method     ChildWeaponsQuery groupByType() Group by the type column
 * @method     ChildWeaponsQuery groupByUrl() Group by the url column
 *
 * @method     ChildWeaponsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWeaponsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWeaponsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWeaponsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildWeaponsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildWeaponsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildWeaponsQuery leftJoinFragWeapon($relationAlias = null) Adds a LEFT JOIN clause to the query using the FragWeapon relation
 * @method     ChildWeaponsQuery rightJoinFragWeapon($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FragWeapon relation
 * @method     ChildWeaponsQuery innerJoinFragWeapon($relationAlias = null) Adds a INNER JOIN clause to the query using the FragWeapon relation
 *
 * @method     ChildWeaponsQuery joinWithFragWeapon($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the FragWeapon relation
 *
 * @method     ChildWeaponsQuery leftJoinWithFragWeapon() Adds a LEFT JOIN clause and with to the query using the FragWeapon relation
 * @method     ChildWeaponsQuery rightJoinWithFragWeapon() Adds a RIGHT JOIN clause and with to the query using the FragWeapon relation
 * @method     ChildWeaponsQuery innerJoinWithFragWeapon() Adds a INNER JOIN clause and with to the query using the FragWeapon relation
 *
 * @method     \FragsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildWeapons|null findOne(ConnectionInterface $con = null) Return the first ChildWeapons matching the query
 * @method     ChildWeapons findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWeapons matching the query, or a new ChildWeapons object populated from the query conditions when no match is found
 *
 * @method     ChildWeapons|null findOneById(int $id) Return the first ChildWeapons filtered by the id column
 * @method     ChildWeapons|null findOneByCode(string $code) Return the first ChildWeapons filtered by the code column
 * @method     ChildWeapons|null findOneByName(string $name) Return the first ChildWeapons filtered by the name column
 * @method     ChildWeapons|null findOneByType(string $type) Return the first ChildWeapons filtered by the type column
 * @method     ChildWeapons|null findOneByUrl(string $url) Return the first ChildWeapons filtered by the url column *

 * @method     ChildWeapons requirePk($key, ConnectionInterface $con = null) Return the ChildWeapons by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWeapons requireOne(ConnectionInterface $con = null) Return the first ChildWeapons matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWeapons requireOneById(int $id) Return the first ChildWeapons filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWeapons requireOneByCode(string $code) Return the first ChildWeapons filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWeapons requireOneByName(string $name) Return the first ChildWeapons filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWeapons requireOneByType(string $type) Return the first ChildWeapons filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWeapons requireOneByUrl(string $url) Return the first ChildWeapons filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWeapons[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildWeapons objects based on current ModelCriteria
 * @psalm-method ObjectCollection&\Traversable<ChildWeapons> find(ConnectionInterface $con = null) Return ChildWeapons objects based on current ModelCriteria
 * @method     ChildWeapons[]|ObjectCollection findById(int $id) Return ChildWeapons objects filtered by the id column
 * @psalm-method ObjectCollection&\Traversable<ChildWeapons> findById(int $id) Return ChildWeapons objects filtered by the id column
 * @method     ChildWeapons[]|ObjectCollection findByCode(string $code) Return ChildWeapons objects filtered by the code column
 * @psalm-method ObjectCollection&\Traversable<ChildWeapons> findByCode(string $code) Return ChildWeapons objects filtered by the code column
 * @method     ChildWeapons[]|ObjectCollection findByName(string $name) Return ChildWeapons objects filtered by the name column
 * @psalm-method ObjectCollection&\Traversable<ChildWeapons> findByName(string $name) Return ChildWeapons objects filtered by the name column
 * @method     ChildWeapons[]|ObjectCollection findByType(string $type) Return ChildWeapons objects filtered by the type column
 * @psalm-method ObjectCollection&\Traversable<ChildWeapons> findByType(string $type) Return ChildWeapons objects filtered by the type column
 * @method     ChildWeapons[]|ObjectCollection findByUrl(string $url) Return ChildWeapons objects filtered by the url column
 * @psalm-method ObjectCollection&\Traversable<ChildWeapons> findByUrl(string $url) Return ChildWeapons objects filtered by the url column
 * @method     ChildWeapons[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildWeapons> paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class WeaponsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\WeaponsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Weapons', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWeaponsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWeaponsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildWeaponsQuery) {
            return $criteria;
        }
        $query = new ChildWeaponsQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildWeapons|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WeaponsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = WeaponsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWeapons A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, code, name, type, url FROM weapons WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildWeapons $obj */
            $obj = new ChildWeapons();
            $obj->hydrate($row);
            WeaponsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildWeapons|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildWeaponsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WeaponsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildWeaponsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WeaponsTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWeaponsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(WeaponsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WeaponsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WeaponsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%', Criteria::LIKE); // WHERE code LIKE '%fooValue%'
     * $query->filterByCode(['foo', 'bar']); // WHERE code IN ('foo', 'bar')
     * </code>
     *
     * @param     string|string[] $code The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWeaponsQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WeaponsTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE name IN ('foo', 'bar')
     * </code>
     *
     * @param     string|string[] $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWeaponsQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WeaponsTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * $query->filterByType(['foo', 'bar']); // WHERE type IN ('foo', 'bar')
     * </code>
     *
     * @param     string|string[] $type The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWeaponsQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WeaponsTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%', Criteria::LIKE); // WHERE url LIKE '%fooValue%'
     * $query->filterByUrl(['foo', 'bar']); // WHERE url IN ('foo', 'bar')
     * </code>
     *
     * @param     string|string[] $url The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWeaponsQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WeaponsTableMap::COL_URL, $url, $comparison);
    }

    /**
     * Filter the query by a related \Frags object
     *
     * @param \Frags|ObjectCollection $frags the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWeaponsQuery The current query, for fluid interface
     */
    public function filterByFragWeapon($frags, $comparison = null)
    {
        if ($frags instanceof \Frags) {
            return $this
                ->addUsingAlias(WeaponsTableMap::COL_ID, $frags->getWeaponId(), $comparison);
        } elseif ($frags instanceof ObjectCollection) {
            return $this
                ->useFragWeaponQuery()
                ->filterByPrimaryKeys($frags->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFragWeapon() only accepts arguments of type \Frags or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FragWeapon relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWeaponsQuery The current query, for fluid interface
     */
    public function joinFragWeapon($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FragWeapon');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'FragWeapon');
        }

        return $this;
    }

    /**
     * Use the FragWeapon relation Frags object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FragsQuery A secondary query class using the current class as primary query
     */
    public function useFragWeaponQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFragWeapon($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FragWeapon', '\FragsQuery');
    }

    /**
     * Use the FragWeapon relation Frags object
     *
     * @param callable(\FragsQuery):\FragsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withFragWeaponQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useFragWeaponQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the FragWeapon relation to the Frags table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \FragsQuery The inner query object of the EXISTS statement
     */
    public function useFragWeaponExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('FragWeapon', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the FragWeapon relation to the Frags table for a NOT EXISTS query.
     *
     * @see useFragWeaponExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \FragsQuery The inner query object of the NOT EXISTS statement
     */
    public function useFragWeaponNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('FragWeapon', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildWeapons $weapons Object to remove from the list of results
     *
     * @return $this|ChildWeaponsQuery The current query, for fluid interface
     */
    public function prune($weapons = null)
    {
        if ($weapons) {
            $this->addUsingAlias(WeaponsTableMap::COL_ID, $weapons->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the weapons table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WeaponsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            WeaponsTableMap::clearInstancePool();
            WeaponsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WeaponsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WeaponsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            WeaponsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            WeaponsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // WeaponsQuery
