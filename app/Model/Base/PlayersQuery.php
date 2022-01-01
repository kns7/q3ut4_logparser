<?php

namespace Base;

use \Players as ChildPlayers;
use \PlayersQuery as ChildPlayersQuery;
use \Exception;
use \PDO;
use Map\PlayersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'players' table.
 *
 *
 *
 * @method     ChildPlayersQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPlayersQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildPlayersQuery orderByAltname($order = Criteria::ASC) Order by the altname column
 *
 * @method     ChildPlayersQuery groupById() Group by the id column
 * @method     ChildPlayersQuery groupByName() Group by the name column
 * @method     ChildPlayersQuery groupByAltname() Group by the altname column
 *
 * @method     ChildPlayersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPlayersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPlayersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPlayersQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPlayersQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPlayersQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPlayersQuery leftJoinBomb($relationAlias = null) Adds a LEFT JOIN clause to the query using the Bomb relation
 * @method     ChildPlayersQuery rightJoinBomb($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Bomb relation
 * @method     ChildPlayersQuery innerJoinBomb($relationAlias = null) Adds a INNER JOIN clause to the query using the Bomb relation
 *
 * @method     ChildPlayersQuery joinWithBomb($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Bomb relation
 *
 * @method     ChildPlayersQuery leftJoinWithBomb() Adds a LEFT JOIN clause and with to the query using the Bomb relation
 * @method     ChildPlayersQuery rightJoinWithBomb() Adds a RIGHT JOIN clause and with to the query using the Bomb relation
 * @method     ChildPlayersQuery innerJoinWithBomb() Adds a INNER JOIN clause and with to the query using the Bomb relation
 *
 * @method     ChildPlayersQuery leftJoinFlag($relationAlias = null) Adds a LEFT JOIN clause to the query using the Flag relation
 * @method     ChildPlayersQuery rightJoinFlag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Flag relation
 * @method     ChildPlayersQuery innerJoinFlag($relationAlias = null) Adds a INNER JOIN clause to the query using the Flag relation
 *
 * @method     ChildPlayersQuery joinWithFlag($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Flag relation
 *
 * @method     ChildPlayersQuery leftJoinWithFlag() Adds a LEFT JOIN clause and with to the query using the Flag relation
 * @method     ChildPlayersQuery rightJoinWithFlag() Adds a RIGHT JOIN clause and with to the query using the Flag relation
 * @method     ChildPlayersQuery innerJoinWithFlag() Adds a INNER JOIN clause and with to the query using the Flag relation
 *
 * @method     ChildPlayersQuery leftJoinFraggerPlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the FraggerPlayer relation
 * @method     ChildPlayersQuery rightJoinFraggerPlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FraggerPlayer relation
 * @method     ChildPlayersQuery innerJoinFraggerPlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the FraggerPlayer relation
 *
 * @method     ChildPlayersQuery joinWithFraggerPlayer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the FraggerPlayer relation
 *
 * @method     ChildPlayersQuery leftJoinWithFraggerPlayer() Adds a LEFT JOIN clause and with to the query using the FraggerPlayer relation
 * @method     ChildPlayersQuery rightJoinWithFraggerPlayer() Adds a RIGHT JOIN clause and with to the query using the FraggerPlayer relation
 * @method     ChildPlayersQuery innerJoinWithFraggerPlayer() Adds a INNER JOIN clause and with to the query using the FraggerPlayer relation
 *
 * @method     ChildPlayersQuery leftJoinFraggedPlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the FraggedPlayer relation
 * @method     ChildPlayersQuery rightJoinFraggedPlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FraggedPlayer relation
 * @method     ChildPlayersQuery innerJoinFraggedPlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the FraggedPlayer relation
 *
 * @method     ChildPlayersQuery joinWithFraggedPlayer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the FraggedPlayer relation
 *
 * @method     ChildPlayersQuery leftJoinWithFraggedPlayer() Adds a LEFT JOIN clause and with to the query using the FraggedPlayer relation
 * @method     ChildPlayersQuery rightJoinWithFraggedPlayer() Adds a RIGHT JOIN clause and with to the query using the FraggedPlayer relation
 * @method     ChildPlayersQuery innerJoinWithFraggedPlayer() Adds a INNER JOIN clause and with to the query using the FraggedPlayer relation
 *
 * @method     ChildPlayersQuery leftJoinGame($relationAlias = null) Adds a LEFT JOIN clause to the query using the Game relation
 * @method     ChildPlayersQuery rightJoinGame($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Game relation
 * @method     ChildPlayersQuery innerJoinGame($relationAlias = null) Adds a INNER JOIN clause to the query using the Game relation
 *
 * @method     ChildPlayersQuery joinWithGame($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Game relation
 *
 * @method     ChildPlayersQuery leftJoinWithGame() Adds a LEFT JOIN clause and with to the query using the Game relation
 * @method     ChildPlayersQuery rightJoinWithGame() Adds a RIGHT JOIN clause and with to the query using the Game relation
 * @method     ChildPlayersQuery innerJoinWithGame() Adds a INNER JOIN clause and with to the query using the Game relation
 *
 * @method     ChildPlayersQuery leftJoinHitterPlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the HitterPlayer relation
 * @method     ChildPlayersQuery rightJoinHitterPlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the HitterPlayer relation
 * @method     ChildPlayersQuery innerJoinHitterPlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the HitterPlayer relation
 *
 * @method     ChildPlayersQuery joinWithHitterPlayer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the HitterPlayer relation
 *
 * @method     ChildPlayersQuery leftJoinWithHitterPlayer() Adds a LEFT JOIN clause and with to the query using the HitterPlayer relation
 * @method     ChildPlayersQuery rightJoinWithHitterPlayer() Adds a RIGHT JOIN clause and with to the query using the HitterPlayer relation
 * @method     ChildPlayersQuery innerJoinWithHitterPlayer() Adds a INNER JOIN clause and with to the query using the HitterPlayer relation
 *
 * @method     ChildPlayersQuery leftJoinHittedPlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the HittedPlayer relation
 * @method     ChildPlayersQuery rightJoinHittedPlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the HittedPlayer relation
 * @method     ChildPlayersQuery innerJoinHittedPlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the HittedPlayer relation
 *
 * @method     ChildPlayersQuery joinWithHittedPlayer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the HittedPlayer relation
 *
 * @method     ChildPlayersQuery leftJoinWithHittedPlayer() Adds a LEFT JOIN clause and with to the query using the HittedPlayer relation
 * @method     ChildPlayersQuery rightJoinWithHittedPlayer() Adds a RIGHT JOIN clause and with to the query using the HittedPlayer relation
 * @method     ChildPlayersQuery innerJoinWithHittedPlayer() Adds a INNER JOIN clause and with to the query using the HittedPlayer relation
 *
 * @method     ChildPlayersQuery leftJoinScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the Score relation
 * @method     ChildPlayersQuery rightJoinScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Score relation
 * @method     ChildPlayersQuery innerJoinScore($relationAlias = null) Adds a INNER JOIN clause to the query using the Score relation
 *
 * @method     ChildPlayersQuery joinWithScore($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Score relation
 *
 * @method     ChildPlayersQuery leftJoinWithScore() Adds a LEFT JOIN clause and with to the query using the Score relation
 * @method     ChildPlayersQuery rightJoinWithScore() Adds a RIGHT JOIN clause and with to the query using the Score relation
 * @method     ChildPlayersQuery innerJoinWithScore() Adds a INNER JOIN clause and with to the query using the Score relation
 *
 * @method     ChildPlayersQuery leftJoinTeam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Team relation
 * @method     ChildPlayersQuery rightJoinTeam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Team relation
 * @method     ChildPlayersQuery innerJoinTeam($relationAlias = null) Adds a INNER JOIN clause to the query using the Team relation
 *
 * @method     ChildPlayersQuery joinWithTeam($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Team relation
 *
 * @method     ChildPlayersQuery leftJoinWithTeam() Adds a LEFT JOIN clause and with to the query using the Team relation
 * @method     ChildPlayersQuery rightJoinWithTeam() Adds a RIGHT JOIN clause and with to the query using the Team relation
 * @method     ChildPlayersQuery innerJoinWithTeam() Adds a INNER JOIN clause and with to the query using the Team relation
 *
 * @method     \BombsQuery|\FlagsQuery|\FragsQuery|\GamesQuery|\HitsQuery|\ScoresQuery|\TeamsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPlayers findOne(ConnectionInterface $con = null) Return the first ChildPlayers matching the query
 * @method     ChildPlayers findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPlayers matching the query, or a new ChildPlayers object populated from the query conditions when no match is found
 *
 * @method     ChildPlayers findOneById(int $id) Return the first ChildPlayers filtered by the id column
 * @method     ChildPlayers findOneByName(string $name) Return the first ChildPlayers filtered by the name column
 * @method     ChildPlayers findOneByAltname(string $altname) Return the first ChildPlayers filtered by the altname column *

 * @method     ChildPlayers requirePk($key, ConnectionInterface $con = null) Return the ChildPlayers by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayers requireOne(ConnectionInterface $con = null) Return the first ChildPlayers matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayers requireOneById(int $id) Return the first ChildPlayers filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayers requireOneByName(string $name) Return the first ChildPlayers filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayers requireOneByAltname(string $altname) Return the first ChildPlayers filtered by the altname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayers[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPlayers objects based on current ModelCriteria
 * @method     ChildPlayers[]|ObjectCollection findById(int $id) Return ChildPlayers objects filtered by the id column
 * @method     ChildPlayers[]|ObjectCollection findByName(string $name) Return ChildPlayers objects filtered by the name column
 * @method     ChildPlayers[]|ObjectCollection findByAltname(string $altname) Return ChildPlayers objects filtered by the altname column
 * @method     ChildPlayers[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PlayersQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PlayersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Players', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPlayersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPlayersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPlayersQuery) {
            return $criteria;
        }
        $query = new ChildPlayersQuery();
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
     * @return ChildPlayers|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PlayersTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PlayersTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPlayers A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, altname FROM players WHERE id = :p0';
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
            /** @var ChildPlayers $obj */
            $obj = new ChildPlayers();
            $obj->hydrate($row);
            PlayersTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPlayers|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PlayersTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PlayersTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PlayersTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PlayersTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayersTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayersTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the altname column
     *
     * Example usage:
     * <code>
     * $query->filterByAltname('fooValue');   // WHERE altname = 'fooValue'
     * $query->filterByAltname('%fooValue%', Criteria::LIKE); // WHERE altname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $altname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByAltname($altname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($altname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayersTableMap::COL_ALTNAME, $altname, $comparison);
    }

    /**
     * Filter the query by a related \Bombs object
     *
     * @param \Bombs|ObjectCollection $bombs the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByBomb($bombs, $comparison = null)
    {
        if ($bombs instanceof \Bombs) {
            return $this
                ->addUsingAlias(PlayersTableMap::COL_ID, $bombs->getPlayerId(), $comparison);
        } elseif ($bombs instanceof ObjectCollection) {
            return $this
                ->useBombQuery()
                ->filterByPrimaryKeys($bombs->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBomb() only accepts arguments of type \Bombs or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Bomb relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function joinBomb($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Bomb');

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
            $this->addJoinObject($join, 'Bomb');
        }

        return $this;
    }

    /**
     * Use the Bomb relation Bombs object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BombsQuery A secondary query class using the current class as primary query
     */
    public function useBombQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBomb($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Bomb', '\BombsQuery');
    }

    /**
     * Filter the query by a related \Flags object
     *
     * @param \Flags|ObjectCollection $flags the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByFlag($flags, $comparison = null)
    {
        if ($flags instanceof \Flags) {
            return $this
                ->addUsingAlias(PlayersTableMap::COL_ID, $flags->getPlayerId(), $comparison);
        } elseif ($flags instanceof ObjectCollection) {
            return $this
                ->useFlagQuery()
                ->filterByPrimaryKeys($flags->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFlag() only accepts arguments of type \Flags or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Flag relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function joinFlag($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Flag');

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
            $this->addJoinObject($join, 'Flag');
        }

        return $this;
    }

    /**
     * Use the Flag relation Flags object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FlagsQuery A secondary query class using the current class as primary query
     */
    public function useFlagQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFlag($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Flag', '\FlagsQuery');
    }

    /**
     * Filter the query by a related \Frags object
     *
     * @param \Frags|ObjectCollection $frags the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByFraggerPlayer($frags, $comparison = null)
    {
        if ($frags instanceof \Frags) {
            return $this
                ->addUsingAlias(PlayersTableMap::COL_ID, $frags->getFraggerId(), $comparison);
        } elseif ($frags instanceof ObjectCollection) {
            return $this
                ->useFraggerPlayerQuery()
                ->filterByPrimaryKeys($frags->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFraggerPlayer() only accepts arguments of type \Frags or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FraggerPlayer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function joinFraggerPlayer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FraggerPlayer');

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
            $this->addJoinObject($join, 'FraggerPlayer');
        }

        return $this;
    }

    /**
     * Use the FraggerPlayer relation Frags object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FragsQuery A secondary query class using the current class as primary query
     */
    public function useFraggerPlayerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFraggerPlayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FraggerPlayer', '\FragsQuery');
    }

    /**
     * Filter the query by a related \Frags object
     *
     * @param \Frags|ObjectCollection $frags the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByFraggedPlayer($frags, $comparison = null)
    {
        if ($frags instanceof \Frags) {
            return $this
                ->addUsingAlias(PlayersTableMap::COL_ID, $frags->getFraggedId(), $comparison);
        } elseif ($frags instanceof ObjectCollection) {
            return $this
                ->useFraggedPlayerQuery()
                ->filterByPrimaryKeys($frags->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFraggedPlayer() only accepts arguments of type \Frags or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FraggedPlayer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function joinFraggedPlayer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FraggedPlayer');

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
            $this->addJoinObject($join, 'FraggedPlayer');
        }

        return $this;
    }

    /**
     * Use the FraggedPlayer relation Frags object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FragsQuery A secondary query class using the current class as primary query
     */
    public function useFraggedPlayerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFraggedPlayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FraggedPlayer', '\FragsQuery');
    }

    /**
     * Filter the query by a related \Games object
     *
     * @param \Games|ObjectCollection $games the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByGame($games, $comparison = null)
    {
        if ($games instanceof \Games) {
            return $this
                ->addUsingAlias(PlayersTableMap::COL_ID, $games->getPlayerId(), $comparison);
        } elseif ($games instanceof ObjectCollection) {
            return $this
                ->useGameQuery()
                ->filterByPrimaryKeys($games->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGame() only accepts arguments of type \Games or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Game relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function joinGame($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Game');

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
            $this->addJoinObject($join, 'Game');
        }

        return $this;
    }

    /**
     * Use the Game relation Games object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GamesQuery A secondary query class using the current class as primary query
     */
    public function useGameQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGame($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Game', '\GamesQuery');
    }

    /**
     * Filter the query by a related \Hits object
     *
     * @param \Hits|ObjectCollection $hits the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByHitterPlayer($hits, $comparison = null)
    {
        if ($hits instanceof \Hits) {
            return $this
                ->addUsingAlias(PlayersTableMap::COL_ID, $hits->getHitterId(), $comparison);
        } elseif ($hits instanceof ObjectCollection) {
            return $this
                ->useHitterPlayerQuery()
                ->filterByPrimaryKeys($hits->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByHitterPlayer() only accepts arguments of type \Hits or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the HitterPlayer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function joinHitterPlayer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('HitterPlayer');

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
            $this->addJoinObject($join, 'HitterPlayer');
        }

        return $this;
    }

    /**
     * Use the HitterPlayer relation Hits object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \HitsQuery A secondary query class using the current class as primary query
     */
    public function useHitterPlayerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinHitterPlayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'HitterPlayer', '\HitsQuery');
    }

    /**
     * Filter the query by a related \Hits object
     *
     * @param \Hits|ObjectCollection $hits the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByHittedPlayer($hits, $comparison = null)
    {
        if ($hits instanceof \Hits) {
            return $this
                ->addUsingAlias(PlayersTableMap::COL_ID, $hits->getHittedId(), $comparison);
        } elseif ($hits instanceof ObjectCollection) {
            return $this
                ->useHittedPlayerQuery()
                ->filterByPrimaryKeys($hits->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByHittedPlayer() only accepts arguments of type \Hits or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the HittedPlayer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function joinHittedPlayer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('HittedPlayer');

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
            $this->addJoinObject($join, 'HittedPlayer');
        }

        return $this;
    }

    /**
     * Use the HittedPlayer relation Hits object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \HitsQuery A secondary query class using the current class as primary query
     */
    public function useHittedPlayerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinHittedPlayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'HittedPlayer', '\HitsQuery');
    }

    /**
     * Filter the query by a related \Scores object
     *
     * @param \Scores|ObjectCollection $scores the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByScore($scores, $comparison = null)
    {
        if ($scores instanceof \Scores) {
            return $this
                ->addUsingAlias(PlayersTableMap::COL_ID, $scores->getPlayerId(), $comparison);
        } elseif ($scores instanceof ObjectCollection) {
            return $this
                ->useScoreQuery()
                ->filterByPrimaryKeys($scores->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByScore() only accepts arguments of type \Scores or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Score relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function joinScore($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Score');

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
            $this->addJoinObject($join, 'Score');
        }

        return $this;
    }

    /**
     * Use the Score relation Scores object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ScoresQuery A secondary query class using the current class as primary query
     */
    public function useScoreQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinScore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Score', '\ScoresQuery');
    }

    /**
     * Filter the query by a related \Teams object
     *
     * @param \Teams|ObjectCollection $teams the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayersQuery The current query, for fluid interface
     */
    public function filterByTeam($teams, $comparison = null)
    {
        if ($teams instanceof \Teams) {
            return $this
                ->addUsingAlias(PlayersTableMap::COL_ID, $teams->getPlayerId(), $comparison);
        } elseif ($teams instanceof ObjectCollection) {
            return $this
                ->useTeamQuery()
                ->filterByPrimaryKeys($teams->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTeam() only accepts arguments of type \Teams or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Team relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function joinTeam($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Team');

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
            $this->addJoinObject($join, 'Team');
        }

        return $this;
    }

    /**
     * Use the Team relation Teams object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TeamsQuery A secondary query class using the current class as primary query
     */
    public function useTeamQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTeam($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Team', '\TeamsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPlayers $players Object to remove from the list of results
     *
     * @return $this|ChildPlayersQuery The current query, for fluid interface
     */
    public function prune($players = null)
    {
        if ($players) {
            $this->addUsingAlias(PlayersTableMap::COL_ID, $players->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the players table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlayersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PlayersTableMap::clearInstancePool();
            PlayersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PlayersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PlayersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PlayersTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PlayersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PlayersQuery
