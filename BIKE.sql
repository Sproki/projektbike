-- Es werden eventuell noch existierende Tabellen geloescht
DROP TABLE Reservierung;
DROP TABLE Auftragsposten;
DROP TABLE Auftrag;
DROP TABLE Teilestruktur;
DROP TABLE Lager;
DROP TABLE Lieferung;
DROP TABLE Artikel;
DROP TABLE Personal;
DROP TABLE Kunde;
DROP TABLE Lieferant;
-- Anlegen der Tabellen:
CREATE TABLE Lieferant (
     Nr          INTEGER    Constraint PK_Lieferant PRIMARY KEY,
     Name        CHAR(30)   NOT NULL,
     Strasse     CHAR(30),
     PLZ         INTEGER,
     Ort         CHAR(25),
     Sperre      CHAR (1)        
);
CREATE TABLE Kunde (
     Nr          INTEGER    Constraint PK_Kunde PRIMARY KEY,
     Name        CHAR(30)   NOT NULL,
     Strasse     CHAR(30),
     PLZ         INTEGER,
     Ort         CHAR(20),
     Sperre      CHAR (1)        
);
CREATE TABLE Personal (
     Persnr      INTEGER    Constraint PK_Personal PRIMARY KEY,
     Name        CHAR(30)   NOT NULL,
     Strasse     CHAR(30),
     PLZ         INTEGER,
     Ort         CHAR(20),
     GebDatum    DATE       NOT NULL,
     Stand       CHAR(6),
     Vorgesetzt  INTEGER    Constraint FK_Personal_Personal REFERENCES Personal ON DELETE SET NULL,
     Gehalt      NUMERIC(8,2),
     Beurteilung CHAR(1),
     Aufgabe     CHAR(18)
);

CREATE TABLE Artikel (
     Anr         INTEGER    Constraint PK_Artikel PRIMARY KEY,
     Bezeichnung CHAR(35)   NOT NULL,
     Netto       NUMERIC(7,2),
     Steuer      NUMERIC(7,2),
     Preis       NUMERIC(7,2),
     Farbe       CHAR(10),
     Mass        CHAR(15),
     Einheit     CHAR(2)    NOT NULL,
     Typ         CHAR(1)    NOT NULL
);
CREATE TABLE Lager (
     Artnr       INTEGER    Constraint PK_Lager PRIMARY KEY,
     Lagerort    CHAR(6),
     Bestand     SMALLINT   NOT NULL,
     Mindbest    SMALLINT,
     Reserviert  SMALLINT,
     Bestellt    SMALLINT,
     Constraint FK_Lager_Artikel FOREIGN KEY (Artnr) REFERENCES Artikel ON DELETE CASCADE
);
CREATE TABLE Lieferung (
     Anr         INTEGER    Constraint FK_Lieferung_Artikel REFERENCES Artikel ON DELETE CASCADE,
     Liefnr      INTEGER    Constraint FK_Lieferant  REFERENCES Lieferant  ON DELETE CASCADE,
     Lieferzeit  SMALLINT,
     Nettopreis  NUMERIC(7,2),
     Bestellt    SMALLINT,
     Constraint PK_Lieferung PRIMARY KEY (Anr, Liefnr)
);
CREATE TABLE Teilestruktur (
     Artnr       INTEGER    Constraint FK_Artnr_Artikel REFERENCES Artikel ON DELETE CASCADE,
     Einzelteilnr INTEGER   Constraint FK_ETeil_Artikel REFERENCES Artikel,
     Anzahl      SMALLINT,
     Einheit     CHAR(2),
     Constraint PK_Teilestruktur PRIMARY KEY (Artnr, Einzelteilnr)  
);
CREATE TABLE Auftrag (
     AuftrNr     INTEGER    Constraint PK_Auftrag PRIMARY KEY,
     Datum       DATE,
     Kundnr      INTEGER    NOT NULL Constraint FK_Auftrag_Kunde REFERENCES Kunde,
     Persnr      INTEGER    Constraint FK_Auftrag_Personal REFERENCES Personal ON DELETE SET NULL
);
CREATE TABLE Auftragsposten (
     PosNr       INTEGER    Constraint PK_Auftragsposten PRIMARY KEY,
     AuftrNr     INTEGER    NOT NULL Constraint FK_Auftrag_Auftrag REFERENCES Auftrag ON DELETE CASCADE,
     Artnr       INTEGER    NOT NULL Constraint FK_Auftrag_Artikel REFERENCES Artikel,
     Anzahl      SMALLINT,
     Gesamtpreis NUMERIC(7,2),
     Constraint AK_Auftragsposten UNIQUE (AuftrNr, Artnr)
);
CREATE TABLE Reservierung (
     Posnr       INTEGER    Constraint FK_Teil_Auftrag REFERENCES Auftragsposten,
     Artnr       INTEGER    Constraint FK_Teil_Artikel REFERENCES Artikel,
     Anzahl      SMALLINT,
     Constraint PK_Reservierung PRIMARY KEY (Posnr, Artnr)
);
-- Jetzt werden die Tabellen mit Inhalt versorgt 
INSERT INTO Lieferant 
  VALUES ( 1, 'Firma Gerti Schmidtner', 'Dr. Gesslerstr. 59'       ,  93051, 'Regensburg ', '0' ); 
INSERT INTO Lieferant 
  VALUES ( 2, 'Rauch GmbH'            , 'Burgallee 23'             ,  90403, 'N�rnberg '  , '0' ); 
INSERT INTO Lieferant
  VALUES ( 3, 'Shimano GmbH'          , 'Rosengasse 122'           ,  51143, 'K�ln'       , '0' ); 
INSERT INTO Lieferant 
  VALUES ( 4, 'Suntour LTD'           , 'Meltonstreet 65'          ,   NULL, 'London'     , '0' ); 
INSERT INTO Lieferant 
  VALUES ( 5, 'MSM GmbH'              , 'St-Rotteneckstr. 13'      ,  93047, 'Regensburg' , '0' ); 
 
INSERT INTO Kunde 
  VALUES ( 1, 'Fahrrad Shop'          , 'Obere Regenstr. 4'        ,  93059, 'Regensburg' , '0' ); 
INSERT INTO Kunde 
  VALUES ( 2, 'Zweirad-Center Staller', 'Kirschweg 20'             ,  44267, 'Dortmund'   , '0' ); 
INSERT INTO Kunde 
  VALUES ( 3, 'Maier Ingrid'          , 'Universit�tsstr. 33'      ,  93055, 'Regensburg' , '1' ); 
INSERT INTO Kunde 
  VALUES ( 4, 'Rafa - Seger KG'       , 'Liebigstr. 10'            ,  10247, 'Berlin'     , '0' ); 
INSERT INTO Kunde
  VALUES ( 5, 'Biker Ecke'            , 'Lessingstr. 37'           ,  22087, 'Hamburg'    , '0' );
INSERT INTO Kunde 
  VALUES ( 6, 'Fahrr�der Hammerl'     , 'Schindlerplatz 7'         ,  81739, 'M�nchen'    , '0' ); 
 
INSERT INTO Personal 
  VALUES ( 1, 'Maria Forster'   , 'Ebertstr. 28'     , 93051, 'Regensburg', DATE '1979-07-05', 'verh', NULL, 4800.00 , '2' , 'Manager'    ); 
INSERT INTO Personal 
  VALUES ( 2, 'Anna Kraus'      , 'Kramgasse 5'      , 93047, 'Regensburg', DATE '1975-07-09', 'led' , 1   , 2300.00 , '3' , 'Vertreter'  ); 
INSERT INTO Personal 
  VALUES ( 4, 'Heinz Rolle'     , 'In der Au 5'      , 90455, 'N�rnberg'  , DATE '1957-10-12', 'led' , 1   , 3300.00 , '3' , 'Sekret�r'   ); 
INSERT INTO Personal 
  VALUES ( 5, 'Johanna K�ster'  , 'Wachtelstr. 7'    , 90427, 'N�rnberg'  , DATE '1984-02-07', 'ges' , 1   , 2100.00 , '5' , 'Vertreter'  ); 
INSERT INTO Personal 
  VALUES ( 6, 'Marianne Lambert', 'Fraunhofer Str 3' , 92224, 'Landshut'  , DATE '1974-05-22', 'verh', NULL, 4100.00 , '1' , 'Meister'    ); 
INSERT INTO Personal 
  VALUES ( 3, 'Ursula Rank'     , 'Dreieichstr. 12'  , 60594, 'Frankfurt' , DATE '1967-09-04', 'verh', 6   , 2700.00 , '1' , 'Facharbeiterin' ); 
INSERT INTO Personal 
  VALUES ( 7, 'Thomas Noster'   , 'Mahlergasse 10'   , 93047, 'Regensburg', DATE '1972-09-17', 'verh', 6   , 2500.00 , '5' , 'Arbeiter'   ); 
INSERT INTO Personal 
  VALUES ( 8, 'Renate Wolters'  , 'Lessingstr. 9'    , 86159, 'Augsburg'  , DATE '1979-07-14', 'led' , 1   , 3300.00 , '4' , 'Sachbearbeiterin'  ); 
INSERT INTO Personal 
  VALUES ( 9, 'Ernst Pach'      , 'Olgastr. 99'      , 70180, 'Stuttgart' , DATE '1992-03-29', 'led' , 6   , 800.00  , NULL, 'Azubi'      ); 
 
INSERT INTO Artikel 
  VALUES ( 100001, 'Herren-City-Rad'                , 588.24, 111.76, 700.00, 'blau',    '26 Zoll', 'ST', 'E'); 
INSERT INTO Artikel 
  VALUES ( 100002, 'Damen-City-Rad'                 , 546.22, 103.78, 650.00, 'rot',     '26 Zoll', 'ST', 'E'); 
INSERT INTO Artikel 
  VALUES ( 200001, 'Herren-City-Rahmen lackiert'    , 336.13,  63.87, 400.00, 'blau',    NULL     , 'ST', 'Z'); 
INSERT INTO Artikel 
  VALUES ( 200002, 'Damen-City-Rahmen lackiert'     , 336.13,  63.87, 400.00, 'rot',     NULL     , 'ST', 'Z');     
INSERT INTO Artikel 
  VALUES ( 300001, 'Herren-City-Rahmen geschweisst' , 310.92,  59.08, 370.00, NULL,      NULL     , 'ST', 'Z'); 
INSERT INTO Artikel 
  VALUES ( 300002, 'Damen-City-Rahmen geschweisst'  , 310.92,  59.08, 370.00, NULL,      NULL     , 'ST', 'Z'); 
INSERT INTO Artikel 
  VALUES ( 400001, 'Rad'                            ,  58.82,  11.18,  70.00, NULL,      '26 Zoll', 'ST', 'Z'); 
INSERT INTO Artikel 
  VALUES ( 500001, 'Rohr 25CrMo4 9mm'               ,   6.30,   1.20,   7.50, NULL,      '9mm'    , 'CM', 'F');  
INSERT INTO Artikel 
  VALUES ( 500002, 'Sattel'                         ,  42.02,   7.98,  50.00, NULL,      NULL     , 'ST', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500003, 'Gruppe Deore LX'                ,   5.88,   1.12,   7.00, NULL,      'LX'     , 'ST', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500004, 'Gruppe Deore XT'                ,   5.04,   0.96,   6.00, NULL,      'XT'     , 'ST', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500005, 'Gruppe XC-LTD'                  ,   6.72,   1.28,   8.00, NULL,      'XC-LTD' , 'ST', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500006, 'Felgensatz'                     ,  33.61,   6.39,  40.00, NULL,      '26 Zoll', 'ST', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500007, 'Bereifung Schwalbe'             ,  16.81,   3.19,  20.00, NULL,      '26 Zoll', 'ST', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500008, 'Lenker + Vorbau'                ,  78.99,  15.01,  94.00, NULL,      NULL     , 'ST', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500009, 'Sattelstuetze'                  ,   4.62,   0.88,   5.50, NULL,      NULL     , 'ST', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500010, 'Pedalsatz'                      ,  33.61,   6.39,  40.00, NULL,      NULL     , 'ST', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500011, 'Rohr 34CrMo4 2.1mm'             ,   3.36,   0.64,   4.00, NULL,      '2,1mm'  , 'CM', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500012, 'Rohr 34CrMo3 2.4mm'             ,   3.61,   0.69,   4.30, NULL,      '2,4mm'  , 'CM', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500013, 'Tretlager'                      ,  25.21,   4.79,  30.00, NULL,      NULL     , 'ST', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500014, 'Gabelsatz'                      ,  10.08,   1.92,  12.00, NULL,      NULL     , 'ST', 'F'); 
INSERT INTO Artikel 
  VALUES ( 500015, 'Schlauch'                       ,   6.72,   1.28,   8.00, NULL,      '26 Zoll', 'ST', 'F'); 
 
INSERT INTO Lager                       
  VALUES ( 100001, '001002',    3,    0,    2,    0 );          
INSERT INTO Lager 
  VALUES ( 100002, '001001',    6,    0,    3,    0 ); 
INSERT INTO Lager 
  VALUES ( 200001, NULL    ,    0,    0,    0,    0 ); 
INSERT INTO Lager 
  VALUES ( 200002, '004004',    2,    0,    0,    0 ); 
INSERT INTO Lager 
  VALUES ( 300001, NULL    ,    0,    0,    0,    0 ); 
INSERT INTO Lager 
  VALUES ( 300002, '002001',    7,    0,    2,    0 ); 
INSERT INTO Lager 
  VALUES ( 500001, '003005', 8050, 6000,  184,    0 ); 
INSERT INTO Lager 
  VALUES ( 500002, '002002',   19,   20,    2,   10 ); 
INSERT INTO Lager 
  VALUES ( 500003, '001003',   15,   10,    0,    0 ); 
INSERT INTO Lager 
  VALUES ( 500004, '004001',   18,   10,    0,    0 ); 
INSERT INTO Lager 
  VALUES ( 500005, '003002',    2,    0,    0,    0 ); 
INSERT INTO Lager 
  VALUES ( 400001, '005001',    1,    0,    0,    0 ); 
INSERT INTO Lager 
  VALUES ( 500006, '003004',   21,   20,    0,    0 ); 
INSERT INTO Lager 
  VALUES ( 500007, '002003',   62,   40,    0,    0 ); 
INSERT INTO Lager 
  VALUES ( 500008, '003003',   39,   20,    1,    0 ); 
INSERT INTO Lager 
  VALUES ( 500009, '002007',   23,   20,    0,    0 ); 
INSERT INTO Lager 
  VALUES ( 500010, '001006',   27,   20,    1,    0 ); 
INSERT INTO Lager 
  VALUES ( 500011, '001007', 3250, 3000,  161,    0 ); 
INSERT INTO Lager 
  VALUES ( 500012, '004002',  720,  600,   20,    0 ); 
INSERT INTO Lager 
  VALUES ( 500013, '005002',   20,   20,    2,    0 ); 
INSERT INTO Lager 
  VALUES ( 500014, '005003',   27,   20,    1,    0 ); 
INSERT INTO Lager 
  VALUES ( 500015, '002004',   55,   40,    0,    0 ); 

INSERT INTO Teilestruktur 
  VALUES ( 100001, 200001,   1 , 'ST' );       
INSERT INTO Teilestruktur 
  VALUES ( 100001, 500002,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100001, 500003,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100001, 400001,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100001, 500008,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100001, 500009,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100001, 500010,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100002, 200002,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100002, 500002,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100002, 500004,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100002, 400001,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100002, 500008,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100002, 500009,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 100002, 500010,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 200001, 300001,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 200002, 300002,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 300001, 500001, 180 , 'CM' ); 
INSERT INTO Teilestruktur 
  VALUES ( 300001, 500011, 161 , 'CM' ); 
INSERT INTO Teilestruktur 
  VALUES ( 300001, 500012,  20 , 'CM' ); 
INSERT INTO Teilestruktur 
  VALUES ( 300001, 500013,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 300001, 500014,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 300002, 500001, 360 , 'CM' ); 
INSERT INTO Teilestruktur 
  VALUES ( 300002, 500011, 106 , 'CM' ); 
INSERT INTO Teilestruktur 
  VALUES ( 300002, 500012,  20 , 'CM' ); 
INSERT INTO Teilestruktur 
  VALUES ( 300002, 500013,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 300002, 500014,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 400001, 500007,   2 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 400001, 500006,   1 , 'ST' ); 
INSERT INTO Teilestruktur 
  VALUES ( 400001, 500015,   2 , 'ST' ); 
 
INSERT INTO Lieferung 
  VALUES ( 500001, 5, 1,   5.50, 0); 
INSERT INTO Lieferung 
  VALUES ( 500002, 2, 4,  36.60, 10); 
INSERT INTO Lieferung 
  VALUES ( 500002, 1, 5,  35.10, 0); 
INSERT INTO Lieferung 
  VALUES ( 500003, 3, 6,   5.60, 0); 
INSERT INTO Lieferung 
  VALUES ( 500003, 4, 5,   5.45, 0); 
INSERT INTO Lieferung 
  VALUES ( 500003, 2, 4,   5.70, 0); 
INSERT INTO Lieferung 
  VALUES ( 500004, 3, 2,   4.70, 0); 
INSERT INTO Lieferung 
  VALUES ( 500004, 4, 3,   4.50, 0); 
INSERT INTO Lieferung 
  VALUES ( 500005, 4, 5,   5.70, 0); 
INSERT INTO Lieferung 
  VALUES ( 500006, 1, 1,  26.00, 0); 
INSERT INTO Lieferung 
  VALUES ( 500007, 1, 2,  15.50, 0); 
INSERT INTO Lieferung 
  VALUES ( 500008, 1, 4,  73.00, 0); 
INSERT INTO Lieferung 
  VALUES ( 500009, 1, 2,   4.00, 0); 
INSERT INTO Lieferung 
  VALUES ( 500009, 2, 1,   4.30, 0); 
INSERT INTO Lieferung 
  VALUES ( 500010, 1, 3,  29.90, 0); 
INSERT INTO Lieferung 
  VALUES ( 500011, 5, 1,   2.60, 0); 
INSERT INTO Lieferung 
  VALUES ( 500012, 5, 1,   3.20, 0); 
INSERT INTO Lieferung 
  VALUES ( 500013, 1, 4,  21.00, 0); 
INSERT INTO Lieferung 
  VALUES ( 500014, 1, 5,   9.00, 0); 
INSERT INTO Lieferung 
  VALUES ( 500015, 1, 1,   6.00, 0); 

INSERT INTO Auftrag 
  VALUES ( 1, DATE '2013-01-04', 1, 2); 
INSERT INTO Auftrag 
  VALUES ( 2, DATE '2013-01-06', 3, 5); 
INSERT INTO Auftrag 
  VALUES ( 3, DATE '2013-01-07', 4, 2); 
INSERT INTO Auftrag 
  VALUES ( 4, DATE '2013-01-18', 6, 5); 
INSERT INTO Auftrag 
  VALUES ( 5, DATE '2013-02-03', 1, 2); 
 
INSERT INTO Auftragsposten 
  VALUES ( 101, 1, 200002, 2,  800.00); 
INSERT INTO Auftragsposten 
  VALUES ( 201, 2, 100002, 3, 1950.00); 
INSERT INTO Auftragsposten 
  VALUES ( 202, 2, 200001, 1,  400.00); 
INSERT INTO Auftragsposten 
  VALUES ( 301, 3, 100001, 1,  700.00); 
INSERT INTO Auftragsposten 
  VALUES ( 302, 3, 500002, 2,  100.00); 
INSERT INTO Auftragsposten 
  VALUES ( 401, 4, 100001, 1,  700.00); 
INSERT INTO Auftragsposten 
  VALUES ( 402, 4, 500001, 4,   30.00); 
INSERT INTO Auftragsposten 
  VALUES ( 403, 4, 500008, 1,   94.00); 
INSERT INTO Auftragsposten 
  VALUES ( 501, 5, 500010, 1,   40.00); 
INSERT INTO Auftragsposten 
  VALUES ( 502, 5, 500013, 1,   30.00); 

INSERT INTO Reservierung 
  VALUES ( 101, 300002,   2 ); 
INSERT INTO Reservierung 
  VALUES ( 201, 100002,   3 ); 
INSERT INTO Reservierung 
  VALUES ( 202, 500001, 180 ); 
INSERT INTO Reservierung 
  VALUES ( 202, 500011, 161 ); 
INSERT INTO Reservierung 
  VALUES ( 202, 500012,  20 ); 
INSERT INTO Reservierung 
  VALUES ( 202, 500013,   1 ); 
INSERT INTO Reservierung 
  VALUES ( 202, 500014,   1 ); 
INSERT INTO Reservierung 
  VALUES ( 301, 100001,   1 ); 
INSERT INTO Reservierung 
  VALUES ( 302, 500002,   2 ); 
INSERT INTO Reservierung 
  VALUES ( 401, 100001,   1 ); 
INSERT INTO Reservierung 
  VALUES ( 402, 500001,   4 ); 
INSERT INTO Reservierung 
  VALUES ( 403, 500008,   1 ); 
INSERT INTO Reservierung 
  VALUES ( 501, 500010,   1 ); 
INSERT INTO Reservierung 
  VALUES ( 502, 500013,   1 ); 


-- Hinzuf�gen der Spalte --------------------------------------------------------------------
ALTER TABLE Personal
ADD Permission integer DEFAULT 1;

-- Trigger ----------------------------------------------------------------------------------

-- �berpr�ft ob beim �ndern oder hinzuf�gen eines Mitarbeiter �ber 5000 Euro ist
CREATE OR REPLACE TRIGGER check_gehalt
BEFORE INSERT OR UPDATE ON Personal
FOR EACH ROW
BEGIN
    IF :NEW.gehalt > 5000 THEN
        RAISE_APPLICATION_ERROR(-20001, 'Fehler: Gehalt darf maximal 5000 Euro betragen!');
    END IF;
END;
/

-- Permission Spalte inerhalb von 1 und 99
CREATE OR REPLACE TRIGGER PermissionEingabe
BEFORE INSERT OR UPDATE ON Personal
FOR EACH ROW
BEGIN
    IF :NEW.Permission <= 0 OR :NEW.Permission > 99 THEN
        RAISE_APPLICATION_ERROR(-20002, 'Fehler: Permission muss zwischen 1 und 99 liegen!');
    END IF;
END;
/
-- View ----------------------------------------------------------------------------------
-- Erstellen aller Vorgesetzen bezogen auf Mitarbeiter
CREATE OR REPLACE VIEW Mitarbeiter_Vorgesetzte AS
SELECT 
    p.Persnr AS Mitarbeiter_ID,
    p.Name AS Mitarbeiter_Name,
    v.Persnr AS Vorgesetzter_ID,
    v.Name AS Vorgesetzter_Name
FROM Personal p
LEFT JOIN Personal v ON p.Vorgesetzt = v.Persnr;

-- SELECT * FROM Mitarbeiter_Vorgesetzte;

-- Prozedur ----------------------------------------------------------------------------------

-- Kunden Sperren und Entsperren
CREATE OR REPLACE PROCEDURE Kunde_SperreAendern(
    p_KundenNr IN NUMBER
) AS
    p_Aktion NUMBER;
BEGIN
     -- Pr�fen, ob der Kunde existiert
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
        RAISE_APPLICATION_ERROR(-20001, 'Ung�ltiger Statuswert.');
    END IF;

    COMMIT;
END Kunde_SperreAendern;

-- Aufrufen der Prozedur in den Klammern die Kunden Nr eingeben
-- Call Kunde_SperreAendern(...); -- 


-- Beurteilung des Personals
CREATE OR REPLACE PROCEDURE Beurteile_Personal (
    p_PersonalNr IN NUMBER,
    p_Beurteilung IN VARCHAR2
) AS
    v_Existiert NUMBER;
BEGIN
    -- Pr�fen, ob das Personal existiert
    SELECT COUNT(*) INTO v_Existiert FROM Personal WHERE Persnr = p_PersonalNr;

    IF v_Existiert = 0 THEN
        RAISE_APPLICATION_ERROR(-20003, 'Personal nicht gefunden.');
    END IF;

    -- Pr�fen, ob die Beurteilung zwischen '1' und '6' liegt
    IF NOT REGEXP_LIKE(p_Beurteilung, '^[1-6]$') THEN
        RAISE_APPLICATION_ERROR(-20004, 'Ung�ltige Beurteilung. Nur Werte zwischen 1 und 6 erlaubt.');
    END IF;

    -- Beurteilung aktualisieren
    UPDATE Personal
    SET Beurteilung = p_Beurteilung
    WHERE Persnr = p_PersonalNr;

    COMMIT;
END Beurteile_Personal;

--In den Klammer kommt erst die Personal Nr dann die Bewertung die nur zwichen 1 und 6 sein darf
-- Call Beurteile_Personal(1, 6);

