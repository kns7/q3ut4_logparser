<?php

namespace Base;

use \Hits as ChildHits;
use \HitsQuery as ChildHitsQuery;
use \Exception;
use \PDO;
use Map\HitsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'hits' table.
 *
 *
 *
 * @method     ChildHitsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildHitsQuery orderByPlayerId($order = Criteria::ASC) Order by the player_id column
 * @method     ChildHitsQuery orderByBodypartId($order = Criteria::ASC) Order by the bodypart_id column
 * @method     ChildHitsQuery orderByCounter($order = Criteria::ASC) Order by the counter column
 *
 * @method     ChildHitsQuery groupById() Group by the id column
 * @method     ChildHitsQuery groupByPlayerId() Group by the player_id column
 * @method     ChildHitsQuery groupByBodypartId() Group by the bodypart_id column
 * @method     ChildHitsQuery groupByCounter() Group by the counter column
 *
 * @method     ChildHitsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildHitsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildHitsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildHitsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildHitsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildHitsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildHitsQuery leftJoinPlayers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Players relation
 * @method     ChildHitsQuery rightJoinPlayers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Players relation
 * @method     ChildHitsQuery innerJoinPlayers($relationAlias = null) Adds a INNER JOIN clause to the query using the Players relation
 *
 * @method     ChildHitsQuery joinWithPlayers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Players relation
 *
 * @method     ChildHitsQuery leftJoinWithPlayers() Adds a LEFT JOIN clause and with to the query using the Players relation
 * @method     ChildHitsQuery rightJoinWithPlayers() Adds a RIGHT JOIN clause and with to the query using the Players relation
 * @method     ChildHitsQuery innerJoinWithPlayers() Adds a INNER JOIN clause and with to the query using the Players relation
 *
 * @method     ChildHitsQuery leftJoinBodyparts($relationAlias = null) Adds a LEFT JOIN clause to the query using the Bodyparts relation
 * @method     ChildHitsQuery rightJoinBodyparts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Bodyparts relation
 * @method     ChildHitsQuery innerJoinBodyparts($relationAlias = null) Adds a INNER JOIN clause to the query using the Bodyparts relation
 *
 * @method     ChildHitsQuery joinWithBodyparts($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Bodyparts relation
 *
 * @method     ChildHitsQuery leftJoinWithBodyparts() Adds a LEFT JOIN clause and with to the query using the Bodyparts relation
 * @method     ChildHitsQuery rightJoinWithBodyparts() Adds a RIGHT JOIN clause and with to the query using the Bodyparts relation
 * @method     ChildHitsQuery innerJoinWithBodyparts() Adds a INNER JOIN clause and with to the query using the Bodyparts relation
 *
 * @method     \PlayersQuery|\BodypartsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildHits findOne(ConnectionInterface $con = null) Return the first ChildHits matching the query
 * @method     ChildHits findOneOrCreate(ConnectionInterface $con = null) Return the first ChildHits matching the query, or a new ChildHits object populated from the query conditions when no match is found
 *
 * @method     ChildHits findOneById(int $id) Return the first ChildHits filtered by the id column
 * @method     ChildHits findOneByPlayerId(int $player_id) Return the first ChildHits filtered by the player_id column
 * @method     ChildHits findOneByBodypartId(int $bodypart_id) Return the first ChildHits filtered by the bodypart_id column
 * @method     ChildHits findOneByCounter(int $counter) Return the first ChildHits filtered by the counter column *

 * @method     ChildHits requirePk($key, ConnectionInterface $con = null) Return the ChildHits by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHits requireOne(ConnectionInterface $con = null) Return the first ChildHits matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHits requireOneById(int $id) Return the first ChildHits filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHits requireOneByPlayerId(int $player_id) Return the first ChildHits filtered by the player_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHits requireOneByBodypartId(int $bodypart_id) Return the first ChildHits filtered by the bodypart_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHits requireOneByCounter(int $counter) Return the first ChildHits filtered by the counter column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHits[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildHits objects based on current ModelCriteria
 * @method     ChildHits[]|ObjectCollection findById(int $id) Return ChildHits objects filtered by the id column
 * @method     ChildHits[]|ObjectCollection findByPlayerId(int $player_id) Return ChildHits objects filtered by the player_id column
 * @method     ChildHits[]|ObjectCollection findByBodypartId(int $bodypart_id) Return ChildHits objects filtered by the bodypart_id column
 * @method     ChildHits[]|ObjectCollection findByCounter(int $counter) Return ChildHits objects filtered by the counter column
 * @method     ChildHits[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class HitsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\HitsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Hits', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildHitsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildHitsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildHitsQuery) {
            return $criteria;
        }
        $query = new ChildHitsQuery();
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
     * @return ChildHits|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(HitsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = HitsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildHits A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, player_id, bodypart_id, counter FROM hits WHERE id = :p0';
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
            /** @var ChildHits $obj */
            $obj = new ChildHits();
            $obj->hydrate($row);
            HitsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildHits|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildHitsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(HitsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildHitsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(HitsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildHitsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(HitsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(HitsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HitsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the player_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPlayerId(1234); // WHERE player_id = 1234
     * $query->filterByPlayerId(array(12, 34)); // WHERE player_id IN (12, 34)
     * $query->filterByPlayerId(array('min' => 12)); // WHERE player_id > 12
     * </code>
     *
     * @see       filterByPlayers()
     *
     * @param     mixed $playerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHitsQuery The current query, for fluid interface
     */
    public function filterByPlayerId($playerId = null, $comparison = null)
    {
        if (is_array($playerId)) {
            $useMinMax = false;
            if (isset($playerId['min'])) {
                $this->addUsingAlias(HitsTableMap::COL_PLAYER_ID, $playerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playerId['max'])) {
                $this->addUsingAlias(HitsTableMap::COL_PLAYER_ID, $playerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HitsTableMap::COL_PLAYER_ID, $playerId, $comparison);
    }

    /**
     * Filter the query on the bodypart_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBodypartId(1234); // WHERE bodypart_id = 1234
     * $query->filterByBodypartId(array(12, 34)); // WHERE bodypart_id IN (12, 34)
     * $query->filterByBodypartId(array('min' => 12)); // WHERE bodypart_id > 12
     * </code>
     *
     * @see       filterByBodyparts()
     *
     * @param     mixed $bodypartId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHitsQuery The current query, for fluid interface
     */
    public function filterByBodypartId($bodypartId = null, $comparison = null)
    {
        if (is_array($bodypartId)) {
            $useMinMax = false;
            if (isset($bodypartId['min'])) {
                $this->addUsingAlias(HitsTableMap::COL_BODYPART_ID, $bodypartId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bodypartId['max'])) {
                $this->addUsingAlias(HitsTableMap::COL_BODYPART_ID, $bodypartId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HitsTableMap::COL_BODYPART_ID, $bodypartId, $comparison);
    }

    /**
     * Filter the query on the counter column
     *
     * Example usage:
     * <code>
     * $query->filterByCounter(1234); // WHERE counter = 1234
     * $query->filterByCounter(array(12, 34)); // WHERE counter IN (12, 34)
     * $query->filterByCounter(array('min' => 12)); // WHERE counter > 12
     * </code>
     *
     * @param     mixed $counter The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHitsQuery The current query, for fluid interface
     */
    public function filterByCounter($counter = null, $comparison = null)
    {
        if (is_array($counter)) {
            $useMinMax = false;
            if (isset($counter['min'])) {
                $this->addUsingAlias(HitsTableMap::COL_COUNTER, $counter['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($counter['max'])) {
                $this->addUsingAlias(HitsTableMap::COL_COUNTER, $counter['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HitsTableMap::COL_COUNTER, $counter, $comparison);
    }

    /**
     * Filter the query by a related \Players object
     *
     * @param \Players|ObjectCollection $players The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildHitsQuery The current query, for fluid interface
     */
    public function filterByPlayers($players, $comparison = null)
    {
        if ($players instanceof \Players) {
            return $this
                ->addUsingAlias(HitsTableMap::COL_PLAYER_ID, $players->getId(), $comparison);
        } elseif ($players instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(HitsTableMap::COL_PLAYER_ID, $players->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPlayers() only accepts arguments of type \Players or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Players relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildHitsQuery The current query, for fluid interface
     */
    public function joinPlayers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Players');

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
            $this->addJoinObject($join, 'Players');
        }

        return $this;
    }

    /**
     * Use the Players relation Players object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PlayersQuery A secondary query class using the current class as primary query
     */
    public function usePlayersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPlayers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Players', '\PlayersQuery');
    }

    /**
     * Filter the query by a related \Bodyparts object
     *
     * @param \Bodyparts|ObjectCollection $bodyparts The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildHitsQuery The current query, for fluid interface
     */
    public function filterByBodyparts($bodyparts, $comparison = null)
    {
        if ($bodyparts instanceof \Bodyparts) {
            return $this
                ->addUsingAlias(HitsTableMap::COL_BODYPART_ID, $bodyparts->getId(), $comparison);
        } elseif ($bodyparts instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(HitsTableMap::COL_BODYPART_ID, $bodyparts->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBodyparts() only accepts arguments of type \Bodyparts or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Bodyparts relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildHitsQuery The current query, for fluid interface
     */
    public function joinBodyparts($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Bodyparts');

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
            $this->addJoinObject($join, 'Bodyparts');
        }

        return $this;
    }

    /**
     * Use the Bodyparts relation Bodyparts object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BodypartsQuery A secondary query class using the current class as primary query
     */
    public function useBodypartsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBodyparts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Bodyparts', '\BodypartsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildHits $hits Object to remove from the list of results
     *
     * @return $this|ChildHitsQuery The current query, for fluid interface
     */
    public function prune($hits = null)
    {
        if ($hits) {
            $this->addUsingAlias(HitsTableMap::COL_ID, $hits->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the hits table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HitsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            HitsTableMap::clearInstancePool();
            HitsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(HitsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(HitsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            HitsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            HitsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // HitsQuery
