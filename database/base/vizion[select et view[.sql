SELECT *
FROM mission
WHERE ecole_id = 'ECL-2'         -- Remplace par l'id de l'école concernée
  AND NOW() BETWEEN date_debut AND date_fin
ORDER BY date_debut ASC;


SELECT *
FROM mission
WHERE ecole_id = 'ECL-2'         -- Remplace par l'id de l'école concernée
  AND date_fin < NOW()
ORDER BY date_fin DESC;


CREATE or REPLACE VIEW mission_avec_etat AS
SELECT
    mission.id_mission,
    mission.titre,
    mission.descriptions_mission,
    mission.intervenant_id,
    mission.ecole_id,
    ecole.nom_ecole,
    mission.date_debut,
    mission.date_fin,
    mission.date_creation,
    mission.duree,
    CASE
        WHEN date_debut IS NULL OR date_fin IS NULL THEN 'planifiée'
        WHEN NOW() < date_debut THEN 'planifiée'  -- Changé de 'en validation' à 'planifiée'
        WHEN NOW() BETWEEN date_debut AND date_fin THEN 'en cours'
        WHEN NOW() > date_fin THEN 'terminée'
        ELSE 'indéterminé'
    END AS etat_mission
FROM mission
JOIN ecole ON mission.ecole_id = ecole.id_ecole;

select * from mission_avec_etat;

CREATE or replace view FactureassocieesAuxMissions AS
SELECT
    factures.id_facture,
    factures.mission_id,
    factures.intervenant_id,
    factures.ecole_id,
    ecole.nom_ecole,
    mission.titre AS titre_mission,
    factures.montant,
    factures.date_creation,
    factures.date_paiement,
    factures.statut
FROM factures
JOIN mission on factures.mission_id = mission.id_mission
join intervenant on mission.intervenant_id = intervenant.id_intervenant
join ecole on mission.ecole_id = ecole.id_ecole

select * from FactureassocieesAuxMissions;
select * from factures;

CREATE OR REPLACE VIEW historiqueCollaborateurIntervenant AS
SELECT
    factures.mission_id,
    factures.intervenant_id,
    factures.ecole_id,
    ecole.nom_ecole,
    intervenant.nom_intervenant,
    intervenant.prenom_intervenant,
    mission.titre AS titre_mission,
    factures.montant
FROM factures
JOIN mission on factures.mission_id = mission.id_mission
join intervenant on mission.intervenant_id = intervenant.id_intervenant
join ecole on mission.ecole_id = ecole.id_ecole


SELECT * from historiquecollaborateurintervenant;


select
    mission.id_mission,
    mission.titre AS titre_mission,
    mission.intervenant_id,
    intervenant.nom_intervenant,
    intervenant.prenom_intervenant,
    mission.ecole_id,
    ecole.nom_ecole,
    mission.date_debut,
    mission.date_fin,
    intervenant.nom_intervenant,
    intervenant.prenom_intervenant,
    ecole.nom_ecole
from mission
join intervenant on mission.intervenant_id = intervenant.id_intervenant
join ecole on mission.ecole_id = ecole.id_ecole;


ALTER TABLE mission
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;


SELECT
    mission.id_mission,
    mission.titre,
    mission.descriptions_mission,
    mission.intervenant_id,
    mission.ecole_id,
    ecole.nom_ecole,
    mission.date_debut,
    mission.date_fin,
    mission.date_creation,
    mission.duree,
    CASE
        WHEN date_debut IS NULL OR date_fin IS NULL THEN 'planifiée'
        WHEN NOW() < date_debut THEN 'planifiée'  -- Changé de 'en validation' à 'planifiée'
        WHEN NOW() BETWEEN date_debut AND date_fin THEN 'en cours'
        WHEN NOW() > date_fin THEN 'terminée'
        ELSE 'indéterminé'
    END AS etat_mission
FROM mission
JOIN ecole ON mission.ecole_id = ecole.id_ecole;

select * from favoris_intervenant;


CREATE OR REPLACE VIEW favorisIntervanantView as
select
favoris_intervenant.id_favoris,
favoris_intervenant.date_ajout,
ecole.id_ecole,
intervenant.id_intervenant,
intervenant.nom_intervenant,
intervenant.prenom_intervenant,
intervenant.domaines
from favoris_intervenant
JOIN ecole on ecole.id_ecole = favoris_intervenant.ecole_id
JOIN intervenant on intervenant.id_intervenant = favoris_intervenant.intervenant_id;



-- Requête pour trouver les intervenants favoris qui ont déjà collaboré avec une école spécifique
SELECT
    i.id_intervenant,
    i.nom_intervenant,
    i.prenom_intervenant,
    i.email_login,
    i.photo_intervenant,
    i.bio_intervenant,
    i.domaines,
    f.id_favoris,
    f.date_ajout,
    COUNT(m.id_mission) as nombre_missions,
    MAX(m.date_debut) as derniere_collaboration
FROM favoris_intervenant f
INNER JOIN intervenant i ON f.intervenant_id = i.id_intervenant
INNER JOIN mission m ON f.intervenant_id = m.intervenant_id AND f.ecole_id = m.ecole_id
WHERE f.ecole_id = 'ECL-1'  -- Remplacez par l'ID de l'école connectée
GROUP BY
    i.id_intervenant, i.nom_intervenant, i.prenom_intervenant,
    i.email_login, i.photo_intervenant, i.bio_intervenant, i.domaines,
    f.id_favoris, f.date_ajout
HAVING COUNT(m.id_mission) > 0
ORDER BY derniere_collaboration DESC;


SELECT
    *
FROM
    favoris_intervenant
WHERE
    ecole_id = 'ECL-1'
ORDER BY
date_ajout DESC

SELECT id_intervenant, nom, prenom, email
FROM intervenant
WHERE id_intervenat IN (123, 456, 789);  -- Tous les intervenant_id trouvés dans la première requête


SELECT i.*, f.date_ajout
FROM intervenant i
INNER JOIN favoris_intervenant f ON i.id_intervenant = f.intervenant_id
WHERE f.ecole_id = 'ECL-2'
ORDER BY f.date_ajout DESC;


-- Vérifiez le contenu de votre table favoris_intervenant
SELECT * FROM favoris_intervenant WHERE ecole_id = 'ECL-2';

SELECT i.*, f.date_ajout
            FROM intervenant i
            INNER JOIN favoris_intervenant f ON i.id_intervenant = f.intervenant_id
            WHERE f.ecole_id = 'ECL-2'
            ORDER BY f.date_ajout DESC



            SELECT i.id_intervenant,
       i.nom_intervenant,
       i.prenom_intervenant,
       i.photo_intervenant,
       i.bio_intervenant,
       i.diplome,
       i.cv,
       i.domaines,
       f.date_ajout
FROM favoris_intervenant f
JOIN intervenant i ON f.intervenant_id = i.id_intervenant
WHERE f.ecole_id = 'ECL-1'
ORDER BY f.date_ajout DESC;

