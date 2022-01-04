<?php

namespace Base;

use \Bombs as ChildBombs;
use \BombsQuery as ChildBombsQuery;
use \Flags as ChildFlags;
use \FlagsQuery as ChildFlagsQuery;
use \Frags as ChildFrags;
use \FragsQuery as ChildFragsQuery;
use \Gamerounds as ChildGamerounds;
use \GameroundsQuery as ChildGameroundsQuery;
use \Games as ChildGames;
use \GamesQuery as ChildGamesQuery;
use \Hits as ChildHits;
use \HitsQuery as ChildHitsQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\BombsTableMap;
use Map\FlagsTableMap;
use Map\FragsTableMap;
use Map\GameroundsTableMap;
use Map\HitsTableMap;
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
 * Base class that represents a row from the 'gamerounds' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Gamerounds implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\GameroundsTableMap';


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
     * The value for the roundnb field.
     *
     * @var        int
     */
    protected $roundnb;

    /**
     * The value for the game_id field.
     *
     * @var        int
     */
    protected $game_id;

    /**
     * The value for the created field.
     *
     * @var        DateTime
     */
    protected $created;

    /**
     * @var        ChildGames
     */
    protected $aGames;

    /**
     * @var        ObjectCollection|ChildBombs[] Collection to store aggregation of ChildBombs objects.
     */
    protected $collBombs;
    protected $collBombsPartial;

    /**
     * @var        ObjectCollection|ChildFlags[] Collection to store aggregation of ChildFlags objects.
     */
    protected $collFlags;
    protected $collFlagsPartial;

    /**
     * @var        ObjectCollection|ChildFrags[] Collection to store aggregation of ChildFrags objects.
     */
    protected $collFrags;
    protected $collFragsPartial;

    /**
     * @var        ObjectCollection|ChildHits[] Collection to store aggregation of ChildHits objects.
     */
    protected $collHits;
    protected $collHitsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBombs[]
     */
    protected $bombsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFlags[]
     */
    protected $flagsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFrags[]
     */
    protected $fragsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildHits[]
     */
    protected $hitsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Gamerounds object.
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
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Gamerounds</code> instance.  If
     * <code>obj</code> is an instance of <code>Gamerounds</code>, delegates to
     * <code>equals(Gamerounds)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Gamerounds The current object, for fluid interface
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
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
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
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
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
     * Get the [roundnb] column value.
     *
     * @return int
     */
    public function getRoundNB()
    {
        return $this->roundnb;
    }

    /**
     * Get the [game_id] column value.
     *
     * @return int
     */
    public function getGameID()
    {
        return $this->game_id;
    }

    /**
     * Get the [optionally formatted] temporal [created] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreated($format = NULL)
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
     * @param int $v new value
     * @return $this|\Gamerounds The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[GameroundsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [roundnb] column.
     *
     * @param int $v new value
     * @return $this|\Gamerounds The current object (for fluent API support)
     */
    public function setRoundNB($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->roundnb !== $v) {
            $this->roundnb = $v;
            $this->modifiedColumns[GameroundsTableMap::COL_ROUNDNB] = true;
        }

        return $this;
    } // setRoundNB()

    /**
     * Set the value of [game_id] column.
     *
     * @param int $v new value
     * @return $this|\Gamerounds The current object (for fluent API support)
     */
    public function setGameID($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->game_id !== $v) {
            $this->game_id = $v;
            $this->modifiedColumns[GameroundsTableMap::COL_GAME_ID] = true;
        }

        if ($this->aGames !== null && $this->aGames->getId() !== $v) {
            $this->aGames = null;
        }

        return $this;
    } // setGameID()

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Gamerounds The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created !== null || $dt !== null) {
            if ($this->created === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created->format("Y-m-d H:i:s.u")) {
                $this->created = $dt === null ? null : clone $dt;
                $this->modifiedColumns[GameroundsTableMap::COL_CREATED] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : GameroundsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : GameroundsTableMap::translateFieldName('RoundNB', TableMap::TYPE_PHPNAME, $indexType)];
            $this->roundnb = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : GameroundsTableMap::translateFieldName('GameID', TableMap::TYPE_PHPNAME, $indexType)];
            $this->game_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : GameroundsTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = GameroundsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Gamerounds'), 0, $e);
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
        if ($this->aGames !== null && $this->game_id !== $this->aGames->getId()) {
            $this->aGames = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(GameroundsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildGameroundsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aGames = null;
            $this->collBombs = null;

            $this->collFlags = null;

            $this->collFrags = null;

            $this->collHits = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Gamerounds::setDeleted()
     * @see Gamerounds::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameroundsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildGameroundsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(GameroundsTableMap::DATABASE_NAME);
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
                GameroundsTableMap::addInstanceToPool($this);
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

            if ($this->aGames !== null) {
                if ($this->aGames->isModified() || $this->aGames->isNew()) {
                    $affectedRows += $this->aGames->save($con);
                }
                $this->setGames($this->aGames);
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

            if ($this->bombsScheduledForDeletion !== null) {
                if (!$this->bombsScheduledForDeletion->isEmpty()) {
                    \BombsQuery::create()
                        ->filterByPrimaryKeys($this->bombsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->bombsScheduledForDeletion = null;
                }
            }

            if ($this->collBombs !== null) {
                foreach ($this->collBombs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->flagsScheduledForDeletion !== null) {
                if (!$this->flagsScheduledForDeletion->isEmpty()) {
                    \FlagsQuery::create()
                        ->filterByPrimaryKeys($this->flagsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->flagsScheduledForDeletion = null;
                }
            }

            if ($this->collFlags !== null) {
                foreach ($this->collFlags as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->fragsScheduledForDeletion !== null) {
                if (!$this->fragsScheduledForDeletion->isEmpty()) {
                    \FragsQuery::create()
                        ->filterByPrimaryKeys($this->fragsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->fragsScheduledForDeletion = null;
                }
            }

            if ($this->collFrags !== null) {
                foreach ($this->collFrags as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->hitsScheduledForDeletion !== null) {
                if (!$this->hitsScheduledForDeletion->isEmpty()) {
                    \HitsQuery::create()
                        ->filterByPrimaryKeys($this->hitsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->hitsScheduledForDeletion = null;
                }
            }

            if ($this->collHits !== null) {
                foreach ($this->collHits as $referrerFK) {
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

        $this->modifiedColumns[GameroundsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GameroundsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GameroundsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(GameroundsTableMap::COL_ROUNDNB)) {
            $modifiedColumns[':p' . $index++]  = 'roundnb';
        }
        if ($this->isColumnModified(GameroundsTableMap::COL_GAME_ID)) {
            $modifiedColumns[':p' . $index++]  = 'game_id';
        }
        if ($this->isColumnModified(GameroundsTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }

        $sql = sprintf(
            'INSERT INTO gamerounds (%s) VALUES (%s)',
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
                    case 'roundnb':
                        $stmt->bindValue($identifier, $this->roundnb, PDO::PARAM_INT);
                        break;
                    case 'game_id':
                        $stmt->bindValue($identifier, $this->game_id, PDO::PARAM_INT);
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
        $pos = GameroundsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getRoundNB();
                break;
            case 2:
                return $this->getGameID();
                break;
            case 3:
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

        if (isset($alreadyDumpedObjects['Gamerounds'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Gamerounds'][$this->hashCode()] = true;
        $keys = GameroundsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getRoundNB(),
            $keys[2] => $this->getGameID(),
            $keys[3] => $this->getCreated(),
        );
        if ($result[$keys[3]] instanceof \DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aGames) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'games';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'games';
                        break;
                    default:
                        $key = 'Games';
                }

                $result[$key] = $this->aGames->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collBombs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bombss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'bombss';
                        break;
                    default:
                        $key = 'Bombs';
                }

                $result[$key] = $this->collBombs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFlags) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'flagss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'flagss';
                        break;
                    default:
                        $key = 'Flags';
                }

                $result[$key] = $this->collFlags->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFrags) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fragss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fragss';
                        break;
                    default:
                        $key = 'Frags';
                }

                $result[$key] = $this->collFrags->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collHits) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'hitss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'hitss';
                        break;
                    default:
                        $key = 'Hits';
                }

                $result[$key] = $this->collHits->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Gamerounds
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GameroundsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Gamerounds
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setRoundNB($value);
                break;
            case 2:
                $this->setGameID($value);
                break;
            case 3:
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
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = GameroundsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setRoundNB($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setGameID($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCreated($arr[$keys[3]]);
        }
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
     * @return $this|\Gamerounds The current object, for fluid interface
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
        $criteria = new Criteria(GameroundsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(GameroundsTableMap::COL_ID)) {
            $criteria->add(GameroundsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(GameroundsTableMap::COL_ROUNDNB)) {
            $criteria->add(GameroundsTableMap::COL_ROUNDNB, $this->roundnb);
        }
        if ($this->isColumnModified(GameroundsTableMap::COL_GAME_ID)) {
            $criteria->add(GameroundsTableMap::COL_GAME_ID, $this->game_id);
        }
        if ($this->isColumnModified(GameroundsTableMap::COL_CREATED)) {
            $criteria->add(GameroundsTableMap::COL_CREATED, $this->created);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildGameroundsQuery::create();
        $criteria->add(GameroundsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Gamerounds (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setRoundNB($this->getRoundNB());
        $copyObj->setGameID($this->getGameID());
        $copyObj->setCreated($this->getCreated());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getBombs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBomb($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFlags() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFlag($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFrags() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFrag($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getHits() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addHit($relObj->copy($deepCopy));
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
     * @return \Gamerounds Clone of current object.
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
     * Declares an association between this object and a ChildGames object.
     *
     * @param  ChildGames $v
     * @return $this|\Gamerounds The current object (for fluent API support)
     * @throws PropelException
     */
    public function setGames(ChildGames $v = null)
    {
        if ($v === null) {
            $this->setGameID(NULL);
        } else {
            $this->setGameID($v->getId());
        }

        $this->aGames = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildGames object, it will not be re-added.
        if ($v !== null) {
            $v->addRound($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildGames object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildGames The associated ChildGames object.
     * @throws PropelException
     */
    public function getGames(ConnectionInterface $con = null)
    {
        if ($this->aGames === null && ($this->game_id != 0)) {
            $this->aGames = ChildGamesQuery::create()->findPk($this->game_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aGames->addRounds($this);
             */
        }

        return $this->aGames;
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
        if ('Bomb' == $relationName) {
            $this->initBombs();
            return;
        }
        if ('Flag' == $relationName) {
            $this->initFlags();
            return;
        }
        if ('Frag' == $relationName) {
            $this->initFrags();
            return;
        }
        if ('Hit' == $relationName) {
            $this->initHits();
            return;
        }
    }

    /**
     * Clears out the collBombs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBombs()
     */
    public function clearBombs()
    {
        $this->collBombs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBombs collection loaded partially.
     */
    public function resetPartialBombs($v = true)
    {
        $this->collBombsPartial = $v;
    }

    /**
     * Initializes the collBombs collection.
     *
     * By default this just sets the collBombs collection to an empty array (like clearcollBombs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBombs($overrideExisting = true)
    {
        if (null !== $this->collBombs && !$overrideExisting) {
            return;
        }

        $collectionClassName = BombsTableMap::getTableMap()->getCollectionClassName();

        $this->collBombs = new $collectionClassName;
        $this->collBombs->setModel('\Bombs');
    }

    /**
     * Gets an array of ChildBombs objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGamerounds is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBombs[] List of ChildBombs objects
     * @throws PropelException
     */
    public function getBombs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBombsPartial && !$this->isNew();
        if (null === $this->collBombs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBombs) {
                // return empty collection
                $this->initBombs();
            } else {
                $collBombs = ChildBombsQuery::create(null, $criteria)
                    ->filterByRounds($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBombsPartial && count($collBombs)) {
                        $this->initBombs(false);

                        foreach ($collBombs as $obj) {
                            if (false == $this->collBombs->contains($obj)) {
                                $this->collBombs->append($obj);
                            }
                        }

                        $this->collBombsPartial = true;
                    }

                    return $collBombs;
                }

                if ($partial && $this->collBombs) {
                    foreach ($this->collBombs as $obj) {
                        if ($obj->isNew()) {
                            $collBombs[] = $obj;
                        }
                    }
                }

                $this->collBombs = $collBombs;
                $this->collBombsPartial = false;
            }
        }

        return $this->collBombs;
    }

    /**
     * Sets a collection of ChildBombs objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $bombs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGamerounds The current object (for fluent API support)
     */
    public function setBombs(Collection $bombs, ConnectionInterface $con = null)
    {
        /** @var ChildBombs[] $bombsToDelete */
        $bombsToDelete = $this->getBombs(new Criteria(), $con)->diff($bombs);


        $this->bombsScheduledForDeletion = $bombsToDelete;

        foreach ($bombsToDelete as $bombRemoved) {
            $bombRemoved->setRounds(null);
        }

        $this->collBombs = null;
        foreach ($bombs as $bomb) {
            $this->addBomb($bomb);
        }

        $this->collBombs = $bombs;
        $this->collBombsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Bombs objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Bombs objects.
     * @throws PropelException
     */
    public function countBombs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBombsPartial && !$this->isNew();
        if (null === $this->collBombs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBombs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBombs());
            }

            $query = ChildBombsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRounds($this)
                ->count($con);
        }

        return count($this->collBombs);
    }

    /**
     * Method called to associate a ChildBombs object to this object
     * through the ChildBombs foreign key attribute.
     *
     * @param  ChildBombs $l ChildBombs
     * @return $this|\Gamerounds The current object (for fluent API support)
     */
    public function addBomb(ChildBombs $l)
    {
        if ($this->collBombs === null) {
            $this->initBombs();
            $this->collBombsPartial = true;
        }

        if (!$this->collBombs->contains($l)) {
            $this->doAddBomb($l);

            if ($this->bombsScheduledForDeletion and $this->bombsScheduledForDeletion->contains($l)) {
                $this->bombsScheduledForDeletion->remove($this->bombsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBombs $bomb The ChildBombs object to add.
     */
    protected function doAddBomb(ChildBombs $bomb)
    {
        $this->collBombs[]= $bomb;
        $bomb->setRounds($this);
    }

    /**
     * @param  ChildBombs $bomb The ChildBombs object to remove.
     * @return $this|ChildGamerounds The current object (for fluent API support)
     */
    public function removeBomb(ChildBombs $bomb)
    {
        if ($this->getBombs()->contains($bomb)) {
            $pos = $this->collBombs->search($bomb);
            $this->collBombs->remove($pos);
            if (null === $this->bombsScheduledForDeletion) {
                $this->bombsScheduledForDeletion = clone $this->collBombs;
                $this->bombsScheduledForDeletion->clear();
            }
            $this->bombsScheduledForDeletion[]= clone $bomb;
            $bomb->setRounds(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Gamerounds is new, it will return
     * an empty collection; or if this Gamerounds has previously
     * been saved, it will retrieve related Bombs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Gamerounds.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBombs[] List of ChildBombs objects
     */
    public function getBombsJoinPlayers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBombsQuery::create(null, $criteria);
        $query->joinWith('Players', $joinBehavior);

        return $this->getBombs($query, $con);
    }

    /**
     * Clears out the collFlags collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFlags()
     */
    public function clearFlags()
    {
        $this->collFlags = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFlags collection loaded partially.
     */
    public function resetPartialFlags($v = true)
    {
        $this->collFlagsPartial = $v;
    }

    /**
     * Initializes the collFlags collection.
     *
     * By default this just sets the collFlags collection to an empty array (like clearcollFlags());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFlags($overrideExisting = true)
    {
        if (null !== $this->collFlags && !$overrideExisting) {
            return;
        }

        $collectionClassName = FlagsTableMap::getTableMap()->getCollectionClassName();

        $this->collFlags = new $collectionClassName;
        $this->collFlags->setModel('\Flags');
    }

    /**
     * Gets an array of ChildFlags objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGamerounds is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFlags[] List of ChildFlags objects
     * @throws PropelException
     */
    public function getFlags(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFlagsPartial && !$this->isNew();
        if (null === $this->collFlags || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFlags) {
                // return empty collection
                $this->initFlags();
            } else {
                $collFlags = ChildFlagsQuery::create(null, $criteria)
                    ->filterByRounds($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFlagsPartial && count($collFlags)) {
                        $this->initFlags(false);

                        foreach ($collFlags as $obj) {
                            if (false == $this->collFlags->contains($obj)) {
                                $this->collFlags->append($obj);
                            }
                        }

                        $this->collFlagsPartial = true;
                    }

                    return $collFlags;
                }

                if ($partial && $this->collFlags) {
                    foreach ($this->collFlags as $obj) {
                        if ($obj->isNew()) {
                            $collFlags[] = $obj;
                        }
                    }
                }

                $this->collFlags = $collFlags;
                $this->collFlagsPartial = false;
            }
        }

        return $this->collFlags;
    }

    /**
     * Sets a collection of ChildFlags objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $flags A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGamerounds The current object (for fluent API support)
     */
    public function setFlags(Collection $flags, ConnectionInterface $con = null)
    {
        /** @var ChildFlags[] $flagsToDelete */
        $flagsToDelete = $this->getFlags(new Criteria(), $con)->diff($flags);


        $this->flagsScheduledForDeletion = $flagsToDelete;

        foreach ($flagsToDelete as $flagRemoved) {
            $flagRemoved->setRounds(null);
        }

        $this->collFlags = null;
        foreach ($flags as $flag) {
            $this->addFlag($flag);
        }

        $this->collFlags = $flags;
        $this->collFlagsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Flags objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Flags objects.
     * @throws PropelException
     */
    public function countFlags(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFlagsPartial && !$this->isNew();
        if (null === $this->collFlags || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFlags) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFlags());
            }

            $query = ChildFlagsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRounds($this)
                ->count($con);
        }

        return count($this->collFlags);
    }

    /**
     * Method called to associate a ChildFlags object to this object
     * through the ChildFlags foreign key attribute.
     *
     * @param  ChildFlags $l ChildFlags
     * @return $this|\Gamerounds The current object (for fluent API support)
     */
    public function addFlag(ChildFlags $l)
    {
        if ($this->collFlags === null) {
            $this->initFlags();
            $this->collFlagsPartial = true;
        }

        if (!$this->collFlags->contains($l)) {
            $this->doAddFlag($l);

            if ($this->flagsScheduledForDeletion and $this->flagsScheduledForDeletion->contains($l)) {
                $this->flagsScheduledForDeletion->remove($this->flagsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildFlags $flag The ChildFlags object to add.
     */
    protected function doAddFlag(ChildFlags $flag)
    {
        $this->collFlags[]= $flag;
        $flag->setRounds($this);
    }

    /**
     * @param  ChildFlags $flag The ChildFlags object to remove.
     * @return $this|ChildGamerounds The current object (for fluent API support)
     */
    public function removeFlag(ChildFlags $flag)
    {
        if ($this->getFlags()->contains($flag)) {
            $pos = $this->collFlags->search($flag);
            $this->collFlags->remove($pos);
            if (null === $this->flagsScheduledForDeletion) {
                $this->flagsScheduledForDeletion = clone $this->collFlags;
                $this->flagsScheduledForDeletion->clear();
            }
            $this->flagsScheduledForDeletion[]= clone $flag;
            $flag->setRounds(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Gamerounds is new, it will return
     * an empty collection; or if this Gamerounds has previously
     * been saved, it will retrieve related Flags from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Gamerounds.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFlags[] List of ChildFlags objects
     */
    public function getFlagsJoinPlayers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFlagsQuery::create(null, $criteria);
        $query->joinWith('Players', $joinBehavior);

        return $this->getFlags($query, $con);
    }

    /**
     * Clears out the collFrags collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFrags()
     */
    public function clearFrags()
    {
        $this->collFrags = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFrags collection loaded partially.
     */
    public function resetPartialFrags($v = true)
    {
        $this->collFragsPartial = $v;
    }

    /**
     * Initializes the collFrags collection.
     *
     * By default this just sets the collFrags collection to an empty array (like clearcollFrags());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFrags($overrideExisting = true)
    {
        if (null !== $this->collFrags && !$overrideExisting) {
            return;
        }

        $collectionClassName = FragsTableMap::getTableMap()->getCollectionClassName();

        $this->collFrags = new $collectionClassName;
        $this->collFrags->setModel('\Frags');
    }

    /**
     * Gets an array of ChildFrags objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGamerounds is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFrags[] List of ChildFrags objects
     * @throws PropelException
     */
    public function getFrags(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFragsPartial && !$this->isNew();
        if (null === $this->collFrags || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFrags) {
                // return empty collection
                $this->initFrags();
            } else {
                $collFrags = ChildFragsQuery::create(null, $criteria)
                    ->filterByRounds($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFragsPartial && count($collFrags)) {
                        $this->initFrags(false);

                        foreach ($collFrags as $obj) {
                            if (false == $this->collFrags->contains($obj)) {
                                $this->collFrags->append($obj);
                            }
                        }

                        $this->collFragsPartial = true;
                    }

                    return $collFrags;
                }

                if ($partial && $this->collFrags) {
                    foreach ($this->collFrags as $obj) {
                        if ($obj->isNew()) {
                            $collFrags[] = $obj;
                        }
                    }
                }

                $this->collFrags = $collFrags;
                $this->collFragsPartial = false;
            }
        }

        return $this->collFrags;
    }

    /**
     * Sets a collection of ChildFrags objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $frags A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGamerounds The current object (for fluent API support)
     */
    public function setFrags(Collection $frags, ConnectionInterface $con = null)
    {
        /** @var ChildFrags[] $fragsToDelete */
        $fragsToDelete = $this->getFrags(new Criteria(), $con)->diff($frags);


        $this->fragsScheduledForDeletion = $fragsToDelete;

        foreach ($fragsToDelete as $fragRemoved) {
            $fragRemoved->setRounds(null);
        }

        $this->collFrags = null;
        foreach ($frags as $frag) {
            $this->addFrag($frag);
        }

        $this->collFrags = $frags;
        $this->collFragsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Frags objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Frags objects.
     * @throws PropelException
     */
    public function countFrags(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFragsPartial && !$this->isNew();
        if (null === $this->collFrags || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFrags) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFrags());
            }

            $query = ChildFragsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRounds($this)
                ->count($con);
        }

        return count($this->collFrags);
    }

    /**
     * Method called to associate a ChildFrags object to this object
     * through the ChildFrags foreign key attribute.
     *
     * @param  ChildFrags $l ChildFrags
     * @return $this|\Gamerounds The current object (for fluent API support)
     */
    public function addFrag(ChildFrags $l)
    {
        if ($this->collFrags === null) {
            $this->initFrags();
            $this->collFragsPartial = true;
        }

        if (!$this->collFrags->contains($l)) {
            $this->doAddFrag($l);

            if ($this->fragsScheduledForDeletion and $this->fragsScheduledForDeletion->contains($l)) {
                $this->fragsScheduledForDeletion->remove($this->fragsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildFrags $frag The ChildFrags object to add.
     */
    protected function doAddFrag(ChildFrags $frag)
    {
        $this->collFrags[]= $frag;
        $frag->setRounds($this);
    }

    /**
     * @param  ChildFrags $frag The ChildFrags object to remove.
     * @return $this|ChildGamerounds The current object (for fluent API support)
     */
    public function removeFrag(ChildFrags $frag)
    {
        if ($this->getFrags()->contains($frag)) {
            $pos = $this->collFrags->search($frag);
            $this->collFrags->remove($pos);
            if (null === $this->fragsScheduledForDeletion) {
                $this->fragsScheduledForDeletion = clone $this->collFrags;
                $this->fragsScheduledForDeletion->clear();
            }
            $this->fragsScheduledForDeletion[]= clone $frag;
            $frag->setRounds(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Gamerounds is new, it will return
     * an empty collection; or if this Gamerounds has previously
     * been saved, it will retrieve related Frags from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Gamerounds.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFrags[] List of ChildFrags objects
     */
    public function getFragsJoinFragger(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFragsQuery::create(null, $criteria);
        $query->joinWith('Fragger', $joinBehavior);

        return $this->getFrags($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Gamerounds is new, it will return
     * an empty collection; or if this Gamerounds has previously
     * been saved, it will retrieve related Frags from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Gamerounds.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFrags[] List of ChildFrags objects
     */
    public function getFragsJoinFragged(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFragsQuery::create(null, $criteria);
        $query->joinWith('Fragged', $joinBehavior);

        return $this->getFrags($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Gamerounds is new, it will return
     * an empty collection; or if this Gamerounds has previously
     * been saved, it will retrieve related Frags from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Gamerounds.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFrags[] List of ChildFrags objects
     */
    public function getFragsJoinWeapons(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFragsQuery::create(null, $criteria);
        $query->joinWith('Weapons', $joinBehavior);

        return $this->getFrags($query, $con);
    }

    /**
     * Clears out the collHits collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addHits()
     */
    public function clearHits()
    {
        $this->collHits = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collHits collection loaded partially.
     */
    public function resetPartialHits($v = true)
    {
        $this->collHitsPartial = $v;
    }

    /**
     * Initializes the collHits collection.
     *
     * By default this just sets the collHits collection to an empty array (like clearcollHits());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initHits($overrideExisting = true)
    {
        if (null !== $this->collHits && !$overrideExisting) {
            return;
        }

        $collectionClassName = HitsTableMap::getTableMap()->getCollectionClassName();

        $this->collHits = new $collectionClassName;
        $this->collHits->setModel('\Hits');
    }

    /**
     * Gets an array of ChildHits objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGamerounds is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildHits[] List of ChildHits objects
     * @throws PropelException
     */
    public function getHits(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collHitsPartial && !$this->isNew();
        if (null === $this->collHits || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collHits) {
                // return empty collection
                $this->initHits();
            } else {
                $collHits = ChildHitsQuery::create(null, $criteria)
                    ->filterByRounds($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collHitsPartial && count($collHits)) {
                        $this->initHits(false);

                        foreach ($collHits as $obj) {
                            if (false == $this->collHits->contains($obj)) {
                                $this->collHits->append($obj);
                            }
                        }

                        $this->collHitsPartial = true;
                    }

                    return $collHits;
                }

                if ($partial && $this->collHits) {
                    foreach ($this->collHits as $obj) {
                        if ($obj->isNew()) {
                            $collHits[] = $obj;
                        }
                    }
                }

                $this->collHits = $collHits;
                $this->collHitsPartial = false;
            }
        }

        return $this->collHits;
    }

    /**
     * Sets a collection of ChildHits objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $hits A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGamerounds The current object (for fluent API support)
     */
    public function setHits(Collection $hits, ConnectionInterface $con = null)
    {
        /** @var ChildHits[] $hitsToDelete */
        $hitsToDelete = $this->getHits(new Criteria(), $con)->diff($hits);


        $this->hitsScheduledForDeletion = $hitsToDelete;

        foreach ($hitsToDelete as $hitRemoved) {
            $hitRemoved->setRounds(null);
        }

        $this->collHits = null;
        foreach ($hits as $hit) {
            $this->addHit($hit);
        }

        $this->collHits = $hits;
        $this->collHitsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Hits objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Hits objects.
     * @throws PropelException
     */
    public function countHits(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collHitsPartial && !$this->isNew();
        if (null === $this->collHits || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collHits) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getHits());
            }

            $query = ChildHitsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRounds($this)
                ->count($con);
        }

        return count($this->collHits);
    }

    /**
     * Method called to associate a ChildHits object to this object
     * through the ChildHits foreign key attribute.
     *
     * @param  ChildHits $l ChildHits
     * @return $this|\Gamerounds The current object (for fluent API support)
     */
    public function addHit(ChildHits $l)
    {
        if ($this->collHits === null) {
            $this->initHits();
            $this->collHitsPartial = true;
        }

        if (!$this->collHits->contains($l)) {
            $this->doAddHit($l);

            if ($this->hitsScheduledForDeletion and $this->hitsScheduledForDeletion->contains($l)) {
                $this->hitsScheduledForDeletion->remove($this->hitsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildHits $hit The ChildHits object to add.
     */
    protected function doAddHit(ChildHits $hit)
    {
        $this->collHits[]= $hit;
        $hit->setRounds($this);
    }

    /**
     * @param  ChildHits $hit The ChildHits object to remove.
     * @return $this|ChildGamerounds The current object (for fluent API support)
     */
    public function removeHit(ChildHits $hit)
    {
        if ($this->getHits()->contains($hit)) {
            $pos = $this->collHits->search($hit);
            $this->collHits->remove($pos);
            if (null === $this->hitsScheduledForDeletion) {
                $this->hitsScheduledForDeletion = clone $this->collHits;
                $this->hitsScheduledForDeletion->clear();
            }
            $this->hitsScheduledForDeletion[]= clone $hit;
            $hit->setRounds(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Gamerounds is new, it will return
     * an empty collection; or if this Gamerounds has previously
     * been saved, it will retrieve related Hits from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Gamerounds.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildHits[] List of ChildHits objects
     */
    public function getHitsJoinHitter(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildHitsQuery::create(null, $criteria);
        $query->joinWith('Hitter', $joinBehavior);

        return $this->getHits($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Gamerounds is new, it will return
     * an empty collection; or if this Gamerounds has previously
     * been saved, it will retrieve related Hits from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Gamerounds.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildHits[] List of ChildHits objects
     */
    public function getHitsJoinHitted(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildHitsQuery::create(null, $criteria);
        $query->joinWith('Hitted', $joinBehavior);

        return $this->getHits($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Gamerounds is new, it will return
     * an empty collection; or if this Gamerounds has previously
     * been saved, it will retrieve related Hits from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Gamerounds.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildHits[] List of ChildHits objects
     */
    public function getHitsJoinBodyparts(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildHitsQuery::create(null, $criteria);
        $query->joinWith('Bodyparts', $joinBehavior);

        return $this->getHits($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aGames) {
            $this->aGames->removeRound($this);
        }
        $this->id = null;
        $this->roundnb = null;
        $this->game_id = null;
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
            if ($this->collBombs) {
                foreach ($this->collBombs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFlags) {
                foreach ($this->collFlags as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFrags) {
                foreach ($this->collFrags as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collHits) {
                foreach ($this->collHits as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBombs = null;
        $this->collFlags = null;
        $this->collFrags = null;
        $this->collHits = null;
        $this->aGames = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GameroundsTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
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

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
