<?php

namespace Base;

use \Gametypes as ChildGametypes;
use \GametypesQuery as ChildGametypesQuery;
use \Rounds as ChildRounds;
use \RoundsQuery as ChildRoundsQuery;
use \Teams as ChildTeams;
use \TeamsQuery as ChildTeamsQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\RoundsTableMap;
use Map\TeamsTableMap;
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
 * Base class that represents a row from the 'rounds' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Rounds implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\RoundsTableMap';


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
     * The value for the winner field.
     *
     * @var        string
     */
    protected $winner;

    /**
     * The value for the red_score field.
     *
     * @var        int
     */
    protected $red_score;

    /**
     * The value for the blue_score field.
     *
     * @var        int
     */
    protected $blue_score;

    /**
     * The value for the gametype_id field.
     *
     * @var        int
     */
    protected $gametype_id;

    /**
     * The value for the nbplayers field.
     *
     * @var        int
     */
    protected $nbplayers;

    /**
     * The value for the created field.
     *
     * @var        DateTime
     */
    protected $created;

    /**
     * @var        ChildGametypes
     */
    protected $aGametypes;

    /**
     * @var        ObjectCollection|ChildTeams[] Collection to store aggregation of ChildTeams objects.
     */
    protected $collTeams;
    protected $collTeamsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTeams[]
     */
    protected $teamsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Rounds object.
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
     * Compares this with another <code>Rounds</code> instance.  If
     * <code>obj</code> is an instance of <code>Rounds</code>, delegates to
     * <code>equals(Rounds)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Rounds The current object, for fluid interface
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
     * Get the [winner] column value.
     *
     * @return string
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Get the [red_score] column value.
     *
     * @return int
     */
    public function getRedScore()
    {
        return $this->red_score;
    }

    /**
     * Get the [blue_score] column value.
     *
     * @return int
     */
    public function getBlueScore()
    {
        return $this->blue_score;
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
     * Get the [nbplayers] column value.
     *
     * @return int
     */
    public function getNbplayers()
    {
        return $this->nbplayers;
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
     * @return $this|\Rounds The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[RoundsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [winner] column.
     *
     * @param string $v new value
     * @return $this|\Rounds The current object (for fluent API support)
     */
    public function setWinner($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->winner !== $v) {
            $this->winner = $v;
            $this->modifiedColumns[RoundsTableMap::COL_WINNER] = true;
        }

        return $this;
    } // setWinner()

    /**
     * Set the value of [red_score] column.
     *
     * @param int $v new value
     * @return $this|\Rounds The current object (for fluent API support)
     */
    public function setRedScore($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->red_score !== $v) {
            $this->red_score = $v;
            $this->modifiedColumns[RoundsTableMap::COL_RED_SCORE] = true;
        }

        return $this;
    } // setRedScore()

    /**
     * Set the value of [blue_score] column.
     *
     * @param int $v new value
     * @return $this|\Rounds The current object (for fluent API support)
     */
    public function setBlueScore($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->blue_score !== $v) {
            $this->blue_score = $v;
            $this->modifiedColumns[RoundsTableMap::COL_BLUE_SCORE] = true;
        }

        return $this;
    } // setBlueScore()

    /**
     * Set the value of [gametype_id] column.
     *
     * @param int $v new value
     * @return $this|\Rounds The current object (for fluent API support)
     */
    public function setGametypeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->gametype_id !== $v) {
            $this->gametype_id = $v;
            $this->modifiedColumns[RoundsTableMap::COL_GAMETYPE_ID] = true;
        }

        if ($this->aGametypes !== null && $this->aGametypes->getId() !== $v) {
            $this->aGametypes = null;
        }

        return $this;
    } // setGametypeId()

    /**
     * Set the value of [nbplayers] column.
     *
     * @param int $v new value
     * @return $this|\Rounds The current object (for fluent API support)
     */
    public function setNbplayers($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->nbplayers !== $v) {
            $this->nbplayers = $v;
            $this->modifiedColumns[RoundsTableMap::COL_NBPLAYERS] = true;
        }

        return $this;
    } // setNbplayers()

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Rounds The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created !== null || $dt !== null) {
            if ($this->created === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created->format("Y-m-d H:i:s.u")) {
                $this->created = $dt === null ? null : clone $dt;
                $this->modifiedColumns[RoundsTableMap::COL_CREATED] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RoundsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RoundsTableMap::translateFieldName('Winner', TableMap::TYPE_PHPNAME, $indexType)];
            $this->winner = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RoundsTableMap::translateFieldName('RedScore', TableMap::TYPE_PHPNAME, $indexType)];
            $this->red_score = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : RoundsTableMap::translateFieldName('BlueScore', TableMap::TYPE_PHPNAME, $indexType)];
            $this->blue_score = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : RoundsTableMap::translateFieldName('GametypeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gametype_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : RoundsTableMap::translateFieldName('Nbplayers', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nbplayers = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : RoundsTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = RoundsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Rounds'), 0, $e);
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
        if ($this->aGametypes !== null && $this->gametype_id !== $this->aGametypes->getId()) {
            $this->aGametypes = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(RoundsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRoundsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aGametypes = null;
            $this->collTeams = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Rounds::setDeleted()
     * @see Rounds::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RoundsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRoundsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(RoundsTableMap::DATABASE_NAME);
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
                RoundsTableMap::addInstanceToPool($this);
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

            if ($this->aGametypes !== null) {
                if ($this->aGametypes->isModified() || $this->aGametypes->isNew()) {
                    $affectedRows += $this->aGametypes->save($con);
                }
                $this->setGametypes($this->aGametypes);
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

            if ($this->teamsScheduledForDeletion !== null) {
                if (!$this->teamsScheduledForDeletion->isEmpty()) {
                    \TeamsQuery::create()
                        ->filterByPrimaryKeys($this->teamsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->teamsScheduledForDeletion = null;
                }
            }

            if ($this->collTeams !== null) {
                foreach ($this->collTeams as $referrerFK) {
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RoundsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(RoundsTableMap::COL_WINNER)) {
            $modifiedColumns[':p' . $index++]  = 'winner';
        }
        if ($this->isColumnModified(RoundsTableMap::COL_RED_SCORE)) {
            $modifiedColumns[':p' . $index++]  = 'red_score';
        }
        if ($this->isColumnModified(RoundsTableMap::COL_BLUE_SCORE)) {
            $modifiedColumns[':p' . $index++]  = 'blue_score';
        }
        if ($this->isColumnModified(RoundsTableMap::COL_GAMETYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'gametype_id';
        }
        if ($this->isColumnModified(RoundsTableMap::COL_NBPLAYERS)) {
            $modifiedColumns[':p' . $index++]  = 'nbplayers';
        }
        if ($this->isColumnModified(RoundsTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }

        $sql = sprintf(
            'INSERT INTO rounds (%s) VALUES (%s)',
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
                    case 'winner':
                        $stmt->bindValue($identifier, $this->winner, PDO::PARAM_STR);
                        break;
                    case 'red_score':
                        $stmt->bindValue($identifier, $this->red_score, PDO::PARAM_INT);
                        break;
                    case 'blue_score':
                        $stmt->bindValue($identifier, $this->blue_score, PDO::PARAM_INT);
                        break;
                    case 'gametype_id':
                        $stmt->bindValue($identifier, $this->gametype_id, PDO::PARAM_INT);
                        break;
                    case 'nbplayers':
                        $stmt->bindValue($identifier, $this->nbplayers, PDO::PARAM_INT);
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
        $pos = RoundsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getWinner();
                break;
            case 2:
                return $this->getRedScore();
                break;
            case 3:
                return $this->getBlueScore();
                break;
            case 4:
                return $this->getGametypeId();
                break;
            case 5:
                return $this->getNbplayers();
                break;
            case 6:
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

        if (isset($alreadyDumpedObjects['Rounds'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Rounds'][$this->hashCode()] = true;
        $keys = RoundsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getWinner(),
            $keys[2] => $this->getRedScore(),
            $keys[3] => $this->getBlueScore(),
            $keys[4] => $this->getGametypeId(),
            $keys[5] => $this->getNbplayers(),
            $keys[6] => $this->getCreated(),
        );
        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aGametypes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gametypes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gametypes';
                        break;
                    default:
                        $key = 'Gametypes';
                }

                $result[$key] = $this->aGametypes->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collTeams) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'teamss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'teamss';
                        break;
                    default:
                        $key = 'Teams';
                }

                $result[$key] = $this->collTeams->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Rounds
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RoundsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Rounds
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setWinner($value);
                break;
            case 2:
                $this->setRedScore($value);
                break;
            case 3:
                $this->setBlueScore($value);
                break;
            case 4:
                $this->setGametypeId($value);
                break;
            case 5:
                $this->setNbplayers($value);
                break;
            case 6:
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
        $keys = RoundsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setWinner($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setRedScore($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setBlueScore($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setGametypeId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setNbplayers($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setCreated($arr[$keys[6]]);
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
     * @return $this|\Rounds The current object, for fluid interface
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
        $criteria = new Criteria(RoundsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RoundsTableMap::COL_ID)) {
            $criteria->add(RoundsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(RoundsTableMap::COL_WINNER)) {
            $criteria->add(RoundsTableMap::COL_WINNER, $this->winner);
        }
        if ($this->isColumnModified(RoundsTableMap::COL_RED_SCORE)) {
            $criteria->add(RoundsTableMap::COL_RED_SCORE, $this->red_score);
        }
        if ($this->isColumnModified(RoundsTableMap::COL_BLUE_SCORE)) {
            $criteria->add(RoundsTableMap::COL_BLUE_SCORE, $this->blue_score);
        }
        if ($this->isColumnModified(RoundsTableMap::COL_GAMETYPE_ID)) {
            $criteria->add(RoundsTableMap::COL_GAMETYPE_ID, $this->gametype_id);
        }
        if ($this->isColumnModified(RoundsTableMap::COL_NBPLAYERS)) {
            $criteria->add(RoundsTableMap::COL_NBPLAYERS, $this->nbplayers);
        }
        if ($this->isColumnModified(RoundsTableMap::COL_CREATED)) {
            $criteria->add(RoundsTableMap::COL_CREATED, $this->created);
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
        $criteria = ChildRoundsQuery::create();
        $criteria->add(RoundsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Rounds (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setWinner($this->getWinner());
        $copyObj->setRedScore($this->getRedScore());
        $copyObj->setBlueScore($this->getBlueScore());
        $copyObj->setGametypeId($this->getGametypeId());
        $copyObj->setNbplayers($this->getNbplayers());
        $copyObj->setCreated($this->getCreated());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTeams() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTeam($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \Rounds Clone of current object.
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
     * Declares an association between this object and a ChildGametypes object.
     *
     * @param  ChildGametypes $v
     * @return $this|\Rounds The current object (for fluent API support)
     * @throws PropelException
     */
    public function setGametypes(ChildGametypes $v = null)
    {
        if ($v === null) {
            $this->setGametypeId(NULL);
        } else {
            $this->setGametypeId($v->getId());
        }

        $this->aGametypes = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildGametypes object, it will not be re-added.
        if ($v !== null) {
            $v->addRound($this);
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
    public function getGametypes(ConnectionInterface $con = null)
    {
        if ($this->aGametypes === null && ($this->gametype_id != 0)) {
            $this->aGametypes = ChildGametypesQuery::create()->findPk($this->gametype_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aGametypes->addRounds($this);
             */
        }

        return $this->aGametypes;
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
        if ('Team' == $relationName) {
            $this->initTeams();
            return;
        }
    }

    /**
     * Clears out the collTeams collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTeams()
     */
    public function clearTeams()
    {
        $this->collTeams = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTeams collection loaded partially.
     */
    public function resetPartialTeams($v = true)
    {
        $this->collTeamsPartial = $v;
    }

    /**
     * Initializes the collTeams collection.
     *
     * By default this just sets the collTeams collection to an empty array (like clearcollTeams());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTeams($overrideExisting = true)
    {
        if (null !== $this->collTeams && !$overrideExisting) {
            return;
        }

        $collectionClassName = TeamsTableMap::getTableMap()->getCollectionClassName();

        $this->collTeams = new $collectionClassName;
        $this->collTeams->setModel('\Teams');
    }

    /**
     * Gets an array of ChildTeams objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRounds is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTeams[] List of ChildTeams objects
     * @throws PropelException
     */
    public function getTeams(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTeamsPartial && !$this->isNew();
        if (null === $this->collTeams || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTeams) {
                // return empty collection
                $this->initTeams();
            } else {
                $collTeams = ChildTeamsQuery::create(null, $criteria)
                    ->filterByRounds($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTeamsPartial && count($collTeams)) {
                        $this->initTeams(false);

                        foreach ($collTeams as $obj) {
                            if (false == $this->collTeams->contains($obj)) {
                                $this->collTeams->append($obj);
                            }
                        }

                        $this->collTeamsPartial = true;
                    }

                    return $collTeams;
                }

                if ($partial && $this->collTeams) {
                    foreach ($this->collTeams as $obj) {
                        if ($obj->isNew()) {
                            $collTeams[] = $obj;
                        }
                    }
                }

                $this->collTeams = $collTeams;
                $this->collTeamsPartial = false;
            }
        }

        return $this->collTeams;
    }

    /**
     * Sets a collection of ChildTeams objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $teams A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRounds The current object (for fluent API support)
     */
    public function setTeams(Collection $teams, ConnectionInterface $con = null)
    {
        /** @var ChildTeams[] $teamsToDelete */
        $teamsToDelete = $this->getTeams(new Criteria(), $con)->diff($teams);


        $this->teamsScheduledForDeletion = $teamsToDelete;

        foreach ($teamsToDelete as $teamRemoved) {
            $teamRemoved->setRounds(null);
        }

        $this->collTeams = null;
        foreach ($teams as $team) {
            $this->addTeam($team);
        }

        $this->collTeams = $teams;
        $this->collTeamsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Teams objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Teams objects.
     * @throws PropelException
     */
    public function countTeams(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTeamsPartial && !$this->isNew();
        if (null === $this->collTeams || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTeams) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTeams());
            }

            $query = ChildTeamsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRounds($this)
                ->count($con);
        }

        return count($this->collTeams);
    }

    /**
     * Method called to associate a ChildTeams object to this object
     * through the ChildTeams foreign key attribute.
     *
     * @param  ChildTeams $l ChildTeams
     * @return $this|\Rounds The current object (for fluent API support)
     */
    public function addTeam(ChildTeams $l)
    {
        if ($this->collTeams === null) {
            $this->initTeams();
            $this->collTeamsPartial = true;
        }

        if (!$this->collTeams->contains($l)) {
            $this->doAddTeam($l);

            if ($this->teamsScheduledForDeletion and $this->teamsScheduledForDeletion->contains($l)) {
                $this->teamsScheduledForDeletion->remove($this->teamsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTeams $team The ChildTeams object to add.
     */
    protected function doAddTeam(ChildTeams $team)
    {
        $this->collTeams[]= $team;
        $team->setRounds($this);
    }

    /**
     * @param  ChildTeams $team The ChildTeams object to remove.
     * @return $this|ChildRounds The current object (for fluent API support)
     */
    public function removeTeam(ChildTeams $team)
    {
        if ($this->getTeams()->contains($team)) {
            $pos = $this->collTeams->search($team);
            $this->collTeams->remove($pos);
            if (null === $this->teamsScheduledForDeletion) {
                $this->teamsScheduledForDeletion = clone $this->collTeams;
                $this->teamsScheduledForDeletion->clear();
            }
            $this->teamsScheduledForDeletion[]= clone $team;
            $team->setRounds(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Rounds is new, it will return
     * an empty collection; or if this Rounds has previously
     * been saved, it will retrieve related Teams from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Rounds.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTeams[] List of ChildTeams objects
     */
    public function getTeamsJoinPlayers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTeamsQuery::create(null, $criteria);
        $query->joinWith('Players', $joinBehavior);

        return $this->getTeams($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aGametypes) {
            $this->aGametypes->removeRound($this);
        }
        $this->id = null;
        $this->winner = null;
        $this->red_score = null;
        $this->blue_score = null;
        $this->gametype_id = null;
        $this->nbplayers = null;
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
            if ($this->collTeams) {
                foreach ($this->collTeams as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTeams = null;
        $this->aGametypes = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RoundsTableMap::DEFAULT_STRING_FORMAT);
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
