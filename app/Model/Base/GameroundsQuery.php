<?php

namespace Base;

use \Gamerounds as ChildGamerounds;
use \GameroundsQuery as ChildGameroundsQuery;
use \Exception;
use \PDO;
use Map\GameroundsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'gamerounds' table.
 *
 *
 *
 * @method     ChildGameroundsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGameroundsQuery orderByRoundNB($order = Criteria::ASC) Order by the roundnb column
 * @method     ChildGameroundsQuery orderByGameID($order = Criteria::ASC) Order by the game_id column
 * @method     ChildGameroundsQuery orderByHalf($order = Criteria::ASC) Order by the half column
 * @method     ChildGameroundsQuery orderByCreated($order = Criteria::ASC) Order by the created column
 *
 * @method     ChildGameroundsQuery groupById() Group by the id column
 * @method     ChildGameroundsQuery groupByRoundNB() Group by the roundnb column
 * @method     ChildGameroundsQuery groupByGameID() Group by the game_id column
 * @method     ChildGameroundsQuery groupByHalf() Group by the half column
 * @method     ChildGameroundsQuery groupByCreated() Group by the created column
 *
 * @method     ChildGameroundsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGameroundsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGameroundsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGameroundsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGameroundsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGameroundsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGameroundsQuery leftJoinGames($relationAlias = null) Adds a LEFT JOIN clause to the query using the Games relation
 * @method     ChildGameroundsQuery rightJoinGames($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Games relation
 * @method     ChildGameroundsQuery innerJoinGames($relationAlias = null) Adds a INNER JOIN clause to the query using the Games relation
 *
 * @method     ChildGameroundsQuery joinWithGames($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Games relation
 *
 * @method     ChildGameroundsQuery leftJoinWithGames() Adds a LEFT JOIN clause and with to the query using the Games relation
 * @method     ChildGameroundsQuery rightJoinWithGames() Adds a RIGHT JOIN clause and with to the query using the Games relation
 * @method     ChildGameroundsQuery innerJoinWithGames() Adds a INNER JOIN clause and with to the query using the Games relation
 *
 * @method     ChildGameroundsQuery leftJoinBomb($relationAlias = null) Adds a LEFT JOIN clause to the query using the Bomb relation
 * @method     ChildGameroundsQuery rightJoinBomb($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Bomb relation
 * @method     ChildGameroundsQuery innerJoinBomb($relationAlias = null) Adds a INNER JOIN clause to the query using the Bomb relation
 *
 * @method     ChildGameroundsQuery joinWithBomb($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Bomb relation
 *
 * @method     ChildGameroundsQuery leftJoinWithBomb() Adds a LEFT JOIN clause and with to the query using the Bomb relation
 * @method     ChildGameroundsQuery rightJoinWithBomb() Adds a RIGHT JOIN clause and with to the query using the Bomb relation
 * @method     ChildGameroundsQuery innerJoinWithBomb() Adds a INNER JOIN clause and with to the query using the Bomb relation
 *
 * @method     ChildGameroundsQuery leftJoinFlag($relationAlias = null) Adds a LEFT JOIN clause to the query using the Flag relation
 * @method     ChildGameroundsQuery rightJoinFlag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Flag relation
 * @method     ChildGameroundsQuery innerJoinFlag($relationAlias = null) Adds a INNER JOIN clause to the query using the Flag relation
 *
 * @method     ChildGameroundsQuery joinWithFlag($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Flag relation
 *
 * @method     ChildGameroundsQuery leftJoinWithFlag() Adds a LEFT JOIN clause and with to the query using the Flag relation
 * @method     ChildGameroundsQuery rightJoinWithFlag() Adds a RIGHT JOIN clause and with to the query using the Flag relation
 * @method     ChildGameroundsQuery innerJoinWithFlag() Adds a INNER JOIN clause and with to the query using the Flag relation
 *
 * @method     ChildGameroundsQuery leftJoinFrag($relationAlias = null) Adds a LEFT JOIN clause to the query using the Frag relation
 * @method     ChildGameroundsQuery rightJoinFrag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Frag relation
 * @method     ChildGameroundsQuery innerJoinFrag($relationAlias = null) Adds a INNER JOIN clause to the query using the Frag relation
 *
 * @method     ChildGameroundsQuery joinWithFrag($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Frag relation
 *
 * @method     ChildGameroundsQuery leftJoinWithFrag() Adds a LEFT JOIN clause and with to the query using the Frag relation
 * @method     ChildGameroundsQuery rightJoinWithFrag() Adds a RIGHT JOIN clause and with to the query using the Frag relation
 * @method     ChildGameroundsQuery innerJoinWithFrag() Adds a INNER JOIN clause and with to the query using the Frag relation
 *
 * @method     ChildGameroundsQuery leftJoinHit($relationAlias = null) Adds a LEFT JOIN clause to the query using the Hit relation
 * @method     ChildGameroundsQuery rightJoinHit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Hit relation
 * @method     ChildGameroundsQuery innerJoinHit($relationAlias = null) Adds a INNER JOIN clause to the query using the Hit relation
 *
 * @method     ChildGameroundsQuery joinWithHit($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Hit relation
 *
 * @method     ChildGameroundsQuery leftJoinWithHit() Adds a LEFT JOIN clause and with to the query using the Hit relation
 * @method     ChildGameroundsQuery rightJoinWithHit() Adds a RIGHT JOIN clause and with to the query using the Hit relation
 * @method     ChildGameroundsQuery innerJoinWithHit() Adds a INNER JOIN clause and with to the query using the Hit relation
 *
 * @method     \GamesQuery|\BombsQuery|\FlagsQuery|\FragsQuery|\HitsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGamerounds findOne(ConnectionInterface $con = null) Return the first ChildGamerounds matching the query
 * @method     ChildGamerounds findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGamerounds matching the query, or a new ChildGamerounds object populated from the query conditions when no match is found
 *
 * @method     ChildGamerounds findOneById(int $id) Return the first ChildGamerounds filtered by the id column
 * @method     ChildGamerounds findOneByRoundNB(int $roundnb) Return the first ChildGamerounds filtered by the roundnb column
 * @method     ChildGamerounds findOneByGameID(int $game_id) Return the first ChildGamerounds filtered by the game_id column
 * @method     ChildGamerounds findOneByHalf(int $half) Return the first ChildGamerounds filtered by the half column
 * @method     ChildGamerounds findOneByCreated(string $created) Return the first ChildGamerounds filtered by the created column *

 * @method     ChildGamerounds requirePk($key, ConnectionInterface $con = null) Return the ChildGamerounds by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamerounds requireOne(ConnectionInterface $con = null) Return the first ChildGamerounds matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGamerounds requireOneById(int $id) Return the first ChildGamerounds filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamerounds requireOneByRoundNB(int $roundnb) Return the first ChildGamerounds filtered by the roundnb column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamerounds requireOneByGameID(int $game_id) Return the first ChildGamerounds filtered by the game_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamerounds requireOneByHalf(int $half) Return the first ChildGamerounds filtered by the half column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamerounds requireOneByCreated(string $created) Return the first ChildGamerounds filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGamerounds[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGamerounds objects based on current ModelCriteria
 * @method     ChildGamerounds[]|ObjectCollection findById(int $id) Return ChildGamerounds objects filtered by the id column
 * @method     ChildGamerounds[]|ObjectCollection findByRoundNB(int $roundnb) Return ChildGamerounds objects filtered by the roundnb column
 * @method     ChildGamerounds[]|ObjectCollection findByGameID(int $game_id) Return ChildGamerounds objects filtered by the game_id column
 * @method     ChildGamerounds[]|ObjectCollection findByHalf(int $half) Return ChildGamerounds objects filtered by the half column
 * @method     ChildGamerounds[]|ObjectCollection findByCreated(string $created) Return ChildGamerounds objects filtered by the created column
 * @method     ChildGamerounds[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GameroundsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GameroundsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Gamerounds', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGameroundsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGameroundsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGameroundsQuery) {
            return $criteria;
        }
        $query = new ChildGameroundsQuery();
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
     * @return ChildGamerounds|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GameroundsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GameroundsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGamerounds A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, roundnb, game_id, half, created FROM gamerounds WHERE id = :p0';
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
            /** @var ChildGamerounds $obj */
            $obj = new ChildGamerounds();
            $obj->hydrate($row);
            GameroundsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGamerounds|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GameroundsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GameroundsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GameroundsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GameroundsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameroundsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the roundnb column
     *
     * Example usage:
     * <code>
     * $query->filterByRoundNB(1234); // WHERE roundnb = 1234
     * $query->filterByRoundNB(array(12, 34)); // WHERE roundnb IN (12, 34)
     * $query->filterByRoundNB(array('min' => 12)); // WHERE roundnb > 12
     * </code>
     *
     * @param     mixed $roundNB The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterByRoundNB($roundNB = null, $comparison = null)
    {
        if (is_array($roundNB)) {
            $useMinMax = false;
            if (isset($roundNB['min'])) {
                $this->addUsingAlias(GameroundsTableMap::COL_ROUNDNB, $roundNB['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roundNB['max'])) {
                $this->addUsingAlias(GameroundsTableMap::COL_ROUNDNB, $roundNB['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameroundsTableMap::COL_ROUNDNB, $roundNB, $comparison);
    }

    /**
     * Filter the query on the game_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGameID(1234); // WHERE game_id = 1234
     * $query->filterByGameID(array(12, 34)); // WHERE game_id IN (12, 34)
     * $query->filterByGameID(array('min' => 12)); // WHERE game_id > 12
     * </code>
     *
     * @see       filterByGames()
     *
     * @param     mixed $gameID The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterByGameID($gameID = null, $comparison = null)
    {
        if (is_array($gameID)) {
            $useMinMax = false;
            if (isset($gameID['min'])) {
                $this->addUsingAlias(GameroundsTableMap::COL_GAME_ID, $gameID['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameID['max'])) {
                $this->addUsingAlias(GameroundsTableMap::COL_GAME_ID, $gameID['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameroundsTableMap::COL_GAME_ID, $gameID, $comparison);
    }

    /**
     * Filter the query on the half column
     *
     * Example usage:
     * <code>
     * $query->filterByHalf(1234); // WHERE half = 1234
     * $query->filterByHalf(array(12, 34)); // WHERE half IN (12, 34)
     * $query->filterByHalf(array('min' => 12)); // WHERE half > 12
     * </code>
     *
     * @param     mixed $half The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterByHalf($half = null, $comparison = null)
    {
        if (is_array($half)) {
            $useMinMax = false;
            if (isset($half['min'])) {
                $this->addUsingAlias(GameroundsTableMap::COL_HALF, $half['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($half['max'])) {
                $this->addUsingAlias(GameroundsTableMap::COL_HALF, $half['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameroundsTableMap::COL_HALF, $half, $comparison);
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
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(GameroundsTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(GameroundsTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameroundsTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query by a related \Games object
     *
     * @param \Games|ObjectCollection $games The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterByGames($games, $comparison = null)
    {
        if ($games instanceof \Games) {
            return $this
                ->addUsingAlias(GameroundsTableMap::COL_GAME_ID, $games->getId(), $comparison);
        } elseif ($games instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GameroundsTableMap::COL_GAME_ID, $games->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGames() only accepts arguments of type \Games or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Games relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
     */
    public function joinGames($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Games');

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
            $this->addJoinObject($join, 'Games');
        }

        return $this;
    }

    /**
     * Use the Games relation Games object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GamesQuery A secondary query class using the current class as primary query
     */
    public function useGamesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGames($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Games', '\GamesQuery');
    }

    /**
     * Filter the query by a related \Bombs object
     *
     * @param \Bombs|ObjectCollection $bombs the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterByBomb($bombs, $comparison = null)
    {
        if ($bombs instanceof \Bombs) {
            return $this
                ->addUsingAlias(GameroundsTableMap::COL_ID, $bombs->getRoundId(), $comparison);
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
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
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
     * @return ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterByFlag($flags, $comparison = null)
    {
        if ($flags instanceof \Flags) {
            return $this
                ->addUsingAlias(GameroundsTableMap::COL_ID, $flags->getRoundId(), $comparison);
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
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
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
     * @return ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterByFrag($frags, $comparison = null)
    {
        if ($frags instanceof \Frags) {
            return $this
                ->addUsingAlias(GameroundsTableMap::COL_ID, $frags->getRoundId(), $comparison);
        } elseif ($frags instanceof ObjectCollection) {
            return $this
                ->useFragQuery()
                ->filterByPrimaryKeys($frags->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFrag() only accepts arguments of type \Frags or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Frag relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
     */
    public function joinFrag($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Frag');

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
            $this->addJoinObject($join, 'Frag');
        }

        return $this;
    }

    /**
     * Use the Frag relation Frags object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FragsQuery A secondary query class using the current class as primary query
     */
    public function useFragQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFrag($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Frag', '\FragsQuery');
    }

    /**
     * Filter the query by a related \Hits object
     *
     * @param \Hits|ObjectCollection $hits the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameroundsQuery The current query, for fluid interface
     */
    public function filterByHit($hits, $comparison = null)
    {
        if ($hits instanceof \Hits) {
            return $this
                ->addUsingAlias(GameroundsTableMap::COL_ID, $hits->getRoundId(), $comparison);
        } elseif ($hits instanceof ObjectCollection) {
            return $this
                ->useHitQuery()
                ->filterByPrimaryKeys($hits->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByHit() only accepts arguments of type \Hits or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Hit relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
     */
    public function joinHit($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Hit');

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
            $this->addJoinObject($join, 'Hit');
        }

        return $this;
    }

    /**
     * Use the Hit relation Hits object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \HitsQuery A secondary query class using the current class as primary query
     */
    public function useHitQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinHit($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Hit', '\HitsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGamerounds $gamerounds Object to remove from the list of results
     *
     * @return $this|ChildGameroundsQuery The current query, for fluid interface
     */
    public function prune($gamerounds = null)
    {
        if ($gamerounds) {
            $this->addUsingAlias(GameroundsTableMap::COL_ID, $gamerounds->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the gamerounds table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameroundsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GameroundsTableMap::clearInstancePool();
            GameroundsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GameroundsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GameroundsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GameroundsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GameroundsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GameroundsQuery
