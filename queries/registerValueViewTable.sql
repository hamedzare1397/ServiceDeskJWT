ALTER
ALGORITHM = UNDEFINED
DEFINER=`root`@`localhost`
 SQL SECURITY DEFINER
 VIEW `registervalues`
 AS select `score`.`registers`.`state_id` AS `state_id`,
           `score`.`registers`.`coefficient_id` AS `coefficient_id`,
           `score`.`registers`.`value` * (select `cn`.`coefficient` from `score`.`coefficient_news` `cn` where `cn`.`coefficient_id` = `score`.`registers`.`coefficient_id` and `cn`.`news_id` = `score`.`registers`.`news_id`) AS `mvalue`,left(`score`.`registers`.`year_month`,4) AS `year`,right(`score`.`registers`.`year_month`,2) AS `month` ,
        (select nn.name from news nn where nn.id=`registers`.`news_id`) as name,
        `score`.`registers`.`value` as value
    from `score`.`registers`;
