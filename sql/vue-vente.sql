CREATE OR REPLACE VIEW vue_vente AS
SELECT vente_id as id, date_vente, montant, departement_id, vendeur_id
FROM ventes;