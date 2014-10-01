
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- UniversalAnalytics_transaction
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `UniversalAnalytics_transaction`;

CREATE TABLE `UniversalAnalytics_transaction`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `clientId` VARCHAR(255),
    `order_id` INTEGER,
    `used` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
