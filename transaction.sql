START TRANSACTION;

INSERT INTO specialty (id, name)
VALUES (10, 'Cardiologie');

UPDATE user
SET specialty_id = 10
WHERE id = 7;

COMMIT;

ROLLBACK;