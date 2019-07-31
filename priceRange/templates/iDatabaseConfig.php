<?php
/*
 *  This is related on how to connect to a specific database
 */
interface iDatabaseConfig {
    /*
     *  Set and return the connection to the database
     */
    public function getConnection();
}