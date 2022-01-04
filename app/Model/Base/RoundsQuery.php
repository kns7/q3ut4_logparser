<?php

namespace Base;

use \Rounds as ChildRounds;
use \RoundsQuery as ChildRoundsQuery;
use \Exception;
use \PDO;
use Map\RoundsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'rounds' table.
 *
 *
 *
 * @method     ChildRoundsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRoundsQuery orderByWinner($order = Criteria::ASC) Order by the winner column
 * @method     ChildRoundsQuery orderByRedScore($order = Criteria::ASC) Order by the red_score column
 * @method     ChildRoundsQuery orderByBlueScore($order = Criteria::ASC) Order by the blue_score column
 * @method     ChildRoundsQuery orderByGametypeId($order = Criteria::ASC) Order by the gametype_id column
 * @method     ChildRoundsQuery orderByNbplayers($order = Criteria::ASC) Order by the nbplayers column
 * @method     ChildRoundsQuery orderByWeek($order = Criteria::ASC) Order by the week column
 *
 * @method     ChildRoundsQuery groupById() Group by the id column
 * @method     ChildRoundsQuery groupByWinner() Group by the winner column
 * @method     ChildRoundsQuery groupByRedScore() Group by the red_score column
 * @method     ChildRoundsQuery groupByBlueScore() Group by the blue_score column
 * @method     ChildRoundsQuery groupByGametypeId() Group by the gametype_id column
 * @method     ChildRoundsQuery groupByNbplayers() Group by the nbplayers column
 * @method     ChildRoundsQuery groupByWeek() Group by the week column
 *
 * @method     ChildRoundsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRoundsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRoundsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRoundsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRoundsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRoundsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRoundsQuery leftJoinGametypes($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gametypes relation
 * @method     ChildRoundsQuery rightJoinGametypes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gametypes relation
 * @method     ChildRoundsQuery innerJoinGametypes($relationAlias = null) Adds a INNER JOIN clause to the query using the Gametypes relation
 *
 * @method     ChildRoundsQuery joinWithGametypes($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gametypes relation
 *
 * @method     ChildRoundsQuery leftJoinWithGametypes() Adds a LEFT JOIN clause and with to the query using the Gametypes relation
 * @method     ChildRoundsQuery rightJoinWithGametypes() Adds a RIGHT JOIN clause and with to the query using the Gametypes relation
 * @method     ChildRoundsQuery innerJoinWithGametypes() Adds a INNER JOIN clause and with to the query using the Gametypes relation
 *
 * @method     ChildRoundsQuery leftJoinTeam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Team relation
 * @method     ChildRoundsQuery rightJoinTeam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Team relation
 * @method     ChildRoundsQuery innerJoinTeam($relationAlias = null) Adds a INNER JOIN clause to the query using the Team relation
 *
 * @method     ChildRoundsQuery joinWithTeam($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Team relation
 *
 * @method     ChildRoundsQuery leftJoinWithTeam() Adds a LEFT JOIN clause and with to the query using the Team relation
 * @method     ChildRoundsQuery rightJoinWithTeam() Adds a RIGHT JOIN clause and with to the query using the Team relation
 * @method     ChildRoundsQuery innerJoinWithTeam() Adds a INNER JOIN clause and with to the query using the Team relation
 *
 * @method     \GametypesQuery|\TeamsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRounds findOne(ConnectionInterface $con = null) Return the first ChildRounds matching the query
 * @method     ChildRounds findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRounds matching the query, or a new ChildRounds object populated from the query conditions when no match is found
 *
 * @method     ChildRounds findOneById(int $id) Return the first ChildRounds filtered by the id column
 * @method     ChildRounds findOneByWinner(string $winner) Return the first ChildRounds filtered by the winner column
 * @method     ChildRounds findOneByRedScore(int $red_score) Return the first ChildRounds filtered by the red_score column
 * @method     ChildRounds findOneByBlueScore(int $blue_score) Return the first ChildRounds filtered by the blue_score column
 * @method     ChildRounds findOneByGametypeId(int $gametype_id) Return the first ChildRounds filtered by the gametype_id column
 * @method     ChildRounds findOneByNbplayers(int $nbplayers) Return the first ChildRounds filtered by the nbplayers column
 * @method     ChildRounds findOneByWeek(string $week) Return the first ChildRounds filtered by the week column *

 * @method     ChildRounds requirePk($key, ConnectionInterface $con = null) Return the ChildRounds by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRounds requireOne(ConnectionInterface $con = null) Return the first ChildRounds matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRounds requireOneById(int $id) Return the first ChildRounds filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRounds requireOneByWinner(string $winner) Return the first ChildRounds filtered by the winner column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRounds requireOneByRedScore(int $red_score) Return the first ChildRounds filtered by the red_score column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRounds requireOneByBlueScore(int $blue_score) Return the first ChildRounds filtered by the blue_score column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRounds requireOneByGametypeId(int $gametype_id) Return the first ChildRounds filtered by the gametype_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRounds requireOneByNbplayers(int $nbplayers) Return the first ChildRounds filtered by the nbplayers column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRounds requireOneByWeek(string $week) Return the first ChildRounds filtered by the week column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRounds[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRounds objects based on current ModelCriteria
 * @method     ChildRounds[]|ObjectCollection findById(int $id) Return ChildRounds objects filtered by the id column
 * @method     ChildRounds[]|ObjectCollection findByWinner(string $winner) Return ChildRounds objects filtered by the winner column
 * @method     ChildRounds[]|ObjectCollection findByRedScore(int $red_score) Return ChildRounds objects filtered by the red_score column
 * @method     ChildRounds[]|ObjectCollection findByBlueScore(int $blue_score) Return ChildRounds objects filtered by the blue_score column
 * @method     ChildRounds[]|ObjectCollection findByGametypeId(int $gametype_id) Return ChildRounds objects filtered by the gametype_id column
 * @method     ChildRounds[]|ObjectCollection findByNbplayers(int $nbplayers) Return ChildRounds objects filtered by the nbplayers column
 * @method     ChildRounds[]|ObjectCollection findByWeek(string $week) Return ChildRounds objects filtered by the week column
 * @method     ChildRounds[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RoundsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RoundsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Rounds', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRoundsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRoundsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRoundsQuery) {
            return $criteria;
        }
        $query = new ChildRoundsQuery();
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
     * @return ChildRounds|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RoundsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RoundsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildRounds A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, winner, red_score, blue_score, gametype_id, nbplayers, week FROM rounds WHERE id = :p0';
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
            /** @var ChildRounds $obj */
            $obj = new ChildRounds();
            $obj->hydrate($row);
            RoundsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildRounds|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRoundsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RoundsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRoundsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RoundsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRoundsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RoundsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RoundsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoundsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the winner column
     *
     * Example usage:
     * <code>
     * $query->filterByWinner('fooValue');   // WHERE winner = 'fooValue'
     * $query->filterByWinner('%fooValue%', Criteria::LIKE); // WHERE winner LIKE '%fooValue%'
     * </code>
     *
     * @param     string $winner The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoundsQuery The current query, for fluid interface
     */
    public function filterByWinner($winner = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($winner)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoundsTableMap::COL_WINNER, $winner, $comparison);
    }

    /**
     * Filter the query on the red_score column
     *
     * Example usage:
     * <code>
     * $query->filterByRedScore(1234); // WHERE red_score = 1234
     * $query->filterByRedScore(array(12, 34)); // WHERE red_score IN (12, 34)
     * $query->filterByRedScore(array('min' => 12)); // WHERE red_score > 12
     * </code>
     *
     * @param     mixed $redScore The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoundsQuery The current query, for fluid interface
     */
    public function filterByRedScore($redScore = null, $comparison = null)
    {
        if (is_array($redScore)) {
            $useMinMax = false;
            if (isset($redScore['min'])) {
                $this->addUsingAlias(RoundsTableMap::COL_RED_SCORE, $redScore['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($redScore['max'])) {
                $this->addUsingAlias(RoundsTableMap::COL_RED_SCORE, $redScore['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoundsTableMap::COL_RED_SCORE, $redScore, $comparison);
    }

    /**
     * Filter the query on the blue_score column
     *
     * Example usage:
     * <code>
     * $query->filterByBlueScore(1234); // WHERE blue_score = 1234
     * $query->filterByBlueScore(array(12, 34)); // WHERE blue_score IN (12, 34)
     * $query->filterByBlueScore(array('min' => 12)); // WHERE blue_score > 12
     * </code>
     *
     * @param     mixed $blueScore The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoundsQuery The current query, for fluid interface
     */
    public function filterByBlueScore($blueScore = null, $comparison = null)
    {
        if (is_array($blueScore)) {
            $useMinMax = false;
            if (isset($blueScore['min'])) {
                $this->addUsingAlias(RoundsTableMap::COL_BLUE_SCORE, $blueScore['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($blueScore['max'])) {
                $this->addUsingAlias(RoundsTableMap::COL_BLUE_SCORE, $blueScore['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoundsTableMap::COL_BLUE_SCORE, $blueScore, $comparison);
    }

    /**
     * Filter the query on the gametype_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGametypeId(1234); // WHERE gametype_id = 1234
     * $query->filterByGametypeId(array(12, 34)); // WHERE gametype_id IN (12, 34)
     * $query->filterByGametypeId(array('min' => 12)); // WHERE gametype_id > 12
     * </code>
     *
     * @see       filterByGametypes()
     *
     * @param     mixed $gametypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoundsQuery The current query, for fluid interface
     */
    public function filterByGametypeId($gametypeId = null, $comparison = null)
    {
        if (is_array($gametypeId)) {
            $useMinMax = false;
            if (isset($gametypeId['min'])) {
                $this->addUsingAlias(RoundsTableMap::COL_GAMETYPE_ID, $gametypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gametypeId['max'])) {
                $this->addUsingAlias(RoundsTableMap::COL_GAMETYPE_ID, $gametypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoundsTableMap::COL_GAMETYPE_ID, $gametypeId, $comparison);
    }

    /**
     * Filter the query on the nbplayers column
     *
     * Example usage:
     * <code>
     * $query->filterByNbplayers(1234); // WHERE nbplayers = 1234
     * $query->filterByNbplayers(array(12, 34)); // WHERE nbplayers IN (12, 34)
     * $query->filterByNbplayers(array('min' => 12)); // WHERE nbplayers > 12
     * </code>
     *
     * @param     mixed $nbplayers The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoundsQuery The current query, for fluid interface
     */
    public function filterByNbplayers($nbplayers = null, $comparison = null)
    {
        if (is_array($nbplayers)) {
            $useMinMax = false;
            if (isset($nbplayers['min'])) {
                $this->addUsingAlias(RoundsTableMap::COL_NBPLAYERS, $nbplayers['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nbplayers['max'])) {
                $this->addUsingAlias(RoundsTableMap::COL_NBPLAYERS, $nbplayers['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoundsTableMap::COL_NBPLAYERS, $nbplayers, $comparison);
    }

    /**
     * Filter the query on the week column
     *
     * Example usage:
     * <code>
     * $query->filterByWeek('fooValue');   // WHERE week = 'fooValue'
     * $query->filterByWeek('%fooValue%', Criteria::LIKE); // WHERE week LIKE '%fooValue%'
     * </code>
     *
     * @param     string $week The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoundsQuery The current query, for fluid interface
     */
    public function filterByWeek($week = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($week)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoundsTableMap::COL_WEEK, $week, $comparison);
    }

    /**
     * Filter the query by a related \Gametypes object
     *
     * @param \Gametypes|ObjectCollection $gametypes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRoundsQuery The current query, for fluid interface
     */
    public function filterByGametypes($gametypes, $comparison = null)
    {
        if ($gametypes instanceof \Gametypes) {
            return $this
                ->addUsingAlias(RoundsTableMap::COL_GAMETYPE_ID, $gametypes->getId(), $comparison);
        } elseif ($gametypes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RoundsTableMap::COL_GAMETYPE_ID, $gametypes->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGametypes() only accepts arguments of type \Gametypes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gametypes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRoundsQuery The current query, for fluid interface
     */
    public function joinGametypes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gametypes');

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
            $this->addJoinObject($join, 'Gametypes');
        }

        return $this;
    }

    /**
     * Use the Gametypes relation Gametypes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GametypesQuery A secondary query class using the current class as primary query
     */
    public function useGametypesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGametypes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gametypes', '\GametypesQuery');
    }

    /**
     * Filter the query by a related \Teams object
     *
     * @param \Teams|ObjectCollection $teams the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRoundsQuery The current query, for fluid interface
     */
    public function filterByTeam($teams, $comparison = null)
    {
        if ($teams instanceof \Teams) {
            return $this
                ->addUsingAlias(RoundsTableMap::COL_ID, $teams->getRoundId(), $comparison);
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
     * @return $this|ChildRoundsQuery The current query, for fluid interface
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
     * @param   ChildRounds $rounds Object to remove from the list of results
     *
     * @return $this|ChildRoundsQuery The current query, for fluid interface
     */
    public function prune($rounds = null)
    {
        if ($rounds) {
            $this->addUsingAlias(RoundsTableMap::COL_ID, $rounds->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the rounds table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RoundsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RoundsTableMap::clearInstancePool();
            RoundsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RoundsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RoundsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RoundsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RoundsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RoundsQuery
