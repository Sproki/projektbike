-- Trigger der �berpr�ft ob beim �ndern oder hinzuf�gen eines Mitarbeiter �ber 5000 Euro ist
CREATE OR REPLACE TRIGGER check_gehalt
BEFORE INSERT OR UPDATE ON Personal
FOR EACH ROW
BEGIN
    IF :NEW.gehalt > 5000 THEN
        RAISE_APPLICATION_ERROR(-20001, 'Fehler: Gehalt darf maximal 5000 Euro betragen!');
    END IF;
END;
/
