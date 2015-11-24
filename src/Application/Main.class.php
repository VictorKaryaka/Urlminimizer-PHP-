<?php

namespace Application;

class Main
{
    private $query;

    /**
     * Main constructor.
     */
    public function __construct()
    {
        $this->query = new DatabaseManager();
    }

    /**
     * Checking the elapsed time for the removal temporary links in database
     */
    public function checkElapsedTime()
    {
        $limit_time = time() - $_SESSION['server_time'];
        if ($limit_time > 3600) {
            unset($_SESSION['server_time']);
            session_destroy();
            $this->query->deleteLimitedLinks();
        }
    }

    /**
     * @param $url
     * @param $is_limited
     *
     * The function for minimization URL
     */
    public function minimize($url, $is_limited, $table_name = 'storage_links')
    {
        //If current link not exist in database
        if (!$this->query->isHasHash($this->getHash($url), $table_name)) {
            //Check if user want minimize short link
            $hash = substr($url, strlen($url) - 8, 8);
            if (!$this->query->isHasHash($hash, $table_name)) {
                $this->query->addLink($this->getHash($url), $is_limited, $url, $table_name);
                $url_parse = parse_url($url);
                $short_url = $url_parse['scheme'] . '://' . $url_parse['host'] . '/' . $this->getHash($url);
                echo json_encode(array('link' => $short_url));
                return;
            }
        }
        echo json_encode(array('link' => $url, 'error' => 'URL was added!'));
    }

    /**
     * @param $url
     * @param $is_limited
     * @param $custom_link
     *
     * The function for minimization custom URL
     */
    public function minimizeCustomUrl($url, $is_limited, $custom_link, $table_name = 'storage_links')
    {
        if (!$this->query->isHasHash($custom_link, $table_name)) {
            $this->query->addLink($custom_link, $is_limited, $url, $table_name);
            echo json_encode(array('link' => $custom_link));
            return;
        }
        echo json_encode(array('link' => $custom_link, 'error' => 'URL was added!'));
    }

    /**
     * @param $url
     *
     * Redirect by a given URL
     */
    public function redirect($url, $table_name = 'storage_links')
    {
        $url_parce = parse_url($url);
        $hash = str_replace("/", "", $url_parce['path']);
        if ($this->query->isHasHash($hash, $table_name = 'storage_links')) {
            $link = $this->query->getURl($hash, $table_name = 'storage_links');
            $link_url = $link['link_url'];
            $this->query->addRedirectLink($_SERVER['HTTP_USER_AGENT'], $link_url, $table_name = 'storage_links');
            echo($link_url);
            return;
        }
        echo('Error : Link not found');
    }


    /**
     * The function return redirect statistic in JSON
     */
    public function getStatistic()
    {
        echo json_encode($this->query->getRedirectLinks());
    }


    /**
     * @param $url
     * @return string
     *
     * The function return hash of URL using 'crc32'
     */
    private function getHash($url)
    {
        return hash('crc32', $url);
    }
}