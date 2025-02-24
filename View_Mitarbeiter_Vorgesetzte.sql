CREATE OR REPLACE VIEW Mitarbeiter_Vorgesetzte AS
SELECT 
    p.Persnr AS Mitarbeiter_ID,
    p.Name AS Mitarbeiter_Name,
    v.Persnr AS Vorgesetzter_ID,
    v.Name AS Vorgesetzter_Name
FROM Personal p
LEFT JOIN Personal v ON p.Vorgesetzt = v.Persnr;

SELECT * FROM Mitarbeiter_Vorgesetzte;