<?php

namespace GoogleUniversalAnalytics\Model\Base;

use \Exception;
use \PDO;
use GoogleUniversalAnalytics\Model\UniversalanalyticsTransaction as ChildUniversalanalyticsTransaction;
use GoogleUniversalAnalytics\Model\UniversalanalyticsTransactionQuery as ChildUniversalanalyticsTransactionQuery;
use GoogleUniversalAnalytics\Model\Map\UniversalanalyticsTransactionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'UniversalAnalytics_transaction' table.
 *
 *
 *
 * @method     ChildUniversalanalyticsTransactionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUniversalanalyticsTransactionQuery orderByClientid($order = Criteria::ASC) Order by the clientId column
 * @method     ChildUniversalanalyticsTransactionQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 *
 * @method     ChildUniversalanalyticsTransactionQuery groupById() Group by the id column
 * @method     ChildUniversalanalyticsTransactionQuery groupByClientid() Group by the clientId column
 * @method     ChildUniversalanalyticsTransactionQuery groupByOrderId() Group by the order_id column
 *
 * @method     ChildUniversalanalyticsTransactionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUniversalanalyticsTransactionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUniversalanalyticsTransactionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUniversalanalyticsTransaction findOne(ConnectionInterface $con = null) Return the first ChildUniversalanalyticsTransaction matching the query
 * @method     ChildUniversalanalyticsTransaction findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUniversalanalyticsTransaction matching the query, or a new ChildUniversalanalyticsTransaction object populated from the query conditions when no match is found
 *
 * @method     ChildUniversalanalyticsTransaction findOneById(int $id) Return the first ChildUniversalanalyticsTransaction filtered by the id column
 * @method     ChildUniversalanalyticsTransaction findOneByClientid(string $clientId) Return the first ChildUniversalanalyticsTransaction filtered by the clientId column
 * @method     ChildUniversalanalyticsTransaction findOneByOrderId(int $order_id) Return the first ChildUniversalanalyticsTransaction filtered by the order_id column
 *
 * @method     array findById(int $id) Return ChildUniversalanalyticsTransaction objects filtered by the id column
 * @method     array findByClientid(string $clientId) Return ChildUniversalanalyticsTransaction objects filtered by the clientId column
 * @method     array findByOrderId(int $order_id) Return ChildUniversalanalyticsTransaction objects filtered by the order_id column
 *
 */
abstract class UniversalanalyticsTransactionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \GoogleUniversalAnalytics\Model\Base\UniversalanalyticsTransactionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\GoogleUniversalAnalytics\\Model\\UniversalanalyticsTransaction', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUniversalanalyticsTransactionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUniversalanalyticsTransactionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \GoogleUniversalAnalytics\Model\UniversalanalyticsTransactionQuery) {
            return $criteria;
        }
        $query = new \GoogleUniversalAnalytics\Model\UniversalanalyticsTransactionQuery();
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
     * @return ChildUniversalanalyticsTransaction|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UniversalanalyticsTransactionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UniversalanalyticsTransactionTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildUniversalanalyticsTransaction A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CLIENTID, ORDER_ID FROM UniversalAnalytics_transaction WHERE ID = :p0';
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
            $obj = new ChildUniversalanalyticsTransaction();
            $obj->hydrate($row);
            UniversalanalyticsTransactionTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildUniversalanalyticsTransaction|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
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
    public function findPks($keys, $con = null)
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
     * @return ChildUniversalanalyticsTransactionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UniversalanalyticsTransactionTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildUniversalanalyticsTransactionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UniversalanalyticsTransactionTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildUniversalanalyticsTransactionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UniversalanalyticsTransactionTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UniversalanalyticsTransactionTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UniversalanalyticsTransactionTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the clientId column
     *
     * Example usage:
     * <code>
     * $query->filterByClientid('fooValue');   // WHERE clientId = 'fooValue'
     * $query->filterByClientid('%fooValue%'); // WHERE clientId LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clientid The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUniversalanalyticsTransactionQuery The current query, for fluid interface
     */
    public function filterByClientid($clientid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clientid)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clientid)) {
                $clientid = str_replace('*', '%', $clientid);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UniversalanalyticsTransactionTableMap::CLIENTID, $clientid, $comparison);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId(1234); // WHERE order_id = 1234
     * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByOrderId(array('min' => 12)); // WHERE order_id > 12
     * </code>
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUniversalanalyticsTransactionQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(UniversalanalyticsTransactionTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(UniversalanalyticsTransactionTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UniversalanalyticsTransactionTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUniversalanalyticsTransaction $universalanalyticsTransaction Object to remove from the list of results
     *
     * @return ChildUniversalanalyticsTransactionQuery The current query, for fluid interface
     */
    public function prune($universalanalyticsTransaction = null)
    {
        if ($universalanalyticsTransaction) {
            $this->addUsingAlias(UniversalanalyticsTransactionTableMap::ID, $universalanalyticsTransaction->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the UniversalAnalytics_transaction table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UniversalanalyticsTransactionTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UniversalanalyticsTransactionTableMap::clearInstancePool();
            UniversalanalyticsTransactionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildUniversalanalyticsTransaction or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildUniversalanalyticsTransaction object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UniversalanalyticsTransactionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UniversalanalyticsTransactionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        UniversalanalyticsTransactionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UniversalanalyticsTransactionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // UniversalanalyticsTransactionQuery
