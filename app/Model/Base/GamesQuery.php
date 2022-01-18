<?php

namespace Base;

use \Games as ChildGames;
use \GamesQuery as ChildGamesQuery;
use \Exception;
use \PDO;
use Map\GamesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'games' table.
 *
 *
 *
 * @method     ChildGamesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGamesQuery orderByGameNB($order = Criteria::ASC) Order by the gamenb column
 * @method     ChildGamesQuery orderByMapId($order = Criteria::ASC) Order by the map_id column
 * @method     ChildGamesQuery orderByGametypeId($order = Criteria::ASC) Order by the gametype_id column
 * @method     ChildGamesQuery orderByTimelimit($order = Criteria::ASC) Order by the timelimit column
 * @method     ChildGamesQuery orderByRoundtime($order = Criteria::ASC) Order by the roundtime column
 * @method     ChildGamesQuery orderByNbplayers($order = Criteria::ASC) Order by the nbplayers column
 * @method     ChildGamesQuery orderByRedScore($order = Criteria::ASC) Order by the redscore column
 * @method     ChildGamesQuery orderByBlueScore($order = Criteria::ASC) Order by the bluescore column
 * @method     ChildGamesQuery orderByRedScore2($order = Criteria::ASC) Order by the redscore2 column
 * @method     ChildGamesQuery orderByBlueScore2($order = Criteria::ASC) Order by the bluescore2 column
 * @method     ChildGamesQuery orderByCreated($order = Criteria::ASC) Order by the created column
 *
 * @method     ChildGamesQuery groupById() Group by the id column
 * @method     ChildGamesQuery groupByGameNB() Group by the gamenb column
 * @method     ChildGamesQuery groupByMapId() Group by the map_id column
 * @method     ChildGamesQuery groupByGametypeId() Group by the gametype_id column
 * @method     ChildGamesQuery groupByTimelimit() Group by the timelimit column
 * @method     ChildGamesQuery groupByRoundtime() Group by the roundtime column
 * @method     ChildGamesQuery groupByNbplayers() Group by the nbplayers column
 * @method     ChildGamesQuery groupByRedScore() Group by the redscore column
 * @method     ChildGamesQuery groupByBlueScore() Group by the bluescore column
 * @method     ChildGamesQuery groupByRedScore2() Group by the redscore2 column
 * @method     ChildGamesQuery groupByBlueScore2() Group by the bluescore2 column
 * @method     ChildGamesQuery groupByCreated() Group by the created column
 *
 * @method     ChildGamesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGamesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGamesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGamesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGamesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGamesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGamesQuery leftJoinMaps($relationAlias = null) Adds a LEFT JOIN clause to the query using the Maps relation
 * @method     ChildGamesQuery rightJoinMaps($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Maps relation
 * @method     ChildGamesQuery innerJoinMaps($relationAlias = null) Adds a INNER JOIN clause to the query using the Maps relation
 *
 * @method     ChildGamesQuery joinWithMaps($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Maps relation
 *
 * @method     ChildGamesQuery leftJoinWithMaps() Adds a LEFT JOIN clause and with to the query using the Maps relation
 * @method     ChildGamesQuery rightJoinWithMaps() Adds a RIGHT JOIN clause and with to the query using the Maps relation
 * @method     ChildGamesQuery innerJoinWithMaps() Adds a INNER JOIN clause and with to the query using the Maps relation
 *
 * @method     ChildGamesQuery leftJoinGamestypes($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gamestypes relation
 * @method     ChildGamesQuery rightJoinGamestypes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gamestypes relation
 * @method     ChildGamesQuery innerJoinGamestypes($relationAlias = null) Adds a INNER JOIN clause to the query using the Gamestypes relation
 *
 * @method     ChildGamesQuery joinWithGamestypes($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gamestypes relation
 *
 * @method     ChildGamesQuery leftJoinWithGamestypes() Adds a LEFT JOIN clause and with to the query using the Gamestypes relation
 * @method     ChildGamesQuery rightJoinWithGamestypes() Adds a RIGHT JOIN clause and with to the query using the Gamestypes relation
 * @method     ChildGamesQuery innerJoinWithGamestypes() Adds a INNER JOIN clause and with to the query using the Gamestypes relation
 *
 * @method     ChildGamesQuery leftJoinRound($relationAlias = null) Adds a LEFT JOIN clause to the query using the Round relation
 * @method     ChildGamesQuery rightJoinRound($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Round relation
 * @method     ChildGamesQuery innerJoinRound($relationAlias = null) Adds a INNER JOIN clause to the query using the Round relation
 *
 * @method     ChildGamesQuery joinWithRound($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Round relation
 *
 * @method     ChildGamesQuery leftJoinWithRound() Adds a LEFT JOIN clause and with to the query using the Round relation
 * @method     ChildGamesQuery rightJoinWithRound() Adds a RIGHT JOIN clause and with to the query using the Round relation
 * @method     ChildGamesQuery innerJoinWithRound() Adds a INNER JOIN clause and with to the query using the Round relation
 *
 * @method     ChildGamesQuery leftJoinScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the Score relation
 * @method     ChildGamesQuery rightJoinScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Score relation
 * @method     ChildGamesQuery innerJoinScore($relationAlias = null) Adds a INNER JOIN clause to the query using the Score relation
 *
 * @method     ChildGamesQuery joinWithScore($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Score relation
 *
 * @method     ChildGamesQuery leftJoinWithScore() Adds a LEFT JOIN clause and with to the query using the Score relation
 * @method     ChildGamesQuery rightJoinWithScore() Adds a RIGHT JOIN clause and with to the query using the Score relation
 * @method     ChildGamesQuery innerJoinWithScore() Adds a INNER JOIN clause and with to the query using the Score relation
 *
 * @method     \MapsQuery|\GametypesQuery|\GameroundsQuery|\GamescoresQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGames|null findOne(ConnectionInterface $con = null) Return the first ChildGames matching the query
 * @method     ChildGames findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGames matching the query, or a new ChildGames object populated from the query conditions when no match is found
 *
 * @method     ChildGames|null findOneById(int $id) Return the first ChildGames filtered by the id column
 * @method     ChildGames|null findOneByGameNB(int $gamenb) Return the first ChildGames filtered by the gamenb column
 * @method     ChildGames|null findOneByMapId(int $map_id) Return the first ChildGames filtered by the map_id column
 * @method     ChildGames|null findOneByGametypeId(int $gametype_id) Return the first ChildGames filtered by the gametype_id column
 * @method     ChildGames|null findOneByTimelimit(int $timelimit) Return the first ChildGames filtered by the timelimit column
 * @method     ChildGames|null findOneByRoundtime(int $roundtime) Return the first ChildGames filtered by the roundtime column
 * @method     ChildGames|null findOneByNbplayers(int $nbplayers) Return the first ChildGames filtered by the nbplayers column
 * @method     ChildGames|null findOneByRedScore(int $redscore) Return the first ChildGames filtered by the redscore column
 * @method     ChildGames|null findOneByBlueScore(int $bluescore) Return the first ChildGames filtered by the bluescore column
 * @method     ChildGames|null findOneByRedScore2(int $redscore2) Return the first ChildGames filtered by the redscore2 column
 * @method     ChildGames|null findOneByBlueScore2(int $bluescore2) Return the first ChildGames filtered by the bluescore2 column
 * @method     ChildGames|null findOneByCreated(string $created) Return the first ChildGames filtered by the created column *

 * @method     ChildGames requirePk($key, ConnectionInterface $con = null) Return the ChildGames by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOne(ConnectionInterface $con = null) Return the first ChildGames matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGames requireOneById(int $id) Return the first ChildGames filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByGameNB(int $gamenb) Return the first ChildGames filtered by the gamenb column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByMapId(int $map_id) Return the first ChildGames filtered by the map_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByGametypeId(int $gametype_id) Return the first ChildGames filtered by the gametype_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByTimelimit(int $timelimit) Return the first ChildGames filtered by the timelimit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByRoundtime(int $roundtime) Return the first ChildGames filtered by the roundtime column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByNbplayers(int $nbplayers) Return the first ChildGames filtered by the nbplayers column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByRedScore(int $redscore) Return the first ChildGames filtered by the redscore column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByBlueScore(int $bluescore) Return the first ChildGames filtered by the bluescore column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByRedScore2(int $redscore2) Return the first ChildGames filtered by the redscore2 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByBlueScore2(int $bluescore2) Return the first ChildGames filtered by the bluescore2 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGames requireOneByCreated(string $created) Return the first ChildGames filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGames[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGames objects based on current ModelCriteria
 * @psalm-method ObjectCollection&\Traversable<ChildGames> find(ConnectionInterface $con = null) Return ChildGames objects based on current ModelCriteria
 * @method     ChildGames[]|ObjectCollection findById(int $id) Return ChildGames objects filtered by the id column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findById(int $id) Return ChildGames objects filtered by the id column
 * @method     ChildGames[]|ObjectCollection findByGameNB(int $gamenb) Return ChildGames objects filtered by the gamenb column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findByGameNB(int $gamenb) Return ChildGames objects filtered by the gamenb column
 * @method     ChildGames[]|ObjectCollection findByMapId(int $map_id) Return ChildGames objects filtered by the map_id column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findByMapId(int $map_id) Return ChildGames objects filtered by the map_id column
 * @method     ChildGames[]|ObjectCollection findByGametypeId(int $gametype_id) Return ChildGames objects filtered by the gametype_id column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findByGametypeId(int $gametype_id) Return ChildGames objects filtered by the gametype_id column
 * @method     ChildGames[]|ObjectCollection findByTimelimit(int $timelimit) Return ChildGames objects filtered by the timelimit column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findByTimelimit(int $timelimit) Return ChildGames objects filtered by the timelimit column
 * @method     ChildGames[]|ObjectCollection findByRoundtime(int $roundtime) Return ChildGames objects filtered by the roundtime column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findByRoundtime(int $roundtime) Return ChildGames objects filtered by the roundtime column
 * @method     ChildGames[]|ObjectCollection findByNbplayers(int $nbplayers) Return ChildGames objects filtered by the nbplayers column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findByNbplayers(int $nbplayers) Return ChildGames objects filtered by the nbplayers column
 * @method     ChildGames[]|ObjectCollection findByRedScore(int $redscore) Return ChildGames objects filtered by the redscore column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findByRedScore(int $redscore) Return ChildGames objects filtered by the redscore column
 * @method     ChildGames[]|ObjectCollection findByBlueScore(int $bluescore) Return ChildGames objects filtered by the bluescore column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findByBlueScore(int $bluescore) Return ChildGames objects filtered by the bluescore column
 * @method     ChildGames[]|ObjectCollection findByRedScore2(int $redscore2) Return ChildGames objects filtered by the redscore2 column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findByRedScore2(int $redscore2) Return ChildGames objects filtered by the redscore2 column
 * @method     ChildGames[]|ObjectCollection findByBlueScore2(int $bluescore2) Return ChildGames objects filtered by the bluescore2 column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findByBlueScore2(int $bluescore2) Return ChildGames objects filtered by the bluescore2 column
 * @method     ChildGames[]|ObjectCollection findByCreated(string $created) Return ChildGames objects filtered by the created column
 * @psalm-method ObjectCollection&\Traversable<ChildGames> findByCreated(string $created) Return ChildGames objects filtered by the created column
 * @method     ChildGames[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildGames> paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GamesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GamesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Games', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGamesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGamesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGamesQuery) {
            return $criteria;
        }
        $query = new ChildGamesQuery();
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
     * @return ChildGames|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GamesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GamesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGames A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, gamenb, map_id, gametype_id, timelimit, roundtime, nbplayers, redscore, bluescore, redscore2, bluescore2, created FROM games WHERE id = :p0';
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
            /** @var ChildGames $obj */
            $obj = new ChildGames();
            $obj->hydrate($row);
            GamesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGames|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GamesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GamesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the gamenb column
     *
     * Example usage:
     * <code>
     * $query->filterByGameNB(1234); // WHERE gamenb = 1234
     * $query->filterByGameNB(array(12, 34)); // WHERE gamenb IN (12, 34)
     * $query->filterByGameNB(array('min' => 12)); // WHERE gamenb > 12
     * </code>
     *
     * @param     mixed $gameNB The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByGameNB($gameNB = null, $comparison = null)
    {
        if (is_array($gameNB)) {
            $useMinMax = false;
            if (isset($gameNB['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_GAMENB, $gameNB['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameNB['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_GAMENB, $gameNB['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_GAMENB, $gameNB, $comparison);
    }

    /**
     * Filter the query on the map_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMapId(1234); // WHERE map_id = 1234
     * $query->filterByMapId(array(12, 34)); // WHERE map_id IN (12, 34)
     * $query->filterByMapId(array('min' => 12)); // WHERE map_id > 12
     * </code>
     *
     * @see       filterByMaps()
     *
     * @param     mixed $mapId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByMapId($mapId = null, $comparison = null)
    {
        if (is_array($mapId)) {
            $useMinMax = false;
            if (isset($mapId['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_MAP_ID, $mapId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mapId['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_MAP_ID, $mapId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_MAP_ID, $mapId, $comparison);
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
     * @see       filterByGamestypes()
     *
     * @param     mixed $gametypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByGametypeId($gametypeId = null, $comparison = null)
    {
        if (is_array($gametypeId)) {
            $useMinMax = false;
            if (isset($gametypeId['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_GAMETYPE_ID, $gametypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gametypeId['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_GAMETYPE_ID, $gametypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_GAMETYPE_ID, $gametypeId, $comparison);
    }

    /**
     * Filter the query on the timelimit column
     *
     * Example usage:
     * <code>
     * $query->filterByTimelimit(1234); // WHERE timelimit = 1234
     * $query->filterByTimelimit(array(12, 34)); // WHERE timelimit IN (12, 34)
     * $query->filterByTimelimit(array('min' => 12)); // WHERE timelimit > 12
     * </code>
     *
     * @param     mixed $timelimit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByTimelimit($timelimit = null, $comparison = null)
    {
        if (is_array($timelimit)) {
            $useMinMax = false;
            if (isset($timelimit['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_TIMELIMIT, $timelimit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timelimit['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_TIMELIMIT, $timelimit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_TIMELIMIT, $timelimit, $comparison);
    }

    /**
     * Filter the query on the roundtime column
     *
     * Example usage:
     * <code>
     * $query->filterByRoundtime(1234); // WHERE roundtime = 1234
     * $query->filterByRoundtime(array(12, 34)); // WHERE roundtime IN (12, 34)
     * $query->filterByRoundtime(array('min' => 12)); // WHERE roundtime > 12
     * </code>
     *
     * @param     mixed $roundtime The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByRoundtime($roundtime = null, $comparison = null)
    {
        if (is_array($roundtime)) {
            $useMinMax = false;
            if (isset($roundtime['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_ROUNDTIME, $roundtime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roundtime['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_ROUNDTIME, $roundtime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_ROUNDTIME, $roundtime, $comparison);
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
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByNbplayers($nbplayers = null, $comparison = null)
    {
        if (is_array($nbplayers)) {
            $useMinMax = false;
            if (isset($nbplayers['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_NBPLAYERS, $nbplayers['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nbplayers['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_NBPLAYERS, $nbplayers['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_NBPLAYERS, $nbplayers, $comparison);
    }

    /**
     * Filter the query on the redscore column
     *
     * Example usage:
     * <code>
     * $query->filterByRedScore(1234); // WHERE redscore = 1234
     * $query->filterByRedScore(array(12, 34)); // WHERE redscore IN (12, 34)
     * $query->filterByRedScore(array('min' => 12)); // WHERE redscore > 12
     * </code>
     *
     * @param     mixed $redScore The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByRedScore($redScore = null, $comparison = null)
    {
        if (is_array($redScore)) {
            $useMinMax = false;
            if (isset($redScore['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_REDSCORE, $redScore['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($redScore['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_REDSCORE, $redScore['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_REDSCORE, $redScore, $comparison);
    }

    /**
     * Filter the query on the bluescore column
     *
     * Example usage:
     * <code>
     * $query->filterByBlueScore(1234); // WHERE bluescore = 1234
     * $query->filterByBlueScore(array(12, 34)); // WHERE bluescore IN (12, 34)
     * $query->filterByBlueScore(array('min' => 12)); // WHERE bluescore > 12
     * </code>
     *
     * @param     mixed $blueScore The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByBlueScore($blueScore = null, $comparison = null)
    {
        if (is_array($blueScore)) {
            $useMinMax = false;
            if (isset($blueScore['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_BLUESCORE, $blueScore['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($blueScore['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_BLUESCORE, $blueScore['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_BLUESCORE, $blueScore, $comparison);
    }

    /**
     * Filter the query on the redscore2 column
     *
     * Example usage:
     * <code>
     * $query->filterByRedScore2(1234); // WHERE redscore2 = 1234
     * $query->filterByRedScore2(array(12, 34)); // WHERE redscore2 IN (12, 34)
     * $query->filterByRedScore2(array('min' => 12)); // WHERE redscore2 > 12
     * </code>
     *
     * @param     mixed $redScore2 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByRedScore2($redScore2 = null, $comparison = null)
    {
        if (is_array($redScore2)) {
            $useMinMax = false;
            if (isset($redScore2['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_REDSCORE2, $redScore2['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($redScore2['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_REDSCORE2, $redScore2['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_REDSCORE2, $redScore2, $comparison);
    }

    /**
     * Filter the query on the bluescore2 column
     *
     * Example usage:
     * <code>
     * $query->filterByBlueScore2(1234); // WHERE bluescore2 = 1234
     * $query->filterByBlueScore2(array(12, 34)); // WHERE bluescore2 IN (12, 34)
     * $query->filterByBlueScore2(array('min' => 12)); // WHERE bluescore2 > 12
     * </code>
     *
     * @param     mixed $blueScore2 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByBlueScore2($blueScore2 = null, $comparison = null)
    {
        if (is_array($blueScore2)) {
            $useMinMax = false;
            if (isset($blueScore2['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_BLUESCORE2, $blueScore2['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($blueScore2['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_BLUESCORE2, $blueScore2['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_BLUESCORE2, $blueScore2, $comparison);
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
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(GamesTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(GamesTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamesTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query by a related \Maps object
     *
     * @param \Maps|ObjectCollection $maps The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGamesQuery The current query, for fluid interface
     */
    public function filterByMaps($maps, $comparison = null)
    {
        if ($maps instanceof \Maps) {
            return $this
                ->addUsingAlias(GamesTableMap::COL_MAP_ID, $maps->getId(), $comparison);
        } elseif ($maps instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamesTableMap::COL_MAP_ID, $maps->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMaps() only accepts arguments of type \Maps or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Maps relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function joinMaps($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Maps');

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
            $this->addJoinObject($join, 'Maps');
        }

        return $this;
    }

    /**
     * Use the Maps relation Maps object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MapsQuery A secondary query class using the current class as primary query
     */
    public function useMapsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMaps($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Maps', '\MapsQuery');
    }

    /**
     * Use the Maps relation Maps object
     *
     * @param callable(\MapsQuery):\MapsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withMapsQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useMapsQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Maps table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \MapsQuery The inner query object of the EXISTS statement
     */
    public function useMapsExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Maps', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Maps table for a NOT EXISTS query.
     *
     * @see useMapsExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \MapsQuery The inner query object of the NOT EXISTS statement
     */
    public function useMapsNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Maps', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Gametypes object
     *
     * @param \Gametypes|ObjectCollection $gametypes The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGamesQuery The current query, for fluid interface
     */
    public function filterByGamestypes($gametypes, $comparison = null)
    {
        if ($gametypes instanceof \Gametypes) {
            return $this
                ->addUsingAlias(GamesTableMap::COL_GAMETYPE_ID, $gametypes->getId(), $comparison);
        } elseif ($gametypes instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamesTableMap::COL_GAMETYPE_ID, $gametypes->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGamestypes() only accepts arguments of type \Gametypes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gamestypes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function joinGamestypes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gamestypes');

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
            $this->addJoinObject($join, 'Gamestypes');
        }

        return $this;
    }

    /**
     * Use the Gamestypes relation Gametypes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GametypesQuery A secondary query class using the current class as primary query
     */
    public function useGamestypesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGamestypes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gamestypes', '\GametypesQuery');
    }

    /**
     * Use the Gamestypes relation Gametypes object
     *
     * @param callable(\GametypesQuery):\GametypesQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGamestypesQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useGamestypesQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the Gamestypes relation to the Gametypes table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \GametypesQuery The inner query object of the EXISTS statement
     */
    public function useGamestypesExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Gamestypes', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the Gamestypes relation to the Gametypes table for a NOT EXISTS query.
     *
     * @see useGamestypesExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \GametypesQuery The inner query object of the NOT EXISTS statement
     */
    public function useGamestypesNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Gamestypes', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Gamerounds object
     *
     * @param \Gamerounds|ObjectCollection $gamerounds the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGamesQuery The current query, for fluid interface
     */
    public function filterByRound($gamerounds, $comparison = null)
    {
        if ($gamerounds instanceof \Gamerounds) {
            return $this
                ->addUsingAlias(GamesTableMap::COL_ID, $gamerounds->getGameID(), $comparison);
        } elseif ($gamerounds instanceof ObjectCollection) {
            return $this
                ->useRoundQuery()
                ->filterByPrimaryKeys($gamerounds->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRound() only accepts arguments of type \Gamerounds or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Round relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function joinRound($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Round');

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
            $this->addJoinObject($join, 'Round');
        }

        return $this;
    }

    /**
     * Use the Round relation Gamerounds object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GameroundsQuery A secondary query class using the current class as primary query
     */
    public function useRoundQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRound($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Round', '\GameroundsQuery');
    }

    /**
     * Use the Round relation Gamerounds object
     *
     * @param callable(\GameroundsQuery):\GameroundsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withRoundQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useRoundQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the Round relation to the Gamerounds table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \GameroundsQuery The inner query object of the EXISTS statement
     */
    public function useRoundExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Round', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the Round relation to the Gamerounds table for a NOT EXISTS query.
     *
     * @see useRoundExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \GameroundsQuery The inner query object of the NOT EXISTS statement
     */
    public function useRoundNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Round', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Gamescores object
     *
     * @param \Gamescores|ObjectCollection $gamescores the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGamesQuery The current query, for fluid interface
     */
    public function filterByScore($gamescores, $comparison = null)
    {
        if ($gamescores instanceof \Gamescores) {
            return $this
                ->addUsingAlias(GamesTableMap::COL_ID, $gamescores->getGameID(), $comparison);
        } elseif ($gamescores instanceof ObjectCollection) {
            return $this
                ->useScoreQuery()
                ->filterByPrimaryKeys($gamescores->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByScore() only accepts arguments of type \Gamescores or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Score relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
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
     * Use the Score relation Gamescores object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GamescoresQuery A secondary query class using the current class as primary query
     */
    public function useScoreQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinScore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Score', '\GamescoresQuery');
    }

    /**
     * Use the Score relation Gamescores object
     *
     * @param callable(\GamescoresQuery):\GamescoresQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withScoreQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useScoreQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the Score relation to the Gamescores table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \GamescoresQuery The inner query object of the EXISTS statement
     */
    public function useScoreExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Score', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the Score relation to the Gamescores table for a NOT EXISTS query.
     *
     * @see useScoreExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \GamescoresQuery The inner query object of the NOT EXISTS statement
     */
    public function useScoreNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Score', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildGames $games Object to remove from the list of results
     *
     * @return $this|ChildGamesQuery The current query, for fluid interface
     */
    public function prune($games = null)
    {
        if ($games) {
            $this->addUsingAlias(GamesTableMap::COL_ID, $games->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the games table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GamesTableMap::clearInstancePool();
            GamesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GamesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GamesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GamesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GamesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GamesQuery
