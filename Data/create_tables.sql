CREATE TABLE IF NOT EXISTS 'timers' (
  'timer_id' int(10) unsigned NOT NULL AUTO_INCREMENT,
  'ClientIP' varchar(15) DEFAULT NULL,
  'ClientIPInstance' int(10) unsigned DEFAULT NULL,
  'ElapsedSeconds' int(10) unsigned DEFAULT NULL,
  'Start' int(10) unsigned DEFAULT NULL,
  'Stop' int(10) unsigned DEFAULT NULL,
  PRIMARY KEY ('timer_id')
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;