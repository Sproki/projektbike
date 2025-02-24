-- Prozedur die die Beurteile des Personals verändert
CREATE OR REPLACE PROCEDURE Beurteile_Personal (
    p_PersonalNr IN NUMBER,
    p_Beurteilung IN VARCHAR2
) AS
    v_Existiert NUMBER;
BEGIN
    -- Prüfen, ob das Personal existiert
    SELECT COUNT(*) INTO v_Existiert FROM Personal WHERE Persnr = p_PersonalNr;

    IF v_Existiert = 0 THEN
        RAISE_APPLICATION_ERROR(-20003, 'Personal nicht gefunden.');
    END IF;

    -- Prüfen, ob die Beurteilung zwischen '1' und '6' liegt
    IF NOT REGEXP_LIKE(p_Beurteilung, '^[1-6]$') THEN
        RAISE_APPLICATION_ERROR(-20004, 'Ungültige Beurteilung. Nur Werte zwischen 1 und 6 erlaubt.');
    END IF;

    -- Beurteilung aktualisieren
    UPDATE Personal
    SET Beurteilung = p_Beurteilung
    WHERE Persnr = p_PersonalNr;

    COMMIT;
END Beurteile_Personal;

--In den Klammer kommt erst die Personal Nr dann die Bewertung die nur zwichen 1 und 6 sein darf
-- Call Beurteile_Personal(1, 6);

