<?php

namespace Base;

use \Bombs as ChildBombs;
use \BombsQuery as ChildBombsQuery;
use \Exception;
use \PDO;
use Map\BombsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'bombs' table.
 *
 *
 *
 * @method     ChildBombsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildBombsQuery orderByPlayerId($order = Criteria::ASC) Order by the player_id column
 * @method     ChildBombsQuery orderByEvent($order = Criteria::ASC) Order by the event column
 * @method     ChildBombsQuery orderByRoundId($order = Criteria::ASC) Order by the round_id column
 * @method     ChildBombsQuery orderByCreated($order = Criteria::ASC) Order by the created column
 *
 * @method     ChildBombsQuery groupById() Group by the id column
 * @method     ChildBombsQuery groupByPlayerId() Group by the player_id column
 * @method     ChildBombsQuery groupByEvent() Group by the event column
 * @method     ChildBombsQuery groupByRoundId() Group by the round_id column
 * @method     ChildBombsQuery groupByCreated() Group by the created column
 *
 * @method     ChildBombsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBombsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBombsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBombsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBombsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBombsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBombsQuery leftJoinPlayers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Players relation
 * @method     ChildBombsQuery rightJoinPlayers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Players relation
 * @method     ChildBombsQuery innerJoinPlayers($relationAlias = null) Adds a INNER JOIN clause to the query using the Players relation
 *
 * @method     ChildBombsQuery joinWithPlayers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Players relation
 *
 * @method     ChildBombsQuery leftJoinWithPlayers() Adds a LEFT JOIN clause and with to the query using the Players relation
 * @method     ChildBombsQuery rightJoinWithPlayers() Adds a RIGHT JOIN clause and with to the query using the Players relation
 * @method     ChildBombsQuery innerJoinWithPlayers() Adds a INNER JOIN clause and with to the query using the Players relation
 *
 * @method     ChildBombsQuery leftJoinRounds($relationAlias = null) Adds a LEFT JOIN clause to the query using the Rounds relation
 * @method     ChildBombsQuery rightJoinRounds($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Rounds relation
 * @method     ChildBombsQuery innerJoinRounds($relationAlias = null) Adds a INNER JOIN clause to the query using the Rounds relation
 *
 * @method     ChildBombsQuery joinWithRounds($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Rounds relation
 *
 * @method     ChildBombsQuery leftJoinWithRounds() Adds a LEFT JOIN clause and with to the query using the Rounds relation
 * @method     ChildBombsQuery rightJoinWithRounds() Adds a RIGHT JOIN clause and with to the query using the Rounds relation
 * @method     ChildBombsQuery innerJoinWithRounds() Adds a INNER JOIN clause and with to the query using the Rounds relation
 *
 * @method     \PlayersQuery|\GameroundsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBombs|null findOne(ConnectionInterface $con = null) Return the first ChildBombs matching the query
 * @method     ChildBombs findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBombs matching the query, or a new ChildBombs object populated from the query conditions when no match is found
 *
 * @method     ChildBombs|null findOneById(int $id) Return the first ChildBombs filtered by the id column
 * @method     ChildBombs|null findOneByPlayerId(int $player_id) Return the first ChildBombs filtered by the player_id column
 * @method     ChildBombs|null findOneByEvent(string $event) Return the first ChildBombs filtered by the event column
 * @method     ChildBombs|null findOneByRoundId(int $round_id) Return the first ChildBombs filtered by the round_id column
 * @method     ChildBombs|null findOneByCreated(string $created) Return the first ChildBombs filtered by the created column *

 * @method     ChildBombs requirePk($key, ConnectionInterface $con = null) Return the ChildBombs by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBombs requireOne(ConnectionInterface $con = null) Return the first ChildBombs matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBombs requireOneById(int $id) Return the first ChildBombs filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBombs requireOneByPlayerId(int $player_id) Return the first ChildBombs filtered by the player_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBombs requireOneByEvent(string $event) Return the first ChildBombs filtered by the event column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBombs requireOneByRoundId(int $round_id) Return the first ChildBombs filtered by the round_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBombs requireOneByCreated(string $created) Return the first ChildBombs filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBombs[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBombs objects based on current ModelCriteria
 * @psalm-method ObjectCollection&\Traversable<ChildBombs> find(ConnectionInterface $con = null) Return ChildBombs objects based on current ModelCriteria
 * @method     ChildBombs[]|ObjectCollection findById(int $id) Return ChildBombs objects filtered by the id column
 * @psalm-method ObjectCollection&\Traversable<ChildBombs> findById(int $id) Return ChildBombs objects filtered by the id column
 * @method     ChildBombs[]|ObjectCollection findByPlayerId(int $player_id) Return ChildBombs objects filtered by the player_id column
 * @psalm-method ObjectCollection&\Traversable<ChildBombs> findByPlayerId(int $player_id) Return ChildBombs objects filtered by the player_id column
 * @method     ChildBombs[]|ObjectCollection findByEvent(string $event) Return ChildBombs objects filtered by the event column
 * @psalm-method ObjectCollection&\Traversable<ChildBombs> findByEvent(string $event) Return ChildBombs objects filtered by the event column
 * @method     ChildBombs[]|ObjectCollection findByRoundId(int $round_id) Return ChildBombs objects filtered by the round_id column
 * @psalm-method ObjectCollection&\Traversable<ChildBombs> findByRoundId(int $round_id) Return ChildBombs objects filtered by the round_id column
 * @method     ChildBombs[]|ObjectCollection findByCreated(string $created) Return ChildBombs objects filtered by the created column
 * @psalm-method ObjectCollection&\Traversable<ChildBombs> findByCreated(string $created) Return ChildBombs objects filtered by the created column
 * @method     ChildBombs[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildBombs> paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BombsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\BombsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Bombs', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBombsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBombsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBombsQuery) {
            return $criteria;
        }
        $query = new ChildBombsQuery();
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
     * @return ChildBombs|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BombsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BombsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBombs A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, player_id, event, round_id, created FROM bombs WHERE id = :p0';
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
            /** @var ChildBombs $obj */
            $obj = new ChildBombs();
            $obj->hydrate($row);
            BombsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBombs|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBombsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BombsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBombsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BombsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBombsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BombsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BombsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BombsTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildBombsQuery The current query, for fluid interface
     */
    public function filterByPlayerId($playerId = null, $comparison = null)
    {
        if (is_array($playerId)) {
            $useMinMax = false;
            if (isset($playerId['min'])) {
                $this->addUsingAlias(BombsTableMap::COL_PLAYER_ID, $playerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playerId['max'])) {
                $this->addUsingAlias(BombsTableMap::COL_PLAYER_ID, $playerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BombsTableMap::COL_PLAYER_ID, $playerId, $comparison);
    }

    /**
     * Filter the query on the event column
     *
     * Example usage:
     * <code>
     * $query->filterByEvent('fooValue');   // WHERE event = 'fooValue'
     * $query->filterByEvent('%fooValue%', Criteria::LIKE); // WHERE event LIKE '%fooValue%'
     * $query->filterByEvent(['foo', 'bar']); // WHERE event IN ('foo', 'bar')
     * </code>
     *
     * @param     string|string[] $event The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBombsQuery The current query, for fluid interface
     */
    public function filterByEvent($event = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($event)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BombsTableMap::COL_EVENT, $event, $comparison);
    }

    /**
     * Filter the query on the round_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRoundId(1234); // WHERE round_id = 1234
     * $query->filterByRoundId(array(12, 34)); // WHERE round_id IN (12, 34)
     * $query->filterByRoundId(array('min' => 12)); // WHERE round_id > 12
     * </code>
     *
     * @see       filterByRounds()
     *
     * @param     mixed $roundId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBombsQuery The current query, for fluid interface
     */
    public function filterByRoundId($roundId = null, $comparison = null)
    {
        if (is_array($roundId)) {
            $useMinMax = false;
            if (isset($roundId['min'])) {
                $this->addUsingAlias(BombsTableMap::COL_ROUND_ID, $roundId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roundId['max'])) {
                $this->addUsingAlias(BombsTableMap::COL_ROUND_ID, $roundId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BombsTableMap::COL_ROUND_ID, $roundId, $comparison);
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
     * @return $this|ChildBombsQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(BombsTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(BombsTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BombsTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query by a related \Players object
     *
     * @param \Players|ObjectCollection $players The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBombsQuery The current query, for fluid interface
     */
    public function filterByPlayers($players, $comparison = null)
    {
        if ($players instanceof \Players) {
            return $this
                ->addUsingAlias(BombsTableMap::COL_PLAYER_ID, $players->getId(), $comparison);
        } elseif ($players instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BombsTableMap::COL_PLAYER_ID, $players->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildBombsQuery The current query, for fluid interface
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
     * Use the Players relation Players object
     *
     * @param callable(\PlayersQuery):\PlayersQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPlayersQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePlayersQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Players table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \PlayersQuery The inner query object of the EXISTS statement
     */
    public function usePlayersExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Players', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Players table for a NOT EXISTS query.
     *
     * @see usePlayersExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \PlayersQuery The inner query object of the NOT EXISTS statement
     */
    public function usePlayersNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Players', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Gamerounds object
     *
     * @param \Gamerounds|ObjectCollection $gamerounds The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBombsQuery The current query, for fluid interface
     */
    public function filterByRounds($gamerounds, $comparison = null)
    {
        if ($gamerounds instanceof \Gamerounds) {
            return $this
                ->addUsingAlias(BombsTableMap::COL_ROUND_ID, $gamerounds->getId(), $comparison);
        } elseif ($gamerounds instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BombsTableMap::COL_ROUND_ID, $gamerounds->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRounds() only accepts arguments of type \Gamerounds or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Rounds relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBombsQuery The current query, for fluid interface
     */
    public function joinRounds($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Rounds');

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
            $this->addJoinObject($join, 'Rounds');
        }

        return $this;
    }

    /**
     * Use the Rounds relation Gamerounds object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GameroundsQuery A secondary query class using the current class as primary query
     */
    public function useRoundsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRounds($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Rounds', '\GameroundsQuery');
    }

    /**
     * Use the Rounds relation Gamerounds object
     *
     * @param callable(\GameroundsQuery):\GameroundsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withRoundsQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useRoundsQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the Rounds relation to the Gamerounds table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \GameroundsQuery The inner query object of the EXISTS statement
     */
    public function useRoundsExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Rounds', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the Rounds relation to the Gamerounds table for a NOT EXISTS query.
     *
     * @see useRoundsExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \GameroundsQuery The inner query object of the NOT EXISTS statement
     */
    public function useRoundsNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Rounds', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildBombs $bombs Object to remove from the list of results
     *
     * @return $this|ChildBombsQuery The current query, for fluid interface
     */
    public function prune($bombs = null)
    {
        if ($bombs) {
            $this->addUsingAlias(BombsTableMap::COL_ID, $bombs->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the bombs table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BombsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BombsTableMap::clearInstancePool();
            BombsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BombsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BombsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BombsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BombsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BombsQuery
