<?php

namespace Base;

use \Gamerounds as ChildGamerounds;
use \GameroundsQuery as ChildGameroundsQuery;
use \Games as ChildGames;
use \GamesQuery as ChildGamesQuery;
use \Gamescores as ChildGamescores;
use \GamescoresQuery as ChildGamescoresQuery;
use \Gametypes as ChildGametypes;
use \GametypesQuery as ChildGametypesQuery;
use \Maps as ChildMaps;
use \MapsQuery as ChildMapsQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\GameroundsTableMap;
use Map\GamesTableMap;
use Map\GamescoresTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'games' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Games implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\GamesTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the gamenb field.
     *
     * @var        int
     */
    protected $gamenb;

    /**
     * The value for the map_id field.
     *
     * @var        int
     */
    protected $map_id;

    /**
     * The value for the gametype_id field.
     *
     * @var        int
     */
    protected $gametype_id;

    /**
     * The value for the timelimit field.
     *
     * @var        int
     */
    protected $timelimit;

    /**
     * The value for the roundtime field.
     *
     * @var        int
     */
    protected $roundtime;

    /**
     * The value for the nbplayers field.
     *
     * @var        int
     */
    protected $nbplayers;

    /**
     * The value for the redscore field.
     *
     * @var        int|null
     */
    protected $redscore;

    /**
     * The value for the bluescore field.
     *
     * @var        int|null
     */
    protected $bluescore;

    /**
     * The value for the redscore2 field.
     *
     * @var        int|null
     */
    protected $redscore2;

    /**
     * The value for the bluescore2 field.
     *
     * @var        int|null
     */
    protected $bluescore2;

    /**
     * The value for the created field.
     *
     * @var        DateTime|null
     */
    protected $created;

    /**
     * @var        ChildMaps
     */
    protected $aMaps;

    /**
     * @var        ChildGametypes
     */
    protected $aGamestypes;

    /**
     * @var        ObjectCollection|ChildGamerounds[] Collection to store aggregation of ChildGamerounds objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildGamerounds> Collection to store aggregation of ChildGamerounds objects.
     */
    protected $collRounds;
    protected $collRoundsPartial;

    /**
     * @var        ObjectCollection|ChildGamescores[] Collection to store aggregation of ChildGamescores objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildGamescores> Collection to store aggregation of ChildGamescores objects.
     */
    protected $collScores;
    protected $collScoresPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGamerounds[]
     * @phpstan-var ObjectCollection&\Traversable<ChildGamerounds>
     */
    protected $roundsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGamescores[]
     * @phpstan-var ObjectCollection&\Traversable<ChildGamescores>
     */
    protected $scoresScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Games object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Games</code> instance.  If
     * <code>obj</code> is an instance of <code>Games</code>, delegates to
     * <code>equals(Games)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param  string  $keyType                (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [gamenb] column value.
     *
     * @return int
     */
    public function getGameNB()
    {
        return $this->gamenb;
    }

    /**
     * Get the [map_id] column value.
     *
     * @return int
     */
    public function getMapId()
    {
        return $this->map_id;
    }

    /**
     * Get the [gametype_id] column value.
     *
     * @return int
     */
    public function getGametypeId()
    {
        return $this->gametype_id;
    }

    /**
     * Get the [timelimit] column value.
     *
     * @return int
     */
    public function getTimelimit()
    {
        return $this->timelimit;
    }

    /**
     * Get the [roundtime] column value.
     *
     * @return int
     */
    public function getRoundtime()
    {
        return $this->roundtime;
    }

    /**
     * Get the [nbplayers] column value.
     *
     * @return int
     */
    public function getNbplayers()
    {
        return $this->nbplayers;
    }

    /**
     * Get the [redscore] column value.
     *
     * @return int|null
     */
    public function getRedScore()
    {
        return $this->redscore;
    }

    /**
     * Get the [bluescore] column value.
     *
     * @return int|null
     */
    public function getBlueScore()
    {
        return $this->bluescore;
    }

    /**
     * Get the [redscore2] column value.
     *
     * @return int|null
     */
    public function getRedScore2()
    {
        return $this->redscore2;
    }

    /**
     * Get the [bluescore2] column value.
     *
     * @return int|null
     */
    public function getBlueScore2()
    {
        return $this->bluescore2;
    }

    /**
     * Get the [optionally formatted] temporal [created] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getCreated($format = null)
    {
        if ($format === null) {
            return $this->created;
        } else {
            return $this->created instanceof \DateTimeInterface ? $this->created->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[GamesTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [gamenb] column.
     *
     * @param int $v New value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setGameNB($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->gamenb !== $v) {
            $this->gamenb = $v;
            $this->modifiedColumns[GamesTableMap::COL_GAMENB] = true;
        }

        return $this;
    } // setGameNB()

    /**
     * Set the value of [map_id] column.
     *
     * @param int $v New value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setMapId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->map_id !== $v) {
            $this->map_id = $v;
            $this->modifiedColumns[GamesTableMap::COL_MAP_ID] = true;
        }

        if ($this->aMaps !== null && $this->aMaps->getId() !== $v) {
            $this->aMaps = null;
        }

        return $this;
    } // setMapId()

    /**
     * Set the value of [gametype_id] column.
     *
     * @param int $v New value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setGametypeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->gametype_id !== $v) {
            $this->gametype_id = $v;
            $this->modifiedColumns[GamesTableMap::COL_GAMETYPE_ID] = true;
        }

        if ($this->aGamestypes !== null && $this->aGamestypes->getId() !== $v) {
            $this->aGamestypes = null;
        }

        return $this;
    } // setGametypeId()

    /**
     * Set the value of [timelimit] column.
     *
     * @param int $v New value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setTimelimit($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->timelimit !== $v) {
            $this->timelimit = $v;
            $this->modifiedColumns[GamesTableMap::COL_TIMELIMIT] = true;
        }

        return $this;
    } // setTimelimit()

    /**
     * Set the value of [roundtime] column.
     *
     * @param int $v New value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setRoundtime($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->roundtime !== $v) {
            $this->roundtime = $v;
            $this->modifiedColumns[GamesTableMap::COL_ROUNDTIME] = true;
        }

        return $this;
    } // setRoundtime()

    /**
     * Set the value of [nbplayers] column.
     *
     * @param int $v New value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setNbplayers($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->nbplayers !== $v) {
            $this->nbplayers = $v;
            $this->modifiedColumns[GamesTableMap::COL_NBPLAYERS] = true;
        }

        return $this;
    } // setNbplayers()

    /**
     * Set the value of [redscore] column.
     *
     * @param int|null $v New value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setRedScore($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->redscore !== $v) {
            $this->redscore = $v;
            $this->modifiedColumns[GamesTableMap::COL_REDSCORE] = true;
        }

        return $this;
    } // setRedScore()

    /**
     * Set the value of [bluescore] column.
     *
     * @param int|null $v New value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setBlueScore($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->bluescore !== $v) {
            $this->bluescore = $v;
            $this->modifiedColumns[GamesTableMap::COL_BLUESCORE] = true;
        }

        return $this;
    } // setBlueScore()

    /**
     * Set the value of [redscore2] column.
     *
     * @param int|null $v New value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setRedScore2($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->redscore2 !== $v) {
            $this->redscore2 = $v;
            $this->modifiedColumns[GamesTableMap::COL_REDSCORE2] = true;
        }

        return $this;
    } // setRedScore2()

    /**
     * Set the value of [bluescore2] column.
     *
     * @param int|null $v New value
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setBlueScore2($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->bluescore2 !== $v) {
            $this->bluescore2 = $v;
            $this->modifiedColumns[GamesTableMap::COL_BLUESCORE2] = true;
        }

        return $this;
    } // setBlueScore2()

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Games The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created !== null || $dt !== null) {
            if ($this->created === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created->format("Y-m-d H:i:s.u")) {
                $this->created = $dt === null ? null : clone $dt;
                $this->modifiedColumns[GamesTableMap::COL_CREATED] = true;
            }
        } // if either are not null

        return $this;
    } // setCreated()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : GamesTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : GamesTableMap::translateFieldName('GameNB', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gamenb = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : GamesTableMap::translateFieldName('MapId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : GamesTableMap::translateFieldName('GametypeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gametype_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : GamesTableMap::translateFieldName('Timelimit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->timelimit = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : GamesTableMap::translateFieldName('Roundtime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->roundtime = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : GamesTableMap::translateFieldName('Nbplayers', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nbplayers = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : GamesTableMap::translateFieldName('RedScore', TableMap::TYPE_PHPNAME, $indexType)];
            $this->redscore = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : GamesTableMap::translateFieldName('BlueScore', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bluescore = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : GamesTableMap::translateFieldName('RedScore2', TableMap::TYPE_PHPNAME, $indexType)];
            $this->redscore2 = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : GamesTableMap::translateFieldName('BlueScore2', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bluescore2 = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : GamesTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = GamesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Games'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aMaps !== null && $this->map_id !== $this->aMaps->getId()) {
            $this->aMaps = null;
        }
        if ($this->aGamestypes !== null && $this->gametype_id !== $this->aGamestypes->getId()) {
            $this->aGamestypes = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GamesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildGamesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aMaps = null;
            $this->aGamestypes = null;
            $this->collRounds = null;

            $this->collScores = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Games::setDeleted()
     * @see Games::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildGamesQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamesTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                GamesTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aMaps !== null) {
                if ($this->aMaps->isModified() || $this->aMaps->isNew()) {
                    $affectedRows += $this->aMaps->save($con);
                }
                $this->setMaps($this->aMaps);
            }

            if ($this->aGamestypes !== null) {
                if ($this->aGamestypes->isModified() || $this->aGamestypes->isNew()) {
                    $affectedRows += $this->aGamestypes->save($con);
                }
                $this->setGamestypes($this->aGamestypes);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->roundsScheduledForDeletion !== null) {
                if (!$this->roundsScheduledForDeletion->isEmpty()) {
                    \GameroundsQuery::create()
                        ->filterByPrimaryKeys($this->roundsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->roundsScheduledForDeletion = null;
                }
            }

            if ($this->collRounds !== null) {
                foreach ($this->collRounds as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->scoresScheduledForDeletion !== null) {
                if (!$this->scoresScheduledForDeletion->isEmpty()) {
                    \GamescoresQuery::create()
                        ->filterByPrimaryKeys($this->scoresScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->scoresScheduledForDeletion = null;
                }
            }

            if ($this->collScores !== null) {
                foreach ($this->collScores as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[GamesTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GamesTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GamesTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(GamesTableMap::COL_GAMENB)) {
            $modifiedColumns[':p' . $index++]  = 'gamenb';
        }
        if ($this->isColumnModified(GamesTableMap::COL_MAP_ID)) {
            $modifiedColumns[':p' . $index++]  = 'map_id';
        }
        if ($this->isColumnModified(GamesTableMap::COL_GAMETYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'gametype_id';
        }
        if ($this->isColumnModified(GamesTableMap::COL_TIMELIMIT)) {
            $modifiedColumns[':p' . $index++]  = 'timelimit';
        }
        if ($this->isColumnModified(GamesTableMap::COL_ROUNDTIME)) {
            $modifiedColumns[':p' . $index++]  = 'roundtime';
        }
        if ($this->isColumnModified(GamesTableMap::COL_NBPLAYERS)) {
            $modifiedColumns[':p' . $index++]  = 'nbplayers';
        }
        if ($this->isColumnModified(GamesTableMap::COL_REDSCORE)) {
            $modifiedColumns[':p' . $index++]  = 'redscore';
        }
        if ($this->isColumnModified(GamesTableMap::COL_BLUESCORE)) {
            $modifiedColumns[':p' . $index++]  = 'bluescore';
        }
        if ($this->isColumnModified(GamesTableMap::COL_REDSCORE2)) {
            $modifiedColumns[':p' . $index++]  = 'redscore2';
        }
        if ($this->isColumnModified(GamesTableMap::COL_BLUESCORE2)) {
            $modifiedColumns[':p' . $index++]  = 'bluescore2';
        }
        if ($this->isColumnModified(GamesTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }

        $sql = sprintf(
            'INSERT INTO games (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'gamenb':
                        $stmt->bindValue($identifier, $this->gamenb, PDO::PARAM_INT);
                        break;
                    case 'map_id':
                        $stmt->bindValue($identifier, $this->map_id, PDO::PARAM_INT);
                        break;
                    case 'gametype_id':
                        $stmt->bindValue($identifier, $this->gametype_id, PDO::PARAM_INT);
                        break;
                    case 'timelimit':
                        $stmt->bindValue($identifier, $this->timelimit, PDO::PARAM_INT);
                        break;
                    case 'roundtime':
                        $stmt->bindValue($identifier, $this->roundtime, PDO::PARAM_INT);
                        break;
                    case 'nbplayers':
                        $stmt->bindValue($identifier, $this->nbplayers, PDO::PARAM_INT);
                        break;
                    case 'redscore':
                        $stmt->bindValue($identifier, $this->redscore, PDO::PARAM_INT);
                        break;
                    case 'bluescore':
                        $stmt->bindValue($identifier, $this->bluescore, PDO::PARAM_INT);
                        break;
                    case 'redscore2':
                        $stmt->bindValue($identifier, $this->redscore2, PDO::PARAM_INT);
                        break;
                    case 'bluescore2':
                        $stmt->bindValue($identifier, $this->bluescore2, PDO::PARAM_INT);
                        break;
                    case 'created':
                        $stmt->bindValue($identifier, $this->created ? $this->created->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GamesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getGameNB();
                break;
            case 2:
                return $this->getMapId();
                break;
            case 3:
                return $this->getGametypeId();
                break;
            case 4:
                return $this->getTimelimit();
                break;
            case 5:
                return $this->getRoundtime();
                break;
            case 6:
                return $this->getNbplayers();
                break;
            case 7:
                return $this->getRedScore();
                break;
            case 8:
                return $this->getBlueScore();
                break;
            case 9:
                return $this->getRedScore2();
                break;
            case 10:
                return $this->getBlueScore2();
                break;
            case 11:
                return $this->getCreated();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Games'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Games'][$this->hashCode()] = true;
        $keys = GamesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getGameNB(),
            $keys[2] => $this->getMapId(),
            $keys[3] => $this->getGametypeId(),
            $keys[4] => $this->getTimelimit(),
            $keys[5] => $this->getRoundtime(),
            $keys[6] => $this->getNbplayers(),
            $keys[7] => $this->getRedScore(),
            $keys[8] => $this->getBlueScore(),
            $keys[9] => $this->getRedScore2(),
            $keys[10] => $this->getBlueScore2(),
            $keys[11] => $this->getCreated(),
        );
        if ($result[$keys[11]] instanceof \DateTimeInterface) {
            $result[$keys[11]] = $result[$keys[11]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aMaps) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'maps';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'maps';
                        break;
                    default:
                        $key = 'Maps';
                }

                $result[$key] = $this->aMaps->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aGamestypes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gametypes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gametypes';
                        break;
                    default:
                        $key = 'Gamestypes';
                }

                $result[$key] = $this->aGamestypes->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collRounds) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gameroundss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gameroundss';
                        break;
                    default:
                        $key = 'Rounds';
                }

                $result[$key] = $this->collRounds->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collScores) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gamescoress';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gamescoress';
                        break;
                    default:
                        $key = 'Scores';
                }

                $result[$key] = $this->collScores->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Games
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GamesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Games
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setGameNB($value);
                break;
            case 2:
                $this->setMapId($value);
                break;
            case 3:
                $this->setGametypeId($value);
                break;
            case 4:
                $this->setTimelimit($value);
                break;
            case 5:
                $this->setRoundtime($value);
                break;
            case 6:
                $this->setNbplayers($value);
                break;
            case 7:
                $this->setRedScore($value);
                break;
            case 8:
                $this->setBlueScore($value);
                break;
            case 9:
                $this->setRedScore2($value);
                break;
            case 10:
                $this->setBlueScore2($value);
                break;
            case 11:
                $this->setCreated($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return     $this|\Games
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = GamesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setGameNB($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setMapId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setGametypeId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTimelimit($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setRoundtime($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setNbplayers($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setRedScore($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setBlueScore($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setRedScore2($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setBlueScore2($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setCreated($arr[$keys[11]]);
        }

        return $this;
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Games The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(GamesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(GamesTableMap::COL_ID)) {
            $criteria->add(GamesTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(GamesTableMap::COL_GAMENB)) {
            $criteria->add(GamesTableMap::COL_GAMENB, $this->gamenb);
        }
        if ($this->isColumnModified(GamesTableMap::COL_MAP_ID)) {
            $criteria->add(GamesTableMap::COL_MAP_ID, $this->map_id);
        }
        if ($this->isColumnModified(GamesTableMap::COL_GAMETYPE_ID)) {
            $criteria->add(GamesTableMap::COL_GAMETYPE_ID, $this->gametype_id);
        }
        if ($this->isColumnModified(GamesTableMap::COL_TIMELIMIT)) {
            $criteria->add(GamesTableMap::COL_TIMELIMIT, $this->timelimit);
        }
        if ($this->isColumnModified(GamesTableMap::COL_ROUNDTIME)) {
            $criteria->add(GamesTableMap::COL_ROUNDTIME, $this->roundtime);
        }
        if ($this->isColumnModified(GamesTableMap::COL_NBPLAYERS)) {
            $criteria->add(GamesTableMap::COL_NBPLAYERS, $this->nbplayers);
        }
        if ($this->isColumnModified(GamesTableMap::COL_REDSCORE)) {
            $criteria->add(GamesTableMap::COL_REDSCORE, $this->redscore);
        }
        if ($this->isColumnModified(GamesTableMap::COL_BLUESCORE)) {
            $criteria->add(GamesTableMap::COL_BLUESCORE, $this->bluescore);
        }
        if ($this->isColumnModified(GamesTableMap::COL_REDSCORE2)) {
            $criteria->add(GamesTableMap::COL_REDSCORE2, $this->redscore2);
        }
        if ($this->isColumnModified(GamesTableMap::COL_BLUESCORE2)) {
            $criteria->add(GamesTableMap::COL_BLUESCORE2, $this->bluescore2);
        }
        if ($this->isColumnModified(GamesTableMap::COL_CREATED)) {
            $criteria->add(GamesTableMap::COL_CREATED, $this->created);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildGamesQuery::create();
        $criteria->add(GamesTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Games (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setGameNB($this->getGameNB());
        $copyObj->setMapId($this->getMapId());
        $copyObj->setGametypeId($this->getGametypeId());
        $copyObj->setTimelimit($this->getTimelimit());
        $copyObj->setRoundtime($this->getRoundtime());
        $copyObj->setNbplayers($this->getNbplayers());
        $copyObj->setRedScore($this->getRedScore());
        $copyObj->setBlueScore($this->getBlueScore());
        $copyObj->setRedScore2($this->getRedScore2());
        $copyObj->setBlueScore2($this->getBlueScore2());
        $copyObj->setCreated($this->getCreated());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRounds() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRound($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getScores() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addScore($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Games Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildMaps object.
     *
     * @param  ChildMaps $v
     * @return $this|\Games The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMaps(ChildMaps $v = null)
    {
        if ($v === null) {
            $this->setMapId(NULL);
        } else {
            $this->setMapId($v->getId());
        }

        $this->aMaps = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMaps object, it will not be re-added.
        if ($v !== null) {
            $v->addGame($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildMaps object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildMaps The associated ChildMaps object.
     * @throws PropelException
     */
    public function getMaps(ConnectionInterface $con = null)
    {
        if ($this->aMaps === null && ($this->map_id != 0)) {
            $this->aMaps = ChildMapsQuery::create()->findPk($this->map_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMaps->addGames($this);
             */
        }

        return $this->aMaps;
    }

    /**
     * Declares an association between this object and a ChildGametypes object.
     *
     * @param  ChildGametypes $v
     * @return $this|\Games The current object (for fluent API support)
     * @throws PropelException
     */
    public function setGamestypes(ChildGametypes $v = null)
    {
        if ($v === null) {
            $this->setGametypeId(NULL);
        } else {
            $this->setGametypeId($v->getId());
        }

        $this->aGamestypes = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildGametypes object, it will not be re-added.
        if ($v !== null) {
            $v->addGame($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildGametypes object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildGametypes The associated ChildGametypes object.
     * @throws PropelException
     */
    public function getGamestypes(ConnectionInterface $con = null)
    {
        if ($this->aGamestypes === null && ($this->gametype_id != 0)) {
            $this->aGamestypes = ChildGametypesQuery::create()->findPk($this->gametype_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aGamestypes->addGames($this);
             */
        }

        return $this->aGamestypes;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Round' === $relationName) {
            $this->initRounds();
            return;
        }
        if ('Score' === $relationName) {
            $this->initScores();
            return;
        }
    }

    /**
     * Clears out the collRounds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRounds()
     */
    public function clearRounds()
    {
        $this->collRounds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRounds collection loaded partially.
     */
    public function resetPartialRounds($v = true)
    {
        $this->collRoundsPartial = $v;
    }

    /**
     * Initializes the collRounds collection.
     *
     * By default this just sets the collRounds collection to an empty array (like clearcollRounds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRounds($overrideExisting = true)
    {
        if (null !== $this->collRounds && !$overrideExisting) {
            return;
        }

        $collectionClassName = GameroundsTableMap::getTableMap()->getCollectionClassName();

        $this->collRounds = new $collectionClassName;
        $this->collRounds->setModel('\Gamerounds');
    }

    /**
     * Gets an array of ChildGamerounds objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGames is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGamerounds[] List of ChildGamerounds objects
     * @phpstan-return ObjectCollection&\Traversable<ChildGamerounds> List of ChildGamerounds objects
     * @throws PropelException
     */
    public function getRounds(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRoundsPartial && !$this->isNew();
        if (null === $this->collRounds || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRounds) {
                    $this->initRounds();
                } else {
                    $collectionClassName = GameroundsTableMap::getTableMap()->getCollectionClassName();

                    $collRounds = new $collectionClassName;
                    $collRounds->setModel('\Gamerounds');

                    return $collRounds;
                }
            } else {
                $collRounds = ChildGameroundsQuery::create(null, $criteria)
                    ->filterByGames($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRoundsPartial && count($collRounds)) {
                        $this->initRounds(false);

                        foreach ($collRounds as $obj) {
                            if (false == $this->collRounds->contains($obj)) {
                                $this->collRounds->append($obj);
                            }
                        }

                        $this->collRoundsPartial = true;
                    }

                    return $collRounds;
                }

                if ($partial && $this->collRounds) {
                    foreach ($this->collRounds as $obj) {
                        if ($obj->isNew()) {
                            $collRounds[] = $obj;
                        }
                    }
                }

                $this->collRounds = $collRounds;
                $this->collRoundsPartial = false;
            }
        }

        return $this->collRounds;
    }

    /**
     * Sets a collection of ChildGamerounds objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rounds A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGames The current object (for fluent API support)
     */
    public function setRounds(Collection $rounds, ConnectionInterface $con = null)
    {
        /** @var ChildGamerounds[] $roundsToDelete */
        $roundsToDelete = $this->getRounds(new Criteria(), $con)->diff($rounds);


        $this->roundsScheduledForDeletion = $roundsToDelete;

        foreach ($roundsToDelete as $roundRemoved) {
            $roundRemoved->setGames(null);
        }

        $this->collRounds = null;
        foreach ($rounds as $round) {
            $this->addRound($round);
        }

        $this->collRounds = $rounds;
        $this->collRoundsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Gamerounds objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Gamerounds objects.
     * @throws PropelException
     */
    public function countRounds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRoundsPartial && !$this->isNew();
        if (null === $this->collRounds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRounds) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRounds());
            }

            $query = ChildGameroundsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGames($this)
                ->count($con);
        }

        return count($this->collRounds);
    }

    /**
     * Method called to associate a ChildGamerounds object to this object
     * through the ChildGamerounds foreign key attribute.
     *
     * @param  ChildGamerounds $l ChildGamerounds
     * @return $this|\Games The current object (for fluent API support)
     */
    public function addRound(ChildGamerounds $l)
    {
        if ($this->collRounds === null) {
            $this->initRounds();
            $this->collRoundsPartial = true;
        }

        if (!$this->collRounds->contains($l)) {
            $this->doAddRound($l);

            if ($this->roundsScheduledForDeletion and $this->roundsScheduledForDeletion->contains($l)) {
                $this->roundsScheduledForDeletion->remove($this->roundsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGamerounds $round The ChildGamerounds object to add.
     */
    protected function doAddRound(ChildGamerounds $round)
    {
        $this->collRounds[]= $round;
        $round->setGames($this);
    }

    /**
     * @param  ChildGamerounds $round The ChildGamerounds object to remove.
     * @return $this|ChildGames The current object (for fluent API support)
     */
    public function removeRound(ChildGamerounds $round)
    {
        if ($this->getRounds()->contains($round)) {
            $pos = $this->collRounds->search($round);
            $this->collRounds->remove($pos);
            if (null === $this->roundsScheduledForDeletion) {
                $this->roundsScheduledForDeletion = clone $this->collRounds;
                $this->roundsScheduledForDeletion->clear();
            }
            $this->roundsScheduledForDeletion[]= clone $round;
            $round->setGames(null);
        }

        return $this;
    }

    /**
     * Clears out the collScores collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addScores()
     */
    public function clearScores()
    {
        $this->collScores = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collScores collection loaded partially.
     */
    public function resetPartialScores($v = true)
    {
        $this->collScoresPartial = $v;
    }

    /**
     * Initializes the collScores collection.
     *
     * By default this just sets the collScores collection to an empty array (like clearcollScores());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initScores($overrideExisting = true)
    {
        if (null !== $this->collScores && !$overrideExisting) {
            return;
        }

        $collectionClassName = GamescoresTableMap::getTableMap()->getCollectionClassName();

        $this->collScores = new $collectionClassName;
        $this->collScores->setModel('\Gamescores');
    }

    /**
     * Gets an array of ChildGamescores objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGames is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGamescores[] List of ChildGamescores objects
     * @phpstan-return ObjectCollection&\Traversable<ChildGamescores> List of ChildGamescores objects
     * @throws PropelException
     */
    public function getScores(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collScoresPartial && !$this->isNew();
        if (null === $this->collScores || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collScores) {
                    $this->initScores();
                } else {
                    $collectionClassName = GamescoresTableMap::getTableMap()->getCollectionClassName();

                    $collScores = new $collectionClassName;
                    $collScores->setModel('\Gamescores');

                    return $collScores;
                }
            } else {
                $collScores = ChildGamescoresQuery::create(null, $criteria)
                    ->filterByGames($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collScoresPartial && count($collScores)) {
                        $this->initScores(false);

                        foreach ($collScores as $obj) {
                            if (false == $this->collScores->contains($obj)) {
                                $this->collScores->append($obj);
                            }
                        }

                        $this->collScoresPartial = true;
                    }

                    return $collScores;
                }

                if ($partial && $this->collScores) {
                    foreach ($this->collScores as $obj) {
                        if ($obj->isNew()) {
                            $collScores[] = $obj;
                        }
                    }
                }

                $this->collScores = $collScores;
                $this->collScoresPartial = false;
            }
        }

        return $this->collScores;
    }

    /**
     * Sets a collection of ChildGamescores objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $scores A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGames The current object (for fluent API support)
     */
    public function setScores(Collection $scores, ConnectionInterface $con = null)
    {
        /** @var ChildGamescores[] $scoresToDelete */
        $scoresToDelete = $this->getScores(new Criteria(), $con)->diff($scores);


        $this->scoresScheduledForDeletion = $scoresToDelete;

        foreach ($scoresToDelete as $scoreRemoved) {
            $scoreRemoved->setGames(null);
        }

        $this->collScores = null;
        foreach ($scores as $score) {
            $this->addScore($score);
        }

        $this->collScores = $scores;
        $this->collScoresPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Gamescores objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Gamescores objects.
     * @throws PropelException
     */
    public function countScores(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collScoresPartial && !$this->isNew();
        if (null === $this->collScores || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collScores) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getScores());
            }

            $query = ChildGamescoresQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGames($this)
                ->count($con);
        }

        return count($this->collScores);
    }

    /**
     * Method called to associate a ChildGamescores object to this object
     * through the ChildGamescores foreign key attribute.
     *
     * @param  ChildGamescores $l ChildGamescores
     * @return $this|\Games The current object (for fluent API support)
     */
    public function addScore(ChildGamescores $l)
    {
        if ($this->collScores === null) {
            $this->initScores();
            $this->collScoresPartial = true;
        }

        if (!$this->collScores->contains($l)) {
            $this->doAddScore($l);

            if ($this->scoresScheduledForDeletion and $this->scoresScheduledForDeletion->contains($l)) {
                $this->scoresScheduledForDeletion->remove($this->scoresScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGamescores $score The ChildGamescores object to add.
     */
    protected function doAddScore(ChildGamescores $score)
    {
        $this->collScores[]= $score;
        $score->setGames($this);
    }

    /**
     * @param  ChildGamescores $score The ChildGamescores object to remove.
     * @return $this|ChildGames The current object (for fluent API support)
     */
    public function removeScore(ChildGamescores $score)
    {
        if ($this->getScores()->contains($score)) {
            $pos = $this->collScores->search($score);
            $this->collScores->remove($pos);
            if (null === $this->scoresScheduledForDeletion) {
                $this->scoresScheduledForDeletion = clone $this->collScores;
                $this->scoresScheduledForDeletion->clear();
            }
            $this->scoresScheduledForDeletion[]= clone $score;
            $score->setGames(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Games is new, it will return
     * an empty collection; or if this Games has previously
     * been saved, it will retrieve related Scores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Games.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGamescores[] List of ChildGamescores objects
     * @phpstan-return ObjectCollection&\Traversable<ChildGamescores}> List of ChildGamescores objects
     */
    public function getScoresJoinPlayers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGamescoresQuery::create(null, $criteria);
        $query->joinWith('Players', $joinBehavior);

        return $this->getScores($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aMaps) {
            $this->aMaps->removeGame($this);
        }
        if (null !== $this->aGamestypes) {
            $this->aGamestypes->removeGame($this);
        }
        $this->id = null;
        $this->gamenb = null;
        $this->map_id = null;
        $this->gametype_id = null;
        $this->timelimit = null;
        $this->roundtime = null;
        $this->nbplayers = null;
        $this->redscore = null;
        $this->bluescore = null;
        $this->redscore2 = null;
        $this->bluescore2 = null;
        $this->created = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collRounds) {
                foreach ($this->collRounds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collScores) {
                foreach ($this->collScores as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRounds = null;
        $this->collScores = null;
        $this->aMaps = null;
        $this->aGamestypes = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GamesTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
