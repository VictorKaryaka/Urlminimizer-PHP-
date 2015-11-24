<?php

namespace Application;

use PDO;

/**
 * DatabaseManager to database
 */
class DatabaseManager
{
    private $connection;

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * DatabaseManager constructor.
     */
    public function __construct($path_to_config = '../../config.ini')
    {
        $config = parse_ini_file($path_to_config) or die('File config.ini not found');

        $dsn = 'mysql' . ':host=' . $config['db_host'] . ';dbname=' . $config['db_name'];
        try {
            $this->connection = new PDO($dsn, $config['db_user'], $config['db_pass']);
        } catch (PDOException $ex) {
            echo('MySQL connection error: ' . $ex->getMessage());
        }
    }

    /**
     * @param $hash
     * @return bool
     *
     * The function check the URL hash in database
     */
    public function isHasHash($hash, $table_name = 'storage_links')
    {
        $sql = 'SELECT link_hash FROM ' . "$table_name" . ' WHERE link_hash = ' . "'$hash'" . ';';
        $state = $this->connection->query($sql);
        $row = $state->fetch(PDO::FETCH_LAZY);

        return (is_bool($row)) ? false : true;
    }

    /**
     * @param $hash
     * @param $link
     *
     * The function add new link to database
     */
    public function addLink($hash, $is_limited, $link, $table_name = 'storage_links')
    {
        $sql = 'INSERT INTO ' . "$table_name" . ' (link_hash, is_limited, link_url) VALUES (?,?,?);';
        $statement = $this->connection->prepare($sql);
        $statement->execute(array($hash, $is_limited, $link));
    }

    /**
     * @param $hash
     * @return mixed
     *
     * The function returns url by hash
     */
    public function getURl($hash, $table_name = 'storage_links')
    {
        $sql = 'SELECT link_url FROM ' . "$table_name" . ' WHERE link_hash = ' . "'$hash'" . ';';
        $state = $this->connection->query($sql);
        return $row = $state->fetch(PDO::FETCH_LAZY);
    }

    /**
     * @param int $limit_hours
     *
     * The function delete links in database with limited shelf life
     */
    public function deleteLimitedLinks($limit_hours = 1)
    {
        $limit_time = date('Y-m-d H:i:s', time() - $limit_hours * 60 * 60);

        $sql = 'SELECT link_id FROM storage_links WHERE is_limited = "1" AND creation_date < ' . "'$limit_time'" . ';';
        $state = $this->connection->query($sql);
        $rows = $state->fetchAll(PDO::FETCH_COLUMN);
        if (is_array($rows)) {
            foreach ($rows as $key => $value) {
                $sql = 'DELETE FROM storage_links WHERE link_id =' . "'$value'" . ';';
                $this->connection->query($sql);
            }
        }
    }

    /**
     * @param $user_agent
     * @param $redirect_link
     * @param string $table_name
     *
     * The function add new redirect link to database
     */
    public function addRedirectLink($user_agent, $redirect_link, $table_name = 'redirect_statistic')
    {
        $sql = 'INSERT INTO ' . "$table_name" . ' (user_agent, redirect_link) VALUES (?,?);';
        $statement = $this->connection->prepare($sql);
        $statement->execute(array($user_agent, $redirect_link));
    }

    /**
     * @param string $table_name
     * @return array
     *
     * The function return array of redirect links from database
     */
    public function getRedirectLinks($table_name = 'redirect_statistic')
    {
        $sql = 'SELECT redirect_date, user_agent, redirect_link FROM ' . "$table_name" . ';';
        $state = $this->connection->query($sql);
        $rows = $state->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
}