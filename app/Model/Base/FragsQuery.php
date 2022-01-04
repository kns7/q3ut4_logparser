<?php

namespace Base;

use \Frags as ChildFrags;
use \FragsQuery as ChildFragsQuery;
use \Exception;
use \PDO;
use Map\FragsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'frags' table.
 *
 *
 *
 * @method     ChildFragsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFragsQuery orderByFraggerId($order = Criteria::ASC) Order by the fragger_id column
 * @method     ChildFragsQuery orderByFraggedId($order = Criteria::ASC) Order by the fragged_id column
 * @method     ChildFragsQuery orderByWeaponId($order = Criteria::ASC) Order by the weapon_id column
 * @method     ChildFragsQuery orderByCreated($order = Criteria::ASC) Order by the created column
 *
 * @method     ChildFragsQuery groupById() Group by the id column
 * @method     ChildFragsQuery groupByFraggerId() Group by the fragger_id column
 * @method     ChildFragsQuery groupByFraggedId() Group by the fragged_id column
 * @method     ChildFragsQuery groupByWeaponId() Group by the weapon_id column
 * @method     ChildFragsQuery groupByCreated() Group by the created column
 *
 * @method     ChildFragsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFragsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFragsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFragsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildFragsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildFragsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildFragsQuery leftJoinFragger($relationAlias = null) Adds a LEFT JOIN clause to the query using the Fragger relation
 * @method     ChildFragsQuery rightJoinFragger($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Fragger relation
 * @method     ChildFragsQuery innerJoinFragger($relationAlias = null) Adds a INNER JOIN clause to the query using the Fragger relation
 *
 * @method     ChildFragsQuery joinWithFragger($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Fragger relation
 *
 * @method     ChildFragsQuery leftJoinWithFragger() Adds a LEFT JOIN clause and with to the query using the Fragger relation
 * @method     ChildFragsQuery rightJoinWithFragger() Adds a RIGHT JOIN clause and with to the query using the Fragger relation
 * @method     ChildFragsQuery innerJoinWithFragger() Adds a INNER JOIN clause and with to the query using the Fragger relation
 *
 * @method     ChildFragsQuery leftJoinFragged($relationAlias = null) Adds a LEFT JOIN clause to the query using the Fragged relation
 * @method     ChildFragsQuery rightJoinFragged($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Fragged relation
 * @method     ChildFragsQuery innerJoinFragged($relationAlias = null) Adds a INNER JOIN clause to the query using the Fragged relation
 *
 * @method     ChildFragsQuery joinWithFragged($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Fragged relation
 *
 * @method     ChildFragsQuery leftJoinWithFragged() Adds a LEFT JOIN clause and with to the query using the Fragged relation
 * @method     ChildFragsQuery rightJoinWithFragged() Adds a RIGHT JOIN clause and with to the query using the Fragged relation
 * @method     ChildFragsQuery innerJoinWithFragged() Adds a INNER JOIN clause and with to the query using the Fragged relation
 *
 * @method     ChildFragsQuery leftJoinWeapons($relationAlias = null) Adds a LEFT JOIN clause to the query using the Weapons relation
 * @method     ChildFragsQuery rightJoinWeapons($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Weapons relation
 * @method     ChildFragsQuery innerJoinWeapons($relationAlias = null) Adds a INNER JOIN clause to the query using the Weapons relation
 *
 * @method     ChildFragsQuery joinWithWeapons($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Weapons relation
 *
 * @method     ChildFragsQuery leftJoinWithWeapons() Adds a LEFT JOIN clause and with to the query using the Weapons relation
 * @method     ChildFragsQuery rightJoinWithWeapons() Adds a RIGHT JOIN clause and with to the query using the Weapons relation
 * @method     ChildFragsQuery innerJoinWithWeapons() Adds a INNER JOIN clause and with to the query using the Weapons relation
 *
 * @method     \PlayersQuery|\WeaponsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFrags findOne(ConnectionInterface $con = null) Return the first ChildFrags matching the query
 * @method     ChildFrags findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFrags matching the query, or a new ChildFrags object populated from the query conditions when no match is found
 *
 * @method     ChildFrags findOneById(int $id) Return the first ChildFrags filtered by the id column
 * @method     ChildFrags findOneByFraggerId(int $fragger_id) Return the first ChildFrags filtered by the fragger_id column
 * @method     ChildFrags findOneByFraggedId(int $fragged_id) Return the first ChildFrags filtered by the fragged_id column
 * @method     ChildFrags findOneByWeaponId(int $weapon_id) Return the first ChildFrags filtered by the weapon_id column
 * @method     ChildFrags findOneByCreated(string $created) Return the first ChildFrags filtered by the created column *

 * @method     ChildFrags requirePk($key, ConnectionInterface $con = null) Return the ChildFrags by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrags requireOne(ConnectionInterface $con = null) Return the first ChildFrags matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFrags requireOneById(int $id) Return the first ChildFrags filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrags requireOneByFraggerId(int $fragger_id) Return the first ChildFrags filtered by the fragger_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrags requireOneByFraggedId(int $fragged_id) Return the first ChildFrags filtered by the fragged_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrags requireOneByWeaponId(int $weapon_id) Return the first ChildFrags filtered by the weapon_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFrags requireOneByCreated(string $created) Return the first ChildFrags filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFrags[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFrags objects based on current ModelCriteria
 * @method     ChildFrags[]|ObjectCollection findById(int $id) Return ChildFrags objects filtered by the id column
 * @method     ChildFrags[]|ObjectCollection findByFraggerId(int $fragger_id) Return ChildFrags objects filtered by the fragger_id column
 * @method     ChildFrags[]|ObjectCollection findByFraggedId(int $fragged_id) Return ChildFrags objects filtered by the fragged_id column
 * @method     ChildFrags[]|ObjectCollection findByWeaponId(int $weapon_id) Return ChildFrags objects filtered by the weapon_id column
 * @method     ChildFrags[]|ObjectCollection findByCreated(string $created) Return ChildFrags objects filtered by the created column
 * @method     ChildFrags[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FragsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\FragsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Frags', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFragsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFragsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFragsQuery) {
            return $criteria;
        }
        $query = new ChildFragsQuery();
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
     * @return ChildFrags|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FragsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = FragsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildFrags A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, fragger_id, fragged_id, weapon_id, created FROM frags WHERE id = :p0';
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
            /** @var ChildFrags $obj */
            $obj = new ChildFrags();
            $obj->hydrate($row);
            FragsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildFrags|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFragsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FragsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFragsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FragsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildFragsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FragsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FragsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FragsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the fragger_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFraggerId(1234); // WHERE fragger_id = 1234
     * $query->filterByFraggerId(array(12, 34)); // WHERE fragger_id IN (12, 34)
     * $query->filterByFraggerId(array('min' => 12)); // WHERE fragger_id > 12
     * </code>
     *
     * @see       filterByFragger()
     *
     * @param     mixed $fraggerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFragsQuery The current query, for fluid interface
     */
    public function filterByFraggerId($fraggerId = null, $comparison = null)
    {
        if (is_array($fraggerId)) {
            $useMinMax = false;
            if (isset($fraggerId['min'])) {
                $this->addUsingAlias(FragsTableMap::COL_FRAGGER_ID, $fraggerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fraggerId['max'])) {
                $this->addUsingAlias(FragsTableMap::COL_FRAGGER_ID, $fraggerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FragsTableMap::COL_FRAGGER_ID, $fraggerId, $comparison);
    }

    /**
     * Filter the query on the fragged_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFraggedId(1234); // WHERE fragged_id = 1234
     * $query->filterByFraggedId(array(12, 34)); // WHERE fragged_id IN (12, 34)
     * $query->filterByFraggedId(array('min' => 12)); // WHERE fragged_id > 12
     * </code>
     *
     * @see       filterByFragged()
     *
     * @param     mixed $fraggedId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFragsQuery The current query, for fluid interface
     */
    public function filterByFraggedId($fraggedId = null, $comparison = null)
    {
        if (is_array($fraggedId)) {
            $useMinMax = false;
            if (isset($fraggedId['min'])) {
                $this->addUsingAlias(FragsTableMap::COL_FRAGGED_ID, $fraggedId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fraggedId['max'])) {
                $this->addUsingAlias(FragsTableMap::COL_FRAGGED_ID, $fraggedId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FragsTableMap::COL_FRAGGED_ID, $fraggedId, $comparison);
    }

    /**
     * Filter the query on the weapon_id column
     *
     * Example usage:
     * <code>
     * $query->filterByWeaponId(1234); // WHERE weapon_id = 1234
     * $query->filterByWeaponId(array(12, 34)); // WHERE weapon_id IN (12, 34)
     * $query->filterByWeaponId(array('min' => 12)); // WHERE weapon_id > 12
     * </code>
     *
     * @see       filterByWeapons()
     *
     * @param     mixed $weaponId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFragsQuery The current query, for fluid interface
     */
    public function filterByWeaponId($weaponId = null, $comparison = null)
    {
        if (is_array($weaponId)) {
            $useMinMax = false;
            if (isset($weaponId['min'])) {
                $this->addUsingAlias(FragsTableMap::COL_WEAPON_ID, $weaponId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weaponId['max'])) {
                $this->addUsingAlias(FragsTableMap::COL_WEAPON_ID, $weaponId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FragsTableMap::COL_WEAPON_ID, $weaponId, $comparison);
    }

    /**
     * Filter the query on the created column
     *
     * Example usage:
     * <code>
     * $query->filterByCreated('2011-03-14'); // WHERE created = '2011-03-14'
     * $query->filterByCreated('now'); // WHERE created = '2011-03-14'
     * $query->filterByCreated(array('max' => 'yesterday')); // WHERE created > '2011-03-13'
     * </code>
     *
     * @param     mixed $created The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFragsQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(FragsTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(FragsTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FragsTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query by a related \Players object
     *
     * @param \Players|ObjectCollection $players The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFragsQuery The current query, for fluid interface
     */
    public function filterByFragger($players, $comparison = null)
    {
        if ($players instanceof \Players) {
            return $this
                ->addUsingAlias(FragsTableMap::COL_FRAGGER_ID, $players->getId(), $comparison);
        } elseif ($players instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FragsTableMap::COL_FRAGGER_ID, $players->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFragger() only accepts arguments of type \Players or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Fragger relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFragsQuery The current query, for fluid interface
     */
    public function joinFragger($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Fragger');

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
            $this->addJoinObject($join, 'Fragger');
        }

        return $this;
    }

    /**
     * Use the Fragger relation Players object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PlayersQuery A secondary query class using the current class as primary query
     */
    public function useFraggerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFragger($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Fragger', '\PlayersQuery');
    }

    /**
     * Filter the query by a related \Players object
     *
     * @param \Players|ObjectCollection $players The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFragsQuery The current query, for fluid interface
     */
    public function filterByFragged($players, $comparison = null)
    {
        if ($players instanceof \Players) {
            return $this
                ->addUsingAlias(FragsTableMap::COL_FRAGGED_ID, $players->getId(), $comparison);
        } elseif ($players instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FragsTableMap::COL_FRAGGED_ID, $players->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFragged() only accepts arguments of type \Players or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Fragged relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFragsQuery The current query, for fluid interface
     */
    public function joinFragged($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Fragged');

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
            $this->addJoinObject($join, 'Fragged');
        }

        return $this;
    }

    /**
     * Use the Fragged relation Players object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PlayersQuery A secondary query class using the current class as primary query
     */
    public function useFraggedQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFragged($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Fragged', '\PlayersQuery');
    }

    /**
     * Filter the query by a related \Weapons object
     *
     * @param \Weapons|ObjectCollection $weapons The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFragsQuery The current query, for fluid interface
     */
    public function filterByWeapons($weapons, $comparison = null)
    {
        if ($weapons instanceof \Weapons) {
            return $this
                ->addUsingAlias(FragsTableMap::COL_WEAPON_ID, $weapons->getId(), $comparison);
        } elseif ($weapons instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FragsTableMap::COL_WEAPON_ID, $weapons->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByWeapons() only accepts arguments of type \Weapons or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Weapons relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFragsQuery The current query, for fluid interface
     */
    public function joinWeapons($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Weapons');

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
            $this->addJoinObject($join, 'Weapons');
        }

        return $this;
    }

    /**
     * Use the Weapons relation Weapons object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \WeaponsQuery A secondary query class using the current class as primary query
     */
    public function useWeaponsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWeapons($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Weapons', '\WeaponsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFrags $frags Object to remove from the list of results
     *
     * @return $this|ChildFragsQuery The current query, for fluid interface
     */
    public function prune($frags = null)
    {
        if ($frags) {
            $this->addUsingAlias(FragsTableMap::COL_ID, $frags->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the frags table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FragsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FragsTableMap::clearInstancePool();
            FragsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FragsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FragsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FragsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FragsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FragsQuery
