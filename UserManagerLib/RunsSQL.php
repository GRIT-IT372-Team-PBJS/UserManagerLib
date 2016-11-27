<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 11/26/2016
 * Time: 3:19 PM
 */

require_once "Database.php";
require_once "HelperFunctions.php";

/**
 * Class Queryable
 * This class is used to eliminate the redundancy of query statements in the library.
 * Supports up to Six Clauses
 *
 * @author Peter L. Kim <peterlk.dev@gmail.com>
 * @author Benjamin Arnold <benji.arnold@gmail.com>
 */
class RunsSQL
{
    //setting up prepared statement placeholders to make my sql quires dynamic.
    const PREPARED_STATEMENT_1 = ":prepared_1";
    const PREPARED_STATEMENT_2 = ":prepared_2";
    const PREPARED_STATEMENT_3 = ":prepared_3";
    const PREPARED_STATEMENT_4 = ":prepared_4";
    const PREPARED_STATEMENT_5 = ":prepared_5";
    const PREPARED_STATEMENT_6 = ":prepared_6";


    /**
     * Executes SQL query that has no variable clauses
     * @param $sql
     * @return $result
     */
    protected static function runSQLWithNoClause($sql, $isReturnExpected)
    {
        if (HelperFunctions::isLoggedIn()) {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->execute();

            $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

            return self::queryResultAndOrCheckList($isThereNoDatabaseErrors, $isReturnExpected, $statement);

        }
    }

    /**
     * Executes SQL query that has one variable clause
     * @param $sql
     * @param $variableClause
     * @return $result
     */
    protected static function runSQLWithOneClause($sql, $variableClause, $isReturnExpected)
    {
        if (HelperFunctions::isLoggedIn()) {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $variableClause, PDO::PARAM_STR);
            $statement->execute();

            $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

            return self::queryResultAndOrCheckList($isThereNoDatabaseErrors, $isReturnExpected, $statement);
        }
    }

    /**
     * Executes SQL query that has two variable clauses
     * @param $sql
     * @param $firstVariableClause
     * @param $secondVariableClause
     * @return $result
     */
    protected static function runSQLWithTwoClauses($sql, $firstVariableClause, $secondVariableClause, $isReturnExpected)
    {
        if (HelperFunctions::isLoggedIn()) {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVariableClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVariableClause, PDO::PARAM_STR);
            $statement->execute();

            $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

            return self::queryResultAndOrCheckList($isThereNoDatabaseErrors, $isReturnExpected, $statement);
        }
    }

    protected static function runSQLWithThreeClauses($sql, $firstVarClause, $secondVarClause, $thirdVarClause, $isReturnExpected)
    {
        if (HelperFunctions::isLoggedIn()) {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_3", $thirdVarClause, PDO::PARAM_STR);

            $statement->execute();

            $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

            return self::queryResultAndOrCheckList($isThereNoDatabaseErrors, $isReturnExpected, $statement);
        }
    }


    protected static function runSQLWithFourClauses($sql, $firstVarClause, $secondVarClause, $thirdVarClause, $fourthVarClause, $isReturnExpected)
    {
        if (HelperFunctions::isLoggedIn()) {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_3", $thirdVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_4", $fourthVarClause, PDO::PARAM_STR);

            $statement->execute();

            $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

            return self::queryResultAndOrCheckList($isThereNoDatabaseErrors, $isReturnExpected, $statement);
        }
    }


    protected static function runSQLWithFiveClauses($sql, $firstVarClause, $secondVarClause, $thirdVarClause, $fourthVarClause, $fifthVarClause, $isReturnExpected)
    {
        if (HelperFunctions::isLoggedIn()) {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_3", $thirdVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_4", $fourthVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_5", $fifthVarClause, PDO::PARAM_STR);

            $statement->execute();

            $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

            return self::queryResultAndOrCheckList($isThereNoDatabaseErrors, $isReturnExpected, $statement);

        }
    }


    protected static function runSQLWithSixClauses($sql, $firstVarClause, $secondVarClause, $thirdVarClause, $fourthVarClause, $fifthVarClause, $sixthVarClause, $isReturnExpected)
    {
        if (HelperFunctions::isLoggedIn()) {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_3", $thirdVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_4", $fourthVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_5", $fifthVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_6", $sixthVarClause, PDO::PARAM_STR);

            $statement->execute();

            $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

            return self::queryResultAndOrCheckList($isThereNoDatabaseErrors, $isReturnExpected, $statement);

        }
    }

    protected static function runSQLGetRowCountForOneClause($sql, $firstVarClause)
    {
        if (HelperFunctions::isLoggedIn()) {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);
            $statement->execute();

            $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

            if ($isThereNoDatabaseErrors) {
                return $statement->fetchColumn();
            } else {
                return false;
            }
        }
    }

    protected static function runSQLGetRowCountForTwoClause($sql, $firstVarClause, $secondVarClause)
    {
        if (HelperFunctions::isLoggedIn()) {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVarClause, PDO::PARAM_STR);
            $statement->execute();

            $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

            if ($isThereNoDatabaseErrors) {
                return $statement->fetchColumn();
            } else {
                return false;
            }
        }
    }

    private static function queryResultAndOrCheckList($isThereNoDatabaseErrors, $isReturnExpected, $statement)
    {
        if ($isThereNoDatabaseErrors) {
            if ($isReturnExpected) {
                $result = $statement->fetch();
                return $result;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }


}