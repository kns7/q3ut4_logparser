<?php

namespace Base;

use \Gamescores as ChildGamescores;
use \GamescoresQuery as ChildGamescoresQuery;
use \Exception;
use \PDO;
use Map\GamescoresTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'gamescores' table.
 *
 *
 *
 * @method     ChildGamescoresQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGamescoresQuery orderByGameID($order = Criteria::ASC) Order by the game_id column
 * @method     ChildGamescoresQuery orderByPlayerId($order = Criteria::ASC) Order by the player_id column
 * @method     ChildGamescoresQuery orderByKills($order = Criteria::ASC) Order by the kills column
 * @method     ChildGamescoresQuery orderByDeaths($order = Criteria::ASC) Order by the deaths column
 * @method     ChildGamescoresQuery orderByScore($order = Criteria::ASC) Order by the score column
 * @method     ChildGamescoresQuery orderByPing($order = Criteria::ASC) Order by the ping column
 * @method     ChildGamescoresQuery orderByWinner($order = Criteria::ASC) Order by the winner column
 * @method     ChildGamescoresQuery orderByTeam($order = Criteria::ASC) Order by the team column
 * @method     ChildGamescoresQuery orderByHalf($order = Criteria::ASC) Order by the half column
 * @method     ChildGamescoresQuery orderByCreated($order = Criteria::ASC) Order by the created column
 *
 * @method     ChildGamescoresQuery groupById() Group by the id column
 * @method     ChildGamescoresQuery groupByGameID() Group by the game_id column
 * @method     ChildGamescoresQuery groupByPlayerId() Group by the player_id column
 * @method     ChildGamescoresQuery groupByKills() Group by the kills column
 * @method     ChildGamescoresQuery groupByDeaths() Group by the deaths column
 * @method     ChildGamescoresQuery groupByScore() Group by the score column
 * @method     ChildGamescoresQuery groupByPing() Group by the ping column
 * @method     ChildGamescoresQuery groupByWinner() Group by the winner column
 * @method     ChildGamescoresQuery groupByTeam() Group by the team column
 * @method     ChildGamescoresQuery groupByHalf() Group by the half column
 * @method     ChildGamescoresQuery groupByCreated() Group by the created column
 *
 * @method     ChildGamescoresQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGamescoresQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGamescoresQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGamescoresQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGamescoresQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGamescoresQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGamescoresQuery leftJoinGames($relationAlias = null) Adds a LEFT JOIN clause to the query using the Games relation
 * @method     ChildGamescoresQuery rightJoinGames($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Games relation
 * @method     ChildGamescoresQuery innerJoinGames($relationAlias = null) Adds a INNER JOIN clause to the query using the Games relation
 *
 * @method     ChildGamescoresQuery joinWithGames($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Games relation
 *
 * @method     ChildGamescoresQuery leftJoinWithGames() Adds a LEFT JOIN clause and with to the query using the Games relation
 * @method     ChildGamescoresQuery rightJoinWithGames() Adds a RIGHT JOIN clause and with to the query using the Games relation
 * @method     ChildGamescoresQuery innerJoinWithGames() Adds a INNER JOIN clause and with to the query using the Games relation
 *
 * @method     ChildGamescoresQuery leftJoinPlayers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Players relation
 * @method     ChildGamescoresQuery rightJoinPlayers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Players relation
 * @method     ChildGamescoresQuery innerJoinPlayers($relationAlias = null) Adds a INNER JOIN clause to the query using the Players relation
 *
 * @method     ChildGamescoresQuery joinWithPlayers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Players relation
 *
 * @method     ChildGamescoresQuery leftJoinWithPlayers() Adds a LEFT JOIN clause and with to the query using the Players relation
 * @method     ChildGamescoresQuery rightJoinWithPlayers() Adds a RIGHT JOIN clause and with to the query using the Players relation
 * @method     ChildGamescoresQuery innerJoinWithPlayers() Adds a INNER JOIN clause and with to the query using the Players relation
 *
 * @method     \GamesQuery|\PlayersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGamescores|null findOne(ConnectionInterface $con = null) Return the first ChildGamescores matching the query
 * @method     ChildGamescores findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGamescores matching the query, or a new ChildGamescores object populated from the query conditions when no match is found
 *
 * @method     ChildGamescores|null findOneById(int $id) Return the first ChildGamescores filtered by the id column
 * @method     ChildGamescores|null findOneByGameID(int $game_id) Return the first ChildGamescores filtered by the game_id column
 * @method     ChildGamescores|null findOneByPlayerId(int $player_id) Return the first ChildGamescores filtered by the player_id column
 * @method     ChildGamescores|null findOneByKills(int $kills) Return the first ChildGamescores filtered by the kills column
 * @method     ChildGamescores|null findOneByDeaths(int $deaths) Return the first ChildGamescores filtered by the deaths column
 * @method     ChildGamescores|null findOneByScore(int $score) Return the first ChildGamescores filtered by the score column
 * @method     ChildGamescores|null findOneByPing(int $ping) Return the first ChildGamescores filtered by the ping column
 * @method     ChildGamescores|null findOneByWinner(boolean $winner) Return the first ChildGamescores filtered by the winner column
 * @method     ChildGamescores|null findOneByTeam(int $team) Return the first ChildGamescores filtered by the team column
 * @method     ChildGamescores|null findOneByHalf(int $half) Return the first ChildGamescores filtered by the half column
 * @method     ChildGamescores|null findOneByCreated(string $created) Return the first ChildGamescores filtered by the created column *

 * @method     ChildGamescores requirePk($key, ConnectionInterface $con = null) Return the ChildGamescores by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamescores requireOne(ConnectionInterface $con = null) Return the first ChildGamescores matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGamescores requireOneById(int $id) Return the first ChildGamescores filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamescores requireOneByGameID(int $game_id) Return the first ChildGamescores filtered by the game_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamescores requireOneByPlayerId(int $player_id) Return the first ChildGamescores filtered by the player_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamescores requireOneByKills(int $kills) Return the first ChildGamescores filtered by the kills column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamescores requireOneByDeaths(int $deaths) Return the first ChildGamescores filtered by the deaths column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamescores requireOneByScore(int $score) Return the first ChildGamescores filtered by the score column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamescores requireOneByPing(int $ping) Return the first ChildGamescores filtered by the ping column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamescores requireOneByWinner(boolean $winner) Return the first ChildGamescores filtered by the winner column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamescores requireOneByTeam(int $team) Return the first ChildGamescores filtered by the team column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamescores requireOneByHalf(int $half) Return the first ChildGamescores filtered by the half column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamescores requireOneByCreated(string $created) Return the first ChildGamescores filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGamescores[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGamescores objects based on current ModelCriteria
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> find(ConnectionInterface $con = null) Return ChildGamescores objects based on current ModelCriteria
 * @method     ChildGamescores[]|ObjectCollection findById(int $id) Return ChildGamescores objects filtered by the id column
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> findById(int $id) Return ChildGamescores objects filtered by the id column
 * @method     ChildGamescores[]|ObjectCollection findByGameID(int $game_id) Return ChildGamescores objects filtered by the game_id column
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> findByGameID(int $game_id) Return ChildGamescores objects filtered by the game_id column
 * @method     ChildGamescores[]|ObjectCollection findByPlayerId(int $player_id) Return ChildGamescores objects filtered by the player_id column
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> findByPlayerId(int $player_id) Return ChildGamescores objects filtered by the player_id column
 * @method     ChildGamescores[]|ObjectCollection findByKills(int $kills) Return ChildGamescores objects filtered by the kills column
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> findByKills(int $kills) Return ChildGamescores objects filtered by the kills column
 * @method     ChildGamescores[]|ObjectCollection findByDeaths(int $deaths) Return ChildGamescores objects filtered by the deaths column
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> findByDeaths(int $deaths) Return ChildGamescores objects filtered by the deaths column
 * @method     ChildGamescores[]|ObjectCollection findByScore(int $score) Return ChildGamescores objects filtered by the score column
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> findByScore(int $score) Return ChildGamescores objects filtered by the score column
 * @method     ChildGamescores[]|ObjectCollection findByPing(int $ping) Return ChildGamescores objects filtered by the ping column
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> findByPing(int $ping) Return ChildGamescores objects filtered by the ping column
 * @method     ChildGamescores[]|ObjectCollection findByWinner(boolean $winner) Return ChildGamescores objects filtered by the winner column
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> findByWinner(boolean $winner) Return ChildGamescores objects filtered by the winner column
 * @method     ChildGamescores[]|ObjectCollection findByTeam(int $team) Return ChildGamescores objects filtered by the team column
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> findByTeam(int $team) Return ChildGamescores objects filtered by the team column
 * @method     ChildGamescores[]|ObjectCollection findByHalf(int $half) Return ChildGamescores objects filtered by the half column
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> findByHalf(int $half) Return ChildGamescores objects filtered by the half column
 * @method     ChildGamescores[]|ObjectCollection findByCreated(string $created) Return ChildGamescores objects filtered by the created column
 * @psalm-method ObjectCollection&\Traversable<ChildGamescores> findByCreated(string $created) Return ChildGamescores objects filtered by the created column
 * @method     ChildGamescores[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildGamescores> paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GamescoresQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\GamescoresQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Gamescores', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGamescoresQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGamescoresQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGamescoresQuery) {
            return $criteria;
        }
        $query = new ChildGamescoresQuery();
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
     * @return ChildGamescores|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GamescoresTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GamescoresTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGamescores A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, game_id, player_id, kills, deaths, score, ping, winner, team, half, created FROM gamescores WHERE id = :p0';
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
            /** @var ChildGamescores $obj */
            $obj = new ChildGamescores();
            $obj->hydrate($row);
            GamescoresTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGamescores|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GamescoresTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GamescoresTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamescoresTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByGameID($gameID = null, $comparison = null)
    {
        if (is_array($gameID)) {
            $useMinMax = false;
            if (isset($gameID['min'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_GAME_ID, $gameID['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameID['max'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_GAME_ID, $gameID['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamescoresTableMap::COL_GAME_ID, $gameID, $comparison);
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
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByPlayerId($playerId = null, $comparison = null)
    {
        if (is_array($playerId)) {
            $useMinMax = false;
            if (isset($playerId['min'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_PLAYER_ID, $playerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playerId['max'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_PLAYER_ID, $playerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamescoresTableMap::COL_PLAYER_ID, $playerId, $comparison);
    }

    /**
     * Filter the query on the kills column
     *
     * Example usage:
     * <code>
     * $query->filterByKills(1234); // WHERE kills = 1234
     * $query->filterByKills(array(12, 34)); // WHERE kills IN (12, 34)
     * $query->filterByKills(array('min' => 12)); // WHERE kills > 12
     * </code>
     *
     * @param     mixed $kills The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByKills($kills = null, $comparison = null)
    {
        if (is_array($kills)) {
            $useMinMax = false;
            if (isset($kills['min'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_KILLS, $kills['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($kills['max'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_KILLS, $kills['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamescoresTableMap::COL_KILLS, $kills, $comparison);
    }

    /**
     * Filter the query on the deaths column
     *
     * Example usage:
     * <code>
     * $query->filterByDeaths(1234); // WHERE deaths = 1234
     * $query->filterByDeaths(array(12, 34)); // WHERE deaths IN (12, 34)
     * $query->filterByDeaths(array('min' => 12)); // WHERE deaths > 12
     * </code>
     *
     * @param     mixed $deaths The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByDeaths($deaths = null, $comparison = null)
    {
        if (is_array($deaths)) {
            $useMinMax = false;
            if (isset($deaths['min'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_DEATHS, $deaths['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deaths['max'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_DEATHS, $deaths['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamescoresTableMap::COL_DEATHS, $deaths, $comparison);
    }

    /**
     * Filter the query on the score column
     *
     * Example usage:
     * <code>
     * $query->filterByScore(1234); // WHERE score = 1234
     * $query->filterByScore(array(12, 34)); // WHERE score IN (12, 34)
     * $query->filterByScore(array('min' => 12)); // WHERE score > 12
     * </code>
     *
     * @param     mixed $score The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByScore($score = null, $comparison = null)
    {
        if (is_array($score)) {
            $useMinMax = false;
            if (isset($score['min'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_SCORE, $score['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($score['max'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_SCORE, $score['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamescoresTableMap::COL_SCORE, $score, $comparison);
    }

    /**
     * Filter the query on the ping column
     *
     * Example usage:
     * <code>
     * $query->filterByPing(1234); // WHERE ping = 1234
     * $query->filterByPing(array(12, 34)); // WHERE ping IN (12, 34)
     * $query->filterByPing(array('min' => 12)); // WHERE ping > 12
     * </code>
     *
     * @param     mixed $ping The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByPing($ping = null, $comparison = null)
    {
        if (is_array($ping)) {
            $useMinMax = false;
            if (isset($ping['min'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_PING, $ping['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ping['max'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_PING, $ping['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamescoresTableMap::COL_PING, $ping, $comparison);
    }

    /**
     * Filter the query on the winner column
     *
     * Example usage:
     * <code>
     * $query->filterByWinner(true); // WHERE winner = true
     * $query->filterByWinner('yes'); // WHERE winner = true
     * </code>
     *
     * @param     boolean|string $winner The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByWinner($winner = null, $comparison = null)
    {
        if (is_string($winner)) {
            $winner = in_array(strtolower($winner), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(GamescoresTableMap::COL_WINNER, $winner, $comparison);
    }

    /**
     * Filter the query on the team column
     *
     * Example usage:
     * <code>
     * $query->filterByTeam(1234); // WHERE team = 1234
     * $query->filterByTeam(array(12, 34)); // WHERE team IN (12, 34)
     * $query->filterByTeam(array('min' => 12)); // WHERE team > 12
     * </code>
     *
     * @param     mixed $team The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByTeam($team = null, $comparison = null)
    {
        if (is_array($team)) {
            $useMinMax = false;
            if (isset($team['min'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_TEAM, $team['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($team['max'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_TEAM, $team['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamescoresTableMap::COL_TEAM, $team, $comparison);
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
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByHalf($half = null, $comparison = null)
    {
        if (is_array($half)) {
            $useMinMax = false;
            if (isset($half['min'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_HALF, $half['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($half['max'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_HALF, $half['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamescoresTableMap::COL_HALF, $half, $comparison);
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
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(GamescoresTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamescoresTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query by a related \Games object
     *
     * @param \Games|ObjectCollection $games The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByGames($games, $comparison = null)
    {
        if ($games instanceof \Games) {
            return $this
                ->addUsingAlias(GamescoresTableMap::COL_GAME_ID, $games->getId(), $comparison);
        } elseif ($games instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamescoresTableMap::COL_GAME_ID, $games->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
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
     * Use the Games relation Games object
     *
     * @param callable(\GamesQuery):\GamesQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGamesQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useGamesQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Games table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \GamesQuery The inner query object of the EXISTS statement
     */
    public function useGamesExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Games', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Games table for a NOT EXISTS query.
     *
     * @see useGamesExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \GamesQuery The inner query object of the NOT EXISTS statement
     */
    public function useGamesNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Games', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Players object
     *
     * @param \Players|ObjectCollection $players The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGamescoresQuery The current query, for fluid interface
     */
    public function filterByPlayers($players, $comparison = null)
    {
        if ($players instanceof \Players) {
            return $this
                ->addUsingAlias(GamescoresTableMap::COL_PLAYER_ID, $players->getId(), $comparison);
        } elseif ($players instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamescoresTableMap::COL_PLAYER_ID, $players->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildGamescores $gamescores Object to remove from the list of results
     *
     * @return $this|ChildGamescoresQuery The current query, for fluid interface
     */
    public function prune($gamescores = null)
    {
        if ($gamescores) {
            $this->addUsingAlias(GamescoresTableMap::COL_ID, $gamescores->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the gamescores table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamescoresTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GamescoresTableMap::clearInstancePool();
            GamescoresTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GamescoresTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GamescoresTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GamescoresTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GamescoresTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GamescoresQuery
