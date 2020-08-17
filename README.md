# tradeOgrePumpTracker

So I was having trouble sleeping at 4AM in the morning and decided to get up from my bed and write a simple tracker for Trade Ogre. The script tracks all the trading pairs on Trade Ogre and saves the total amount of basepair (BTC/LTC) on the order book. It could be used as an indicator for a pump since it will show the state of total buy orders. More buy orders placed, more likely a pump is coming.


You need a MYSQL table to use the script. This should do it;

    CREATE TABLE `buybook` (
    `id` int(64) NOT NULL,
    `checkDate` varchar(64) DEFAULT NULL,
    `tradePair` varchar(24) DEFAULT NULL,
    `totalBuy` varchar(64) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    
After setting up the database, adjust the $db variable on the two .php scripts. And run the script.php on the background. Since it already has while loop and sleep in it, all you have to do is to run the script from the console.

    php script.php
    
The script will track the prices. You can edit the end of script.php to adjust it for more or less frequent changes. Go to line 66 on script.php and change sleep to whatever seconds you want between checks.

PHP Curl has to be enabled to use this script.



    
