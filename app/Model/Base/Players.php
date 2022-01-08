<?php

namespace Base;

use \Bombs as ChildBombs;
use \BombsQuery as ChildBombsQuery;
use \Flags as ChildFlags;
use \FlagsQuery as ChildFlagsQuery;
use \Frags as ChildFrags;
use \FragsQuery as ChildFragsQuery;
use \Gamescores as ChildGamescores;
use \GamescoresQuery as ChildGamescoresQuery;
use \Gametimes as ChildGametimes;
use \GametimesQuery as ChildGametimesQuery;
use \Hits as ChildHits;
use \HitsQuery as ChildHitsQuery;
use \Players as ChildPlayers;
use \PlayersQuery as ChildPlayersQuery;
use \Exception;
use \PDO;
use Map\BombsTableMap;
use Map\FlagsTableMap;
use Map\FragsTableMap;
use Map\GamescoresTableMap;
use Map\GametimesTableMap;
use Map\HitsTableMap;
use Map\PlayersTableMap;
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

/**
 * Base class that represents a row from the 'players' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Players implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PlayersTableMap';


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
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the altname field.
     *
     * @var        string
     */
    protected $altname;

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
    protected $collFraggerPlayers;
    protected $collFraggerPlayersPartial;

    /**
     * @var        ObjectCollection|ChildFrags[] Collection to store aggregation of ChildFrags objects.
     */
    protected $collFraggedPlayers;
    protected $collFraggedPlayersPartial;

    /**
     * @var        ObjectCollection|ChildGamescores[] Collection to store aggregation of ChildGamescores objects.
     */
    protected $collScoress;
    protected $collScoressPartial;

    /**
     * @var        ObjectCollection|ChildGametimes[] Collection to store aggregation of ChildGametimes objects.
     */
    protected $collGametimes;
    protected $collGametimesPartial;

    /**
     * @var        ObjectCollection|ChildHits[] Collection to store aggregation of ChildHits objects.
     */
    protected $collHitterPlayers;
    protected $collHitterPlayersPartial;

    /**
     * @var        ObjectCollection|ChildHits[] Collection to store aggregation of ChildHits objects.
     */
    protected $collHittedPlayers;
    protected $collHittedPlayersPartial;

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
    protected $fraggerPlayersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFrags[]
     */
    protected $fraggedPlayersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGamescores[]
     */
    protected $scoressScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGametimes[]
     */
    protected $gametimesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildHits[]
     */
    protected $hitterPlayersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildHits[]
     */
    protected $hittedPlayersScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Players object.
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
     * Compares this with another <code>Players</code> instance.  If
     * <code>obj</code> is an instance of <code>Players</code>, delegates to
     * <code>equals(Players)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Players The current object, for fluid interface
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [altname] column value.
     *
     * @return string
     */
    public function getAltname()
    {
        return $this->altname;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Players The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PlayersTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Players The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[PlayersTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [altname] column.
     *
     * @param string $v new value
     * @return $this|\Players The current object (for fluent API support)
     */
    public function setAltname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->altname !== $v) {
            $this->altname = $v;
            $this->modifiedColumns[PlayersTableMap::COL_ALTNAME] = true;
        }

        return $this;
    } // setAltname()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PlayersTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PlayersTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PlayersTableMap::translateFieldName('Altname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->altname = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = PlayersTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Players'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PlayersTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPlayersQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collBombs = null;

            $this->collFlags = null;

            $this->collFraggerPlayers = null;

            $this->collFraggedPlayers = null;

            $this->collScoress = null;

            $this->collGametimes = null;

            $this->collHitterPlayers = null;

            $this->collHittedPlayers = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Players::setDeleted()
     * @see Players::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlayersTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPlayersQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PlayersTableMap::DATABASE_NAME);
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
                PlayersTableMap::addInstanceToPool($this);
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

            if ($this->fraggerPlayersScheduledForDeletion !== null) {
                if (!$this->fraggerPlayersScheduledForDeletion->isEmpty()) {
                    \FragsQuery::create()
                        ->filterByPrimaryKeys($this->fraggerPlayersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->fraggerPlayersScheduledForDeletion = null;
                }
            }

            if ($this->collFraggerPlayers !== null) {
                foreach ($this->collFraggerPlayers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->fraggedPlayersScheduledForDeletion !== null) {
                if (!$this->fraggedPlayersScheduledForDeletion->isEmpty()) {
                    \FragsQuery::create()
                        ->filterByPrimaryKeys($this->fraggedPlayersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->fraggedPlayersScheduledForDeletion = null;
                }
            }

            if ($this->collFraggedPlayers !== null) {
                foreach ($this->collFraggedPlayers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->scoressScheduledForDeletion !== null) {
                if (!$this->scoressScheduledForDeletion->isEmpty()) {
                    \GamescoresQuery::create()
                        ->filterByPrimaryKeys($this->scoressScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->scoressScheduledForDeletion = null;
                }
            }

            if ($this->collScoress !== null) {
                foreach ($this->collScoress as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->gametimesScheduledForDeletion !== null) {
                if (!$this->gametimesScheduledForDeletion->isEmpty()) {
                    \GametimesQuery::create()
                        ->filterByPrimaryKeys($this->gametimesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->gametimesScheduledForDeletion = null;
                }
            }

            if ($this->collGametimes !== null) {
                foreach ($this->collGametimes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->hitterPlayersScheduledForDeletion !== null) {
                if (!$this->hitterPlayersScheduledForDeletion->isEmpty()) {
                    \HitsQuery::create()
                        ->filterByPrimaryKeys($this->hitterPlayersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->hitterPlayersScheduledForDeletion = null;
                }
            }

            if ($this->collHitterPlayers !== null) {
                foreach ($this->collHitterPlayers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->hittedPlayersScheduledForDeletion !== null) {
                if (!$this->hittedPlayersScheduledForDeletion->isEmpty()) {
                    \HitsQuery::create()
                        ->filterByPrimaryKeys($this->hittedPlayersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->hittedPlayersScheduledForDeletion = null;
                }
            }

            if ($this->collHittedPlayers !== null) {
                foreach ($this->collHittedPlayers as $referrerFK) {
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

        $this->modifiedColumns[PlayersTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PlayersTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PlayersTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PlayersTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(PlayersTableMap::COL_ALTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'altname';
        }

        $sql = sprintf(
            'INSERT INTO players (%s) VALUES (%s)',
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
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'altname':
                        $stmt->bindValue($identifier, $this->altname, PDO::PARAM_STR);
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
        $pos = PlayersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getAltname();
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

        if (isset($alreadyDumpedObjects['Players'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Players'][$this->hashCode()] = true;
        $keys = PlayersTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getAltname(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collFraggerPlayers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fragss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fragss';
                        break;
                    default:
                        $key = 'FraggerPlayers';
                }

                $result[$key] = $this->collFraggerPlayers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFraggedPlayers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fragss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fragss';
                        break;
                    default:
                        $key = 'FraggedPlayers';
                }

                $result[$key] = $this->collFraggedPlayers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collScoress) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gamescoress';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gamescoress';
                        break;
                    default:
                        $key = 'Scoress';
                }

                $result[$key] = $this->collScoress->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGametimes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gametimess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gametimess';
                        break;
                    default:
                        $key = 'Gametimes';
                }

                $result[$key] = $this->collGametimes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collHitterPlayers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'hitss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'hitss';
                        break;
                    default:
                        $key = 'HitterPlayers';
                }

                $result[$key] = $this->collHitterPlayers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collHittedPlayers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'hitss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'hitss';
                        break;
                    default:
                        $key = 'HittedPlayers';
                }

                $result[$key] = $this->collHittedPlayers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Players
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PlayersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Players
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setAltname($value);
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
        $keys = PlayersTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setAltname($arr[$keys[2]]);
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
     * @return $this|\Players The current object, for fluid interface
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
        $criteria = new Criteria(PlayersTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PlayersTableMap::COL_ID)) {
            $criteria->add(PlayersTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PlayersTableMap::COL_NAME)) {
            $criteria->add(PlayersTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(PlayersTableMap::COL_ALTNAME)) {
            $criteria->add(PlayersTableMap::COL_ALTNAME, $this->altname);
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
        $criteria = ChildPlayersQuery::create();
        $criteria->add(PlayersTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Players (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setAltname($this->getAltname());

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

            foreach ($this->getFraggerPlayers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFraggerPlayer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFraggedPlayers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFraggedPlayer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getScoress() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addScores($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGametimes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGametime($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getHitterPlayers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addHitterPlayer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getHittedPlayers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addHittedPlayer($relObj->copy($deepCopy));
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
     * @return \Players Clone of current object.
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
        if ('FraggerPlayer' == $relationName) {
            $this->initFraggerPlayers();
            return;
        }
        if ('FraggedPlayer' == $relationName) {
            $this->initFraggedPlayers();
            return;
        }
        if ('Scores' == $relationName) {
            $this->initScoress();
            return;
        }
        if ('Gametime' == $relationName) {
            $this->initGametimes();
            return;
        }
        if ('HitterPlayer' == $relationName) {
            $this->initHitterPlayers();
            return;
        }
        if ('HittedPlayer' == $relationName) {
            $this->initHittedPlayers();
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
     * If this ChildPlayers is new, it will return
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
                    ->filterByPlayers($this)
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
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function setBombs(Collection $bombs, ConnectionInterface $con = null)
    {
        /** @var ChildBombs[] $bombsToDelete */
        $bombsToDelete = $this->getBombs(new Criteria(), $con)->diff($bombs);


        $this->bombsScheduledForDeletion = $bombsToDelete;

        foreach ($bombsToDelete as $bombRemoved) {
            $bombRemoved->setPlayers(null);
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
                ->filterByPlayers($this)
                ->count($con);
        }

        return count($this->collBombs);
    }

    /**
     * Method called to associate a ChildBombs object to this object
     * through the ChildBombs foreign key attribute.
     *
     * @param  ChildBombs $l ChildBombs
     * @return $this|\Players The current object (for fluent API support)
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
        $bomb->setPlayers($this);
    }

    /**
     * @param  ChildBombs $bomb The ChildBombs object to remove.
     * @return $this|ChildPlayers The current object (for fluent API support)
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
            $bomb->setPlayers(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Players is new, it will return
     * an empty collection; or if this Players has previously
     * been saved, it will retrieve related Bombs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Players.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBombs[] List of ChildBombs objects
     */
    public function getBombsJoinRounds(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBombsQuery::create(null, $criteria);
        $query->joinWith('Rounds', $joinBehavior);

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
     * If this ChildPlayers is new, it will return
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
                    ->filterByPlayers($this)
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
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function setFlags(Collection $flags, ConnectionInterface $con = null)
    {
        /** @var ChildFlags[] $flagsToDelete */
        $flagsToDelete = $this->getFlags(new Criteria(), $con)->diff($flags);


        $this->flagsScheduledForDeletion = $flagsToDelete;

        foreach ($flagsToDelete as $flagRemoved) {
            $flagRemoved->setPlayers(null);
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
                ->filterByPlayers($this)
                ->count($con);
        }

        return count($this->collFlags);
    }

    /**
     * Method called to associate a ChildFlags object to this object
     * through the ChildFlags foreign key attribute.
     *
     * @param  ChildFlags $l ChildFlags
     * @return $this|\Players The current object (for fluent API support)
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
        $flag->setPlayers($this);
    }

    /**
     * @param  ChildFlags $flag The ChildFlags object to remove.
     * @return $this|ChildPlayers The current object (for fluent API support)
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
            $flag->setPlayers(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Players is new, it will return
     * an empty collection; or if this Players has previously
     * been saved, it will retrieve related Flags from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Players.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFlags[] List of ChildFlags objects
     */
    public function getFlagsJoinRounds(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFlagsQuery::create(null, $criteria);
        $query->joinWith('Rounds', $joinBehavior);

        return $this->getFlags($query, $con);
    }

    /**
     * Clears out the collFraggerPlayers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFraggerPlayers()
     */
    public function clearFraggerPlayers()
    {
        $this->collFraggerPlayers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFraggerPlayers collection loaded partially.
     */
    public function resetPartialFraggerPlayers($v = true)
    {
        $this->collFraggerPlayersPartial = $v;
    }

    /**
     * Initializes the collFraggerPlayers collection.
     *
     * By default this just sets the collFraggerPlayers collection to an empty array (like clearcollFraggerPlayers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFraggerPlayers($overrideExisting = true)
    {
        if (null !== $this->collFraggerPlayers && !$overrideExisting) {
            return;
        }

        $collectionClassName = FragsTableMap::getTableMap()->getCollectionClassName();

        $this->collFraggerPlayers = new $collectionClassName;
        $this->collFraggerPlayers->setModel('\Frags');
    }

    /**
     * Gets an array of ChildFrags objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFrags[] List of ChildFrags objects
     * @throws PropelException
     */
    public function getFraggerPlayers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFraggerPlayersPartial && !$this->isNew();
        if (null === $this->collFraggerPlayers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFraggerPlayers) {
                // return empty collection
                $this->initFraggerPlayers();
            } else {
                $collFraggerPlayers = ChildFragsQuery::create(null, $criteria)
                    ->filterByFragger($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFraggerPlayersPartial && count($collFraggerPlayers)) {
                        $this->initFraggerPlayers(false);

                        foreach ($collFraggerPlayers as $obj) {
                            if (false == $this->collFraggerPlayers->contains($obj)) {
                                $this->collFraggerPlayers->append($obj);
                            }
                        }

                        $this->collFraggerPlayersPartial = true;
                    }

                    return $collFraggerPlayers;
                }

                if ($partial && $this->collFraggerPlayers) {
                    foreach ($this->collFraggerPlayers as $obj) {
                        if ($obj->isNew()) {
                            $collFraggerPlayers[] = $obj;
                        }
                    }
                }

                $this->collFraggerPlayers = $collFraggerPlayers;
                $this->collFraggerPlayersPartial = false;
            }
        }

        return $this->collFraggerPlayers;
    }

    /**
     * Sets a collection of ChildFrags objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $fraggerPlayers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function setFraggerPlayers(Collection $fraggerPlayers, ConnectionInterface $con = null)
    {
        /** @var ChildFrags[] $fraggerPlayersToDelete */
        $fraggerPlayersToDelete = $this->getFraggerPlayers(new Criteria(), $con)->diff($fraggerPlayers);


        $this->fraggerPlayersScheduledForDeletion = $fraggerPlayersToDelete;

        foreach ($fraggerPlayersToDelete as $fraggerPlayerRemoved) {
            $fraggerPlayerRemoved->setFragger(null);
        }

        $this->collFraggerPlayers = null;
        foreach ($fraggerPlayers as $fraggerPlayer) {
            $this->addFraggerPlayer($fraggerPlayer);
        }

        $this->collFraggerPlayers = $fraggerPlayers;
        $this->collFraggerPlayersPartial = false;

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
    public function countFraggerPlayers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFraggerPlayersPartial && !$this->isNew();
        if (null === $this->collFraggerPlayers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFraggerPlayers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFraggerPlayers());
            }

            $query = ChildFragsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFragger($this)
                ->count($con);
        }

        return count($this->collFraggerPlayers);
    }

    /**
     * Method called to associate a ChildFrags object to this object
     * through the ChildFrags foreign key attribute.
     *
     * @param  ChildFrags $l ChildFrags
     * @return $this|\Players The current object (for fluent API support)
     */
    public function addFraggerPlayer(ChildFrags $l)
    {
        if ($this->collFraggerPlayers === null) {
            $this->initFraggerPlayers();
            $this->collFraggerPlayersPartial = true;
        }

        if (!$this->collFraggerPlayers->contains($l)) {
            $this->doAddFraggerPlayer($l);

            if ($this->fraggerPlayersScheduledForDeletion and $this->fraggerPlayersScheduledForDeletion->contains($l)) {
                $this->fraggerPlayersScheduledForDeletion->remove($this->fraggerPlayersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildFrags $fraggerPlayer The ChildFrags object to add.
     */
    protected function doAddFraggerPlayer(ChildFrags $fraggerPlayer)
    {
        $this->collFraggerPlayers[]= $fraggerPlayer;
        $fraggerPlayer->setFragger($this);
    }

    /**
     * @param  ChildFrags $fraggerPlayer The ChildFrags object to remove.
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function removeFraggerPlayer(ChildFrags $fraggerPlayer)
    {
        if ($this->getFraggerPlayers()->contains($fraggerPlayer)) {
            $pos = $this->collFraggerPlayers->search($fraggerPlayer);
            $this->collFraggerPlayers->remove($pos);
            if (null === $this->fraggerPlayersScheduledForDeletion) {
                $this->fraggerPlayersScheduledForDeletion = clone $this->collFraggerPlayers;
                $this->fraggerPlayersScheduledForDeletion->clear();
            }
            $this->fraggerPlayersScheduledForDeletion[]= clone $fraggerPlayer;
            $fraggerPlayer->setFragger(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Players is new, it will return
     * an empty collection; or if this Players has previously
     * been saved, it will retrieve related FraggerPlayers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Players.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFrags[] List of ChildFrags objects
     */
    public function getFraggerPlayersJoinWeapons(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFragsQuery::create(null, $criteria);
        $query->joinWith('Weapons', $joinBehavior);

        return $this->getFraggerPlayers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Players is new, it will return
     * an empty collection; or if this Players has previously
     * been saved, it will retrieve related FraggerPlayers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Players.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFrags[] List of ChildFrags objects
     */
    public function getFraggerPlayersJoinRounds(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFragsQuery::create(null, $criteria);
        $query->joinWith('Rounds', $joinBehavior);

        return $this->getFraggerPlayers($query, $con);
    }

    /**
     * Clears out the collFraggedPlayers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFraggedPlayers()
     */
    public function clearFraggedPlayers()
    {
        $this->collFraggedPlayers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFraggedPlayers collection loaded partially.
     */
    public function resetPartialFraggedPlayers($v = true)
    {
        $this->collFraggedPlayersPartial = $v;
    }

    /**
     * Initializes the collFraggedPlayers collection.
     *
     * By default this just sets the collFraggedPlayers collection to an empty array (like clearcollFraggedPlayers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFraggedPlayers($overrideExisting = true)
    {
        if (null !== $this->collFraggedPlayers && !$overrideExisting) {
            return;
        }

        $collectionClassName = FragsTableMap::getTableMap()->getCollectionClassName();

        $this->collFraggedPlayers = new $collectionClassName;
        $this->collFraggedPlayers->setModel('\Frags');
    }

    /**
     * Gets an array of ChildFrags objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFrags[] List of ChildFrags objects
     * @throws PropelException
     */
    public function getFraggedPlayers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFraggedPlayersPartial && !$this->isNew();
        if (null === $this->collFraggedPlayers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFraggedPlayers) {
                // return empty collection
                $this->initFraggedPlayers();
            } else {
                $collFraggedPlayers = ChildFragsQuery::create(null, $criteria)
                    ->filterByFragged($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFraggedPlayersPartial && count($collFraggedPlayers)) {
                        $this->initFraggedPlayers(false);

                        foreach ($collFraggedPlayers as $obj) {
                            if (false == $this->collFraggedPlayers->contains($obj)) {
                                $this->collFraggedPlayers->append($obj);
                            }
                        }

                        $this->collFraggedPlayersPartial = true;
                    }

                    return $collFraggedPlayers;
                }

                if ($partial && $this->collFraggedPlayers) {
                    foreach ($this->collFraggedPlayers as $obj) {
                        if ($obj->isNew()) {
                            $collFraggedPlayers[] = $obj;
                        }
                    }
                }

                $this->collFraggedPlayers = $collFraggedPlayers;
                $this->collFraggedPlayersPartial = false;
            }
        }

        return $this->collFraggedPlayers;
    }

    /**
     * Sets a collection of ChildFrags objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $fraggedPlayers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function setFraggedPlayers(Collection $fraggedPlayers, ConnectionInterface $con = null)
    {
        /** @var ChildFrags[] $fraggedPlayersToDelete */
        $fraggedPlayersToDelete = $this->getFraggedPlayers(new Criteria(), $con)->diff($fraggedPlayers);


        $this->fraggedPlayersScheduledForDeletion = $fraggedPlayersToDelete;

        foreach ($fraggedPlayersToDelete as $fraggedPlayerRemoved) {
            $fraggedPlayerRemoved->setFragged(null);
        }

        $this->collFraggedPlayers = null;
        foreach ($fraggedPlayers as $fraggedPlayer) {
            $this->addFraggedPlayer($fraggedPlayer);
        }

        $this->collFraggedPlayers = $fraggedPlayers;
        $this->collFraggedPlayersPartial = false;

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
    public function countFraggedPlayers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFraggedPlayersPartial && !$this->isNew();
        if (null === $this->collFraggedPlayers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFraggedPlayers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFraggedPlayers());
            }

            $query = ChildFragsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFragged($this)
                ->count($con);
        }

        return count($this->collFraggedPlayers);
    }

    /**
     * Method called to associate a ChildFrags object to this object
     * through the ChildFrags foreign key attribute.
     *
     * @param  ChildFrags $l ChildFrags
     * @return $this|\Players The current object (for fluent API support)
     */
    public function addFraggedPlayer(ChildFrags $l)
    {
        if ($this->collFraggedPlayers === null) {
            $this->initFraggedPlayers();
            $this->collFraggedPlayersPartial = true;
        }

        if (!$this->collFraggedPlayers->contains($l)) {
            $this->doAddFraggedPlayer($l);

            if ($this->fraggedPlayersScheduledForDeletion and $this->fraggedPlayersScheduledForDeletion->contains($l)) {
                $this->fraggedPlayersScheduledForDeletion->remove($this->fraggedPlayersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildFrags $fraggedPlayer The ChildFrags object to add.
     */
    protected function doAddFraggedPlayer(ChildFrags $fraggedPlayer)
    {
        $this->collFraggedPlayers[]= $fraggedPlayer;
        $fraggedPlayer->setFragged($this);
    }

    /**
     * @param  ChildFrags $fraggedPlayer The ChildFrags object to remove.
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function removeFraggedPlayer(ChildFrags $fraggedPlayer)
    {
        if ($this->getFraggedPlayers()->contains($fraggedPlayer)) {
            $pos = $this->collFraggedPlayers->search($fraggedPlayer);
            $this->collFraggedPlayers->remove($pos);
            if (null === $this->fraggedPlayersScheduledForDeletion) {
                $this->fraggedPlayersScheduledForDeletion = clone $this->collFraggedPlayers;
                $this->fraggedPlayersScheduledForDeletion->clear();
            }
            $this->fraggedPlayersScheduledForDeletion[]= clone $fraggedPlayer;
            $fraggedPlayer->setFragged(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Players is new, it will return
     * an empty collection; or if this Players has previously
     * been saved, it will retrieve related FraggedPlayers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Players.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFrags[] List of ChildFrags objects
     */
    public function getFraggedPlayersJoinWeapons(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFragsQuery::create(null, $criteria);
        $query->joinWith('Weapons', $joinBehavior);

        return $this->getFraggedPlayers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Players is new, it will return
     * an empty collection; or if this Players has previously
     * been saved, it will retrieve related FraggedPlayers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Players.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFrags[] List of ChildFrags objects
     */
    public function getFraggedPlayersJoinRounds(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFragsQuery::create(null, $criteria);
        $query->joinWith('Rounds', $joinBehavior);

        return $this->getFraggedPlayers($query, $con);
    }

    /**
     * Clears out the collScoress collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addScoress()
     */
    public function clearScoress()
    {
        $this->collScoress = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collScoress collection loaded partially.
     */
    public function resetPartialScoress($v = true)
    {
        $this->collScoressPartial = $v;
    }

    /**
     * Initializes the collScoress collection.
     *
     * By default this just sets the collScoress collection to an empty array (like clearcollScoress());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initScoress($overrideExisting = true)
    {
        if (null !== $this->collScoress && !$overrideExisting) {
            return;
        }

        $collectionClassName = GamescoresTableMap::getTableMap()->getCollectionClassName();

        $this->collScoress = new $collectionClassName;
        $this->collScoress->setModel('\Gamescores');
    }

    /**
     * Gets an array of ChildGamescores objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGamescores[] List of ChildGamescores objects
     * @throws PropelException
     */
    public function getScoress(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collScoressPartial && !$this->isNew();
        if (null === $this->collScoress || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collScoress) {
                // return empty collection
                $this->initScoress();
            } else {
                $collScoress = ChildGamescoresQuery::create(null, $criteria)
                    ->filterByPlayers($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collScoressPartial && count($collScoress)) {
                        $this->initScoress(false);

                        foreach ($collScoress as $obj) {
                            if (false == $this->collScoress->contains($obj)) {
                                $this->collScoress->append($obj);
                            }
                        }

                        $this->collScoressPartial = true;
                    }

                    return $collScoress;
                }

                if ($partial && $this->collScoress) {
                    foreach ($this->collScoress as $obj) {
                        if ($obj->isNew()) {
                            $collScoress[] = $obj;
                        }
                    }
                }

                $this->collScoress = $collScoress;
                $this->collScoressPartial = false;
            }
        }

        return $this->collScoress;
    }

    /**
     * Sets a collection of ChildGamescores objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $scoress A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function setScoress(Collection $scoress, ConnectionInterface $con = null)
    {
        /** @var ChildGamescores[] $scoressToDelete */
        $scoressToDelete = $this->getScoress(new Criteria(), $con)->diff($scoress);


        $this->scoressScheduledForDeletion = $scoressToDelete;

        foreach ($scoressToDelete as $scoresRemoved) {
            $scoresRemoved->setPlayers(null);
        }

        $this->collScoress = null;
        foreach ($scoress as $scores) {
            $this->addScores($scores);
        }

        $this->collScoress = $scoress;
        $this->collScoressPartial = false;

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
    public function countScoress(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collScoressPartial && !$this->isNew();
        if (null === $this->collScoress || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collScoress) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getScoress());
            }

            $query = ChildGamescoresQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlayers($this)
                ->count($con);
        }

        return count($this->collScoress);
    }

    /**
     * Method called to associate a ChildGamescores object to this object
     * through the ChildGamescores foreign key attribute.
     *
     * @param  ChildGamescores $l ChildGamescores
     * @return $this|\Players The current object (for fluent API support)
     */
    public function addScores(ChildGamescores $l)
    {
        if ($this->collScoress === null) {
            $this->initScoress();
            $this->collScoressPartial = true;
        }

        if (!$this->collScoress->contains($l)) {
            $this->doAddScores($l);

            if ($this->scoressScheduledForDeletion and $this->scoressScheduledForDeletion->contains($l)) {
                $this->scoressScheduledForDeletion->remove($this->scoressScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGamescores $scores The ChildGamescores object to add.
     */
    protected function doAddScores(ChildGamescores $scores)
    {
        $this->collScoress[]= $scores;
        $scores->setPlayers($this);
    }

    /**
     * @param  ChildGamescores $scores The ChildGamescores object to remove.
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function removeScores(ChildGamescores $scores)
    {
        if ($this->getScoress()->contains($scores)) {
            $pos = $this->collScoress->search($scores);
            $this->collScoress->remove($pos);
            if (null === $this->scoressScheduledForDeletion) {
                $this->scoressScheduledForDeletion = clone $this->collScoress;
                $this->scoressScheduledForDeletion->clear();
            }
            $this->scoressScheduledForDeletion[]= clone $scores;
            $scores->setPlayers(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Players is new, it will return
     * an empty collection; or if this Players has previously
     * been saved, it will retrieve related Scoress from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Players.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGamescores[] List of ChildGamescores objects
     */
    public function getScoressJoinGames(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGamescoresQuery::create(null, $criteria);
        $query->joinWith('Games', $joinBehavior);

        return $this->getScoress($query, $con);
    }

    /**
     * Clears out the collGametimes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGametimes()
     */
    public function clearGametimes()
    {
        $this->collGametimes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGametimes collection loaded partially.
     */
    public function resetPartialGametimes($v = true)
    {
        $this->collGametimesPartial = $v;
    }

    /**
     * Initializes the collGametimes collection.
     *
     * By default this just sets the collGametimes collection to an empty array (like clearcollGametimes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGametimes($overrideExisting = true)
    {
        if (null !== $this->collGametimes && !$overrideExisting) {
            return;
        }

        $collectionClassName = GametimesTableMap::getTableMap()->getCollectionClassName();

        $this->collGametimes = new $collectionClassName;
        $this->collGametimes->setModel('\Gametimes');
    }

    /**
     * Gets an array of ChildGametimes objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGametimes[] List of ChildGametimes objects
     * @throws PropelException
     */
    public function getGametimes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGametimesPartial && !$this->isNew();
        if (null === $this->collGametimes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGametimes) {
                // return empty collection
                $this->initGametimes();
            } else {
                $collGametimes = ChildGametimesQuery::create(null, $criteria)
                    ->filterByPlayers($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGametimesPartial && count($collGametimes)) {
                        $this->initGametimes(false);

                        foreach ($collGametimes as $obj) {
                            if (false == $this->collGametimes->contains($obj)) {
                                $this->collGametimes->append($obj);
                            }
                        }

                        $this->collGametimesPartial = true;
                    }

                    return $collGametimes;
                }

                if ($partial && $this->collGametimes) {
                    foreach ($this->collGametimes as $obj) {
                        if ($obj->isNew()) {
                            $collGametimes[] = $obj;
                        }
                    }
                }

                $this->collGametimes = $collGametimes;
                $this->collGametimesPartial = false;
            }
        }

        return $this->collGametimes;
    }

    /**
     * Sets a collection of ChildGametimes objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gametimes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function setGametimes(Collection $gametimes, ConnectionInterface $con = null)
    {
        /** @var ChildGametimes[] $gametimesToDelete */
        $gametimesToDelete = $this->getGametimes(new Criteria(), $con)->diff($gametimes);


        $this->gametimesScheduledForDeletion = $gametimesToDelete;

        foreach ($gametimesToDelete as $gametimeRemoved) {
            $gametimeRemoved->setPlayers(null);
        }

        $this->collGametimes = null;
        foreach ($gametimes as $gametime) {
            $this->addGametime($gametime);
        }

        $this->collGametimes = $gametimes;
        $this->collGametimesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Gametimes objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Gametimes objects.
     * @throws PropelException
     */
    public function countGametimes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGametimesPartial && !$this->isNew();
        if (null === $this->collGametimes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGametimes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGametimes());
            }

            $query = ChildGametimesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlayers($this)
                ->count($con);
        }

        return count($this->collGametimes);
    }

    /**
     * Method called to associate a ChildGametimes object to this object
     * through the ChildGametimes foreign key attribute.
     *
     * @param  ChildGametimes $l ChildGametimes
     * @return $this|\Players The current object (for fluent API support)
     */
    public function addGametime(ChildGametimes $l)
    {
        if ($this->collGametimes === null) {
            $this->initGametimes();
            $this->collGametimesPartial = true;
        }

        if (!$this->collGametimes->contains($l)) {
            $this->doAddGametime($l);

            if ($this->gametimesScheduledForDeletion and $this->gametimesScheduledForDeletion->contains($l)) {
                $this->gametimesScheduledForDeletion->remove($this->gametimesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGametimes $gametime The ChildGametimes object to add.
     */
    protected function doAddGametime(ChildGametimes $gametime)
    {
        $this->collGametimes[]= $gametime;
        $gametime->setPlayers($this);
    }

    /**
     * @param  ChildGametimes $gametime The ChildGametimes object to remove.
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function removeGametime(ChildGametimes $gametime)
    {
        if ($this->getGametimes()->contains($gametime)) {
            $pos = $this->collGametimes->search($gametime);
            $this->collGametimes->remove($pos);
            if (null === $this->gametimesScheduledForDeletion) {
                $this->gametimesScheduledForDeletion = clone $this->collGametimes;
                $this->gametimesScheduledForDeletion->clear();
            }
            $this->gametimesScheduledForDeletion[]= clone $gametime;
            $gametime->setPlayers(null);
        }

        return $this;
    }

    /**
     * Clears out the collHitterPlayers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addHitterPlayers()
     */
    public function clearHitterPlayers()
    {
        $this->collHitterPlayers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collHitterPlayers collection loaded partially.
     */
    public function resetPartialHitterPlayers($v = true)
    {
        $this->collHitterPlayersPartial = $v;
    }

    /**
     * Initializes the collHitterPlayers collection.
     *
     * By default this just sets the collHitterPlayers collection to an empty array (like clearcollHitterPlayers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initHitterPlayers($overrideExisting = true)
    {
        if (null !== $this->collHitterPlayers && !$overrideExisting) {
            return;
        }

        $collectionClassName = HitsTableMap::getTableMap()->getCollectionClassName();

        $this->collHitterPlayers = new $collectionClassName;
        $this->collHitterPlayers->setModel('\Hits');
    }

    /**
     * Gets an array of ChildHits objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildHits[] List of ChildHits objects
     * @throws PropelException
     */
    public function getHitterPlayers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collHitterPlayersPartial && !$this->isNew();
        if (null === $this->collHitterPlayers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collHitterPlayers) {
                // return empty collection
                $this->initHitterPlayers();
            } else {
                $collHitterPlayers = ChildHitsQuery::create(null, $criteria)
                    ->filterByHitter($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collHitterPlayersPartial && count($collHitterPlayers)) {
                        $this->initHitterPlayers(false);

                        foreach ($collHitterPlayers as $obj) {
                            if (false == $this->collHitterPlayers->contains($obj)) {
                                $this->collHitterPlayers->append($obj);
                            }
                        }

                        $this->collHitterPlayersPartial = true;
                    }

                    return $collHitterPlayers;
                }

                if ($partial && $this->collHitterPlayers) {
                    foreach ($this->collHitterPlayers as $obj) {
                        if ($obj->isNew()) {
                            $collHitterPlayers[] = $obj;
                        }
                    }
                }

                $this->collHitterPlayers = $collHitterPlayers;
                $this->collHitterPlayersPartial = false;
            }
        }

        return $this->collHitterPlayers;
    }

    /**
     * Sets a collection of ChildHits objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $hitterPlayers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function setHitterPlayers(Collection $hitterPlayers, ConnectionInterface $con = null)
    {
        /** @var ChildHits[] $hitterPlayersToDelete */
        $hitterPlayersToDelete = $this->getHitterPlayers(new Criteria(), $con)->diff($hitterPlayers);


        $this->hitterPlayersScheduledForDeletion = $hitterPlayersToDelete;

        foreach ($hitterPlayersToDelete as $hitterPlayerRemoved) {
            $hitterPlayerRemoved->setHitter(null);
        }

        $this->collHitterPlayers = null;
        foreach ($hitterPlayers as $hitterPlayer) {
            $this->addHitterPlayer($hitterPlayer);
        }

        $this->collHitterPlayers = $hitterPlayers;
        $this->collHitterPlayersPartial = false;

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
    public function countHitterPlayers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collHitterPlayersPartial && !$this->isNew();
        if (null === $this->collHitterPlayers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collHitterPlayers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getHitterPlayers());
            }

            $query = ChildHitsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByHitter($this)
                ->count($con);
        }

        return count($this->collHitterPlayers);
    }

    /**
     * Method called to associate a ChildHits object to this object
     * through the ChildHits foreign key attribute.
     *
     * @param  ChildHits $l ChildHits
     * @return $this|\Players The current object (for fluent API support)
     */
    public function addHitterPlayer(ChildHits $l)
    {
        if ($this->collHitterPlayers === null) {
            $this->initHitterPlayers();
            $this->collHitterPlayersPartial = true;
        }

        if (!$this->collHitterPlayers->contains($l)) {
            $this->doAddHitterPlayer($l);

            if ($this->hitterPlayersScheduledForDeletion and $this->hitterPlayersScheduledForDeletion->contains($l)) {
                $this->hitterPlayersScheduledForDeletion->remove($this->hitterPlayersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildHits $hitterPlayer The ChildHits object to add.
     */
    protected function doAddHitterPlayer(ChildHits $hitterPlayer)
    {
        $this->collHitterPlayers[]= $hitterPlayer;
        $hitterPlayer->setHitter($this);
    }

    /**
     * @param  ChildHits $hitterPlayer The ChildHits object to remove.
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function removeHitterPlayer(ChildHits $hitterPlayer)
    {
        if ($this->getHitterPlayers()->contains($hitterPlayer)) {
            $pos = $this->collHitterPlayers->search($hitterPlayer);
            $this->collHitterPlayers->remove($pos);
            if (null === $this->hitterPlayersScheduledForDeletion) {
                $this->hitterPlayersScheduledForDeletion = clone $this->collHitterPlayers;
                $this->hitterPlayersScheduledForDeletion->clear();
            }
            $this->hitterPlayersScheduledForDeletion[]= clone $hitterPlayer;
            $hitterPlayer->setHitter(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Players is new, it will return
     * an empty collection; or if this Players has previously
     * been saved, it will retrieve related HitterPlayers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Players.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildHits[] List of ChildHits objects
     */
    public function getHitterPlayersJoinBodyparts(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildHitsQuery::create(null, $criteria);
        $query->joinWith('Bodyparts', $joinBehavior);

        return $this->getHitterPlayers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Players is new, it will return
     * an empty collection; or if this Players has previously
     * been saved, it will retrieve related HitterPlayers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Players.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildHits[] List of ChildHits objects
     */
    public function getHitterPlayersJoinRounds(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildHitsQuery::create(null, $criteria);
        $query->joinWith('Rounds', $joinBehavior);

        return $this->getHitterPlayers($query, $con);
    }

    /**
     * Clears out the collHittedPlayers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addHittedPlayers()
     */
    public function clearHittedPlayers()
    {
        $this->collHittedPlayers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collHittedPlayers collection loaded partially.
     */
    public function resetPartialHittedPlayers($v = true)
    {
        $this->collHittedPlayersPartial = $v;
    }

    /**
     * Initializes the collHittedPlayers collection.
     *
     * By default this just sets the collHittedPlayers collection to an empty array (like clearcollHittedPlayers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initHittedPlayers($overrideExisting = true)
    {
        if (null !== $this->collHittedPlayers && !$overrideExisting) {
            return;
        }

        $collectionClassName = HitsTableMap::getTableMap()->getCollectionClassName();

        $this->collHittedPlayers = new $collectionClassName;
        $this->collHittedPlayers->setModel('\Hits');
    }

    /**
     * Gets an array of ChildHits objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildHits[] List of ChildHits objects
     * @throws PropelException
     */
    public function getHittedPlayers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collHittedPlayersPartial && !$this->isNew();
        if (null === $this->collHittedPlayers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collHittedPlayers) {
                // return empty collection
                $this->initHittedPlayers();
            } else {
                $collHittedPlayers = ChildHitsQuery::create(null, $criteria)
                    ->filterByHitted($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collHittedPlayersPartial && count($collHittedPlayers)) {
                        $this->initHittedPlayers(false);

                        foreach ($collHittedPlayers as $obj) {
                            if (false == $this->collHittedPlayers->contains($obj)) {
                                $this->collHittedPlayers->append($obj);
                            }
                        }

                        $this->collHittedPlayersPartial = true;
                    }

                    return $collHittedPlayers;
                }

                if ($partial && $this->collHittedPlayers) {
                    foreach ($this->collHittedPlayers as $obj) {
                        if ($obj->isNew()) {
                            $collHittedPlayers[] = $obj;
                        }
                    }
                }

                $this->collHittedPlayers = $collHittedPlayers;
                $this->collHittedPlayersPartial = false;
            }
        }

        return $this->collHittedPlayers;
    }

    /**
     * Sets a collection of ChildHits objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $hittedPlayers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function setHittedPlayers(Collection $hittedPlayers, ConnectionInterface $con = null)
    {
        /** @var ChildHits[] $hittedPlayersToDelete */
        $hittedPlayersToDelete = $this->getHittedPlayers(new Criteria(), $con)->diff($hittedPlayers);


        $this->hittedPlayersScheduledForDeletion = $hittedPlayersToDelete;

        foreach ($hittedPlayersToDelete as $hittedPlayerRemoved) {
            $hittedPlayerRemoved->setHitted(null);
        }

        $this->collHittedPlayers = null;
        foreach ($hittedPlayers as $hittedPlayer) {
            $this->addHittedPlayer($hittedPlayer);
        }

        $this->collHittedPlayers = $hittedPlayers;
        $this->collHittedPlayersPartial = false;

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
    public function countHittedPlayers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collHittedPlayersPartial && !$this->isNew();
        if (null === $this->collHittedPlayers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collHittedPlayers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getHittedPlayers());
            }

            $query = ChildHitsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByHitted($this)
                ->count($con);
        }

        return count($this->collHittedPlayers);
    }

    /**
     * Method called to associate a ChildHits object to this object
     * through the ChildHits foreign key attribute.
     *
     * @param  ChildHits $l ChildHits
     * @return $this|\Players The current object (for fluent API support)
     */
    public function addHittedPlayer(ChildHits $l)
    {
        if ($this->collHittedPlayers === null) {
            $this->initHittedPlayers();
            $this->collHittedPlayersPartial = true;
        }

        if (!$this->collHittedPlayers->contains($l)) {
            $this->doAddHittedPlayer($l);

            if ($this->hittedPlayersScheduledForDeletion and $this->hittedPlayersScheduledForDeletion->contains($l)) {
                $this->hittedPlayersScheduledForDeletion->remove($this->hittedPlayersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildHits $hittedPlayer The ChildHits object to add.
     */
    protected function doAddHittedPlayer(ChildHits $hittedPlayer)
    {
        $this->collHittedPlayers[]= $hittedPlayer;
        $hittedPlayer->setHitted($this);
    }

    /**
     * @param  ChildHits $hittedPlayer The ChildHits object to remove.
     * @return $this|ChildPlayers The current object (for fluent API support)
     */
    public function removeHittedPlayer(ChildHits $hittedPlayer)
    {
        if ($this->getHittedPlayers()->contains($hittedPlayer)) {
            $pos = $this->collHittedPlayers->search($hittedPlayer);
            $this->collHittedPlayers->remove($pos);
            if (null === $this->hittedPlayersScheduledForDeletion) {
                $this->hittedPlayersScheduledForDeletion = clone $this->collHittedPlayers;
                $this->hittedPlayersScheduledForDeletion->clear();
            }
            $this->hittedPlayersScheduledForDeletion[]= clone $hittedPlayer;
            $hittedPlayer->setHitted(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Players is new, it will return
     * an empty collection; or if this Players has previously
     * been saved, it will retrieve related HittedPlayers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Players.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildHits[] List of ChildHits objects
     */
    public function getHittedPlayersJoinBodyparts(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildHitsQuery::create(null, $criteria);
        $query->joinWith('Bodyparts', $joinBehavior);

        return $this->getHittedPlayers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Players is new, it will return
     * an empty collection; or if this Players has previously
     * been saved, it will retrieve related HittedPlayers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Players.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildHits[] List of ChildHits objects
     */
    public function getHittedPlayersJoinRounds(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildHitsQuery::create(null, $criteria);
        $query->joinWith('Rounds', $joinBehavior);

        return $this->getHittedPlayers($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->altname = null;
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
            if ($this->collFraggerPlayers) {
                foreach ($this->collFraggerPlayers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFraggedPlayers) {
                foreach ($this->collFraggedPlayers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collScoress) {
                foreach ($this->collScoress as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGametimes) {
                foreach ($this->collGametimes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collHitterPlayers) {
                foreach ($this->collHitterPlayers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collHittedPlayers) {
                foreach ($this->collHittedPlayers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBombs = null;
        $this->collFlags = null;
        $this->collFraggerPlayers = null;
        $this->collFraggedPlayers = null;
        $this->collScoress = null;
        $this->collGametimes = null;
        $this->collHitterPlayers = null;
        $this->collHittedPlayers = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PlayersTableMap::DEFAULT_STRING_FORMAT);
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
