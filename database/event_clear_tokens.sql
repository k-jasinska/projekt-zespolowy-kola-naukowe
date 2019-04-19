CREATE EVENT clear_tokens
ON SCHEDULE EVERY 1 DAY
STARTS current_timestamp
ON COMPLETION NOT PRESERVE
ENABLE
DO delete from authorization_tokens where expires <= current_timestamp