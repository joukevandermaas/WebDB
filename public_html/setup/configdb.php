<?php
require("../tools/connectdb.php");

function createTable($name, $columns, $keys = array()) {
    $query = "CREATE TABLE IF NOT EXISTS $name ( \n";
    
    foreach ($columns as $cname => $type) {
        $query .= "$cname $type";
        
        $query .= ",\n";
    }
    foreach ($keys as $keydef) {
        $query .= "$keydef,\n";
    }
    $query = rtrim($query, ",\n");
    return $query.")\nENGINE=INNODB";
}

$tables = array(
    "orgs" => array(
        array(
            "id"            => "TINYINT UNSIGNED NOT NULL AUTO_INCREMENT",
            "name"          => "VARCHAR(128)",
            "horgid"        => "VARCHAR(32)"
        ),
        array(
            "PRIMARY KEY(id)",
            "UNIQUE (horgid)"
        )
    ),
    "users" => array(
        array(
            "id"                => "INT UNSIGNED NOT NULL AUTO_INCREMENT",
            "loginname"         => "VARCHAR(32)",
            "loginservice"      => "TINYINT",
            "firstname"         => "VARCHAR(32)",
            "lastname"          => "VARCHAR(32)",
            "registertimestamp" => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
        ),
        array(
            "PRIMARY KEY(id)"
        )
    ),
    "programs" => array(
        array(
            "id"            => "SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT",
            "org_id"        => "TINYINT UNSIGNED NOT NULL",
            "hprogramid"    => "VARCHAR(32)",
            "croho"         => "MEDIUMINT UNSIGNED NULL",
            "name"          => "VARCHAR(128)",
            "summary"       => "TEXT",
            "level"         => "ENUM('1', '2', '3', '4')",
            "hodexurl"      => "TEXT"
        ),
        array(
            "PRIMARY KEY(id)",
            "INDEX (org_id)",
            "FOREIGN KEY (org_id) REFERENCES orgs(id)",
            "UNIQUE (org_id, hprogramid)"
        )
    ),
    "posts" => array(
        array(
            "id"            => "INT UNSIGNED NOT NULL AUTO_INCREMENT",
            "program_id"    => "SMALLINT UNSIGNED NOT NULL",
            "user_id"       => "INT UNSIGNED NOT NULL",
            "title"         => "VARCHAR(64)",
            "content"       => "TEXT",
            "timestamp"     => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
            "score"         => "SMALLINT DEFAULT 0",
            "comment_count" => "INT DEFAULT 0"
        ),
        array(
            "PRIMARY KEY(id)",
            "INDEX (program_id)",
            "INDEX (user_id)",
            "FOREIGN KEY (program_id) REFERENCES programs(id)",
            "FOREIGN KEY (user_id) REFERENCES users(id)"
        )
    ),
    "comments" => array(
        array(
            "id"            => "INT UNSIGNED NOT NULL AUTO_INCREMENT",
            "post_id"       => "INT UNSIGNED NOT NULL",
            "user_id"       => "INT UNSIGNED NOT NULL",
            "content"       => "VARCHAR(256)",
            "timestamp"     => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
        ),
        array(
            "PRIMARY KEY(id)",
            "INDEX(post_id)",
            "INDEX(user_id)",
            "FOREIGN KEY (post_id) REFERENCES posts(id)",
            "FOREIGN KEY (user_id) REFERENCES users(id)"
        )
    ),
    "votes" => array(
        array(
            "user_id"       => "INT UNSIGNED NOT NULL",
            "post_id"       => "INT UNSIGNED NOT NULL"
        ),
        array(
            "FOREIGN KEY (user_id) REFERENCES users(id)",
            "FOREIGN KEY (post_id) REFERENCES posts(id)",
            "UNIQUE(user_id, post_id)"
        )
    )
);


if (!isset($_GET["done"])) {
    foreach($tables as $name => $columns) {
        $query = createTable($name, $columns[0], $columns[1]);
        echo "$query\n\n";
        mysql_query($query, $dbcon);
    }

    header("Location: confighodex.php");

} else
{
    echo "All done!";
}
?>
