set global event_scheduler = on

CREATE or replace EVENT clear_sessions
ON SCHEDULE EVERY 1 MINUTE
STARTS current_timestamp
ON COMPLETION NOT PRESERVE
ENABLE
DO delete from sessions where start_date <= DATE_SUB(current_timestamp,INTERVAL 20 minute);