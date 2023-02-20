CREATE OR REPLACE VIEW vue_personne AS
SELECT 
personne_id as id,prenom, nom, date_naissance, nationalite

FROM personnes