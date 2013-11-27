CREATE TABLE IF NOT EXISTS timers (
  timer_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  created  int(10) unsigned DEFAULT NULL,
  client_ip varchar(15) DEFAULT NULL,
  elapsed_seconds int(10) unsigned DEFAULT NULL,
  start int(10) unsigned DEFAULT NULL,
  stop int(10) unsigned DEFAULT NULL,
  last_updated int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (timer_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;