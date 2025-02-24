-- Procedure die den Kunden Sperren und Entsperren kann
CREATE OR REPLACE PROCEDURE Kunde_SperreAendern(
    p_KundenNr IN NUMBER
) AS
    p_Aktion NUMBER;
BEGIN
     -- Prüfen, ob der Kunde existiert
    BEGIN
        SELECT Sperre INTO p_Aktion FROM Kunde WHERE Nr = p_KundenNr;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            RAISE_APPLICATION_ERROR(-20002, 'Kunde nicht gefunden.');
    END;
    
    -- Status umkehren
    IF p_Aktion = 1 THEN
        UPDATE Kunde SET Sperre = 0 WHERE Nr = p_KundenNr;
    ELSIF p_Aktion = 0 THEN
        UPDATE Kunde SET Sperre = 1 WHERE Nr = p_KundenNr;
    ELSE
        RAISE_APPLICATION_ERROR(-20001, 'Ungültiger Statuswert.');
    END IF;

    COMMIT;
END Kunde_SperreAendern;


-- Aufrufen der Prozedur in den Klammern die Kunden Nr eingeben
-- Call Kunde_SperreAendern(...); -- 
