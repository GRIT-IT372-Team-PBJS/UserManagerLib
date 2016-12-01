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
            $statement = Database::getDBConnection()->prepare($sql);

            return self::executeAndReturnResults($isReturnExpected, $statement);
    }

    /**
     * Executes SQL query that has one variable clause
     * @param $sql
     * @param $variableClause
     * @return $result
     */
    protected static function runSQLWithOneClause($sql, $variableClause, $isReturnExpected)
    {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $variableClause, PDO::PARAM_STR);

            return self::executeAndReturnResults($isReturnExpected, $statement);
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
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVariableClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVariableClause, PDO::PARAM_STR);

            return self::executeAndReturnResults($isReturnExpected, $statement);
    }

    protected static function runSQLWithThreeClauses($sql, $firstVarClause, $secondVarClause, $thirdVarClause, $isReturnExpected)
    {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_3", $thirdVarClause, PDO::PARAM_STR);

            return self::executeAndReturnResults($isReturnExpected, $statement);
    }


    protected static function runSQLWithFourClauses($sql, $firstVarClause, $secondVarClause, $thirdVarClause, $fourthVarClause, $isReturnExpected)
    {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_3", $thirdVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_4", $fourthVarClause, PDO::PARAM_STR);

            return self::executeAndReturnResults($isReturnExpected, $statement);
    }


    protected static function runSQLWithFiveClauses($sql, $firstVarClause, $secondVarClause, $thirdVarClause, $fourthVarClause, $fifthVarClause, $isReturnExpected)
    {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_3", $thirdVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_4", $fourthVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_5", $fifthVarClause, PDO::PARAM_STR);

            return self::executeAndReturnResults($isReturnExpected, $statement);
    }


    protected static function runSQLWithSixClauses($sql, $firstVarClause, $secondVarClause, $thirdVarClause, $fourthVarClause, $fifthVarClause, $sixthVarClause, $isReturnExpected)
    {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_3", $thirdVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_4", $fourthVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_5", $fifthVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_6", $sixthVarClause, PDO::PARAM_STR);

            return self::executeAndReturnResults( $isReturnExpected, $statement);
    }

    protected static function runSQLGetRowCountForOneClause($sql, $firstVarClause)
    {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);

            return self::executeAndReturnColumn($statement);
    }

    protected static function runSQLGetRowCountForTwoClause($sql, $firstVarClause, $secondVarClause)
    {
            $statement = Database::getDBConnection()->prepare($sql);
            $statement->bindParam(":prepared_1", $firstVarClause, PDO::PARAM_STR);
            $statement->bindParam(":prepared_2", $secondVarClause, PDO::PARAM_STR);

            return self::executeAndReturnColumn($statement);
    }

    private static function executeAndReturnColumn($statement){
        $statement->execute();

        $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);

        if ($isThereNoDatabaseErrors) {
            return $statement->fetchColumn();
        } else {
            return false;
        }
    }

    private static function executeAndReturnResults($isReturnExpected, $statement)
    {
        $statement->execute();

        $isThereNoDatabaseErrors = empty($statement->errorInfo()[2]);
        echo $statement->errorInfo()[2];
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