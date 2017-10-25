<?php die(); 
// Should you require our technical assistance with the error logs troubleshooting feel free to contact us through the
// personal HelpDesk at https://secure.x-cart.com/customer.php or email us on support@x-cart.com
//
// Technical support service can be purchased at http://www.x-cart.com/technical-support.html
?>
[24-Oct-2017 11:31:22] SQL error:
    Site        : http://localhost
    Remote IP   : ::1
    Logged as   : master@minka.com
    SQL query   : 
        SELECT DISTINCT p.categoryid
          FROM xcart_categories c
          INNER JOIN xcart_categories p
            ON p.lpos < c.lpos
           AND p.rpos > c.rpos
         WHERE c.categoryid IN (2, 41 42, 67, 62)
    Error code  : 1064
    Description : You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '42, 67, 62)' at line 6
Request URI: /provider/update_items.php
Backtrace:
D:\website\MK\include\func\func.db.php:754
D:\website\MK\include\func\func.db.php:625
D:\website\MK\include\func\func.db.php:1037
D:\website\MK\include\func\func.category.php:463
D:\website\MK\provider\fun_common.php:430
D:\website\MK\provider\update_items.php:569

-------------------------------------------------
[24-Oct-2017 14:15:03] SQL error:
    Site        : http://localhost
    Remote IP   : ::1
    Logged as   : master@minka.com
    SQL query   : 
        SELECT DISTINCT p.categoryid
          FROM xcart_categories c
          INNER JOIN xcart_categories p
            ON p.lpos < c.lpos
           AND p.rpos > c.rpos
         WHERE c.categoryid IN (2, 41 42, 67, 62)
    Error code  : 1064
    Description : You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '42, 67, 62)' at line 6
Request URI: /provider/update_items.php
Backtrace:
D:\website\MK\include\func\func.db.php:754
D:\website\MK\include\func\func.db.php:625
D:\website\MK\include\func\func.db.php:1037
D:\website\MK\include\func\func.category.php:463
D:\website\MK\provider\fun_common.php:430
D:\website\MK\provider\update_items.php:573

-------------------------------------------------
