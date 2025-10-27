-- Création de la base
CREATE DATABASE vizion_academy;

\c vizion_academy;

-- ===========================
-- SEQUENCES POUR LES IDS
-- ===========================
CREATE SEQUENCE seq_intervenant START 1;
CREATE SEQUENCE seq_ecole START 1;
CREATE SEQUENCE seq_challenge START 1;
CREATE SEQUENCE seq_demandes_challenge START 1;
CREATE SEQUENCE seq_contact_partenariat START 1;
-- CREATE SEQUENCE seq_etat_mission START 1;
CREATE SEQUENCE seq_mission START 1;
CREATE SEQUENCE seq_facture START 1;
CREATE SEQUENCE seq_favoris START 1;
CREATE SEQUENCE seq_declaration START 1;
CREATE SEQUENCE seq_notification START 1;
CREATE SEQUENCE seq_ticket START 1;
CREATE SEQUENCE seq_admin START 1;
CREATE SEQUENCE seq_logs START 1;

-- ===========================
-- INTERVENANT
-- ===========================
CREATE TABLE intervenant (
    id_intervenant VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('INTV-', nextval('seq_intervenant')),
    nom_intervenant VARCHAR(100) NOT NULL,
    prenom_intervenant VARCHAR(100) NOT NULL,
    email_login VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    photo_intervenant VARCHAR(255),
    bio_intervenant TEXT,
    diplome VARCHAR(255),
    cv VARCHAR(255),
    video VARCHAR(255),
    langues VARCHAR(255)[],
    domaines VARCHAR(255)[],
    ville VARCHAR(100),
    disponibilite INT DEFAULT 0, -- 1 dispo, 0 pas dispo
    date_derniere_connexion TIMESTAMP,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================
-- INTERVENANT - DONNEES
-- ===========================
-- ===========================
-- INTERVENANT - DONNEES
-- ===========================
INSERT INTO intervenant (
  nom_intervenant, prenom_intervenant, email_login, mot_de_passe,
  photo_intervenant, bio_intervenant, diplome, cv, video,
  langues, domaines, ville, disponibilite
)
VALUES
('Dupont',  'Marie',  'marie.dupont@example.fr',  '0001',
 '/home/legendary/Nardy Folder/images/interv-1.jpeg',
 'Formatrice en communication, 10 ans d''expérience en entreprise.',
 'Master Communication',
 '/cvs/marie_dupont.pdf',
 'https://www.youtube.com/watch?v=KOxm2ixGg0E&list=RD6DpKzycY9RQ&index=6',
 ARRAY['français','anglais'],
 ARRAY['communication','prise de parole'],
 'Paris', 1),

('Martin',  'Paul',   'paul.martin@example.fr',   '1234',
 '/home/legendary/Nardy Folder/images/interv-2.jpeg',
 'Ingénieur logiciel spécialisé Node.js et architectures serveurless.',
 'Diplôme d''ingénieur',
 '/cvs/paul_martin.pdf',
 NULL,
 ARRAY['français','anglais','espagnol'],
 ARRAY['informatique','devops'],
 'Lyon', 1),

('Leroy',   'Sophie', 'sophie.leroy@example.fr',  '4321',
 NULL,
 'Professeure d''arts plastiques, expérimentée en pédagogie créative.',
 'Licence Arts Plastiques',
 NULL,
 'https://vimeo.com/example2',
 ARRAY['français'],
 ARRAY['arts plastiques','créativité'],
 'Nantes', 0),

('Dubois',  'Jacques','jacques.dubois@example.fr', '9876',
 '/photos/jacques_dubois.jpg',
 'Consultant en management et stratégie, intervient en entreprises et ONG.',
 'MBA',
 '/cvs/jacques_dubois.pdf',
 NULL,
 ARRAY['français','anglais'],
 ARRAY['management','stratégie'],
 'Marseille', 1);


-- ===========================
-- ECOLE
-- ===========================
CREATE TABLE ecole (
    id_ecole VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('ECL-', nextval('seq_ecole')),
    nom_ecole VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(50),
    adresse TEXT,
    date_derniere_connexion TIMESTAMP,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- ===========================
-- DONNEES ECOLE
-- ===========================
INSERT INTO ecole (nom_ecole, email, mot_de_passe, telephone, adresse)
VALUES
('sLycée Jean Moulin',          'econtact@lycee-jeanmouline.fr', '1234', '+33 1 40 00 11 11', '12 rue de la République, 75011 Paris'),
('École Municipale des Arts',  'accueil@ecole-arts.fr', '4567',  '+33 4 72 00 22 22', '18 place Bellecour, 69002 Lyon'),
('Institut Saint-Exupéry',     'info@institut-stex.fr', '6789',  '+33 2 40 00 33 33', '5 avenue de la Marine, 44000 Nantes');



-- ===========================
-- CHALLENGE
-- ===========================
CREATE TABLE challenge (
    id_challenge VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('CHL-', nextval('seq_challenge')),
    titre VARCHAR(255) NOT NULL,
    descriptions TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================
-- DEMANDES CHALLENGE
-- ===========================
CREATE TABLE demandes_challenge (
    id_demandes_challenge VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('DCH-', nextval('seq_demandes_challenge')),
    nom_client VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(50),
    descriptions TEXT NOT NULL,
    ecole_id VARCHAR(20) REFERENCES ecole(id_ecole) ON DELETE SET NULL,
    intervenant_id VARCHAR(20) REFERENCES intervenant(id_intervenant) ON DELETE SET NULL,
    date_soumission TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================
-- CONTACT PARTENARIAT
-- ===========================
CREATE TABLE contacts_partenariats (
    id_contact_partenariat VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('CTP-', nextval('seq_contact_partenariat')),
    nom_contact_partenariat VARCHAR(255) NOT NULL,
    entreprise VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(50),
    messages TEXT NOT NULL,
    date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- ===========================
-- MISSION
-- ===========================
CREATE TABLE mission (
    id_mission VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('MIS-', nextval('seq_mission')),
    titre VARCHAR(255) NOT NULL,
    descriptions_mission TEXT,
    intervenant_id VARCHAR(20) REFERENCES intervenant(id_intervenant) ON DELETE CASCADE ON UPDATE CASCADE,
    ecole_id VARCHAR(20) REFERENCES ecole(id_ecole) ON DELETE CASCADE,
    date_debut TIMESTAMP,
    date_fin TIMESTAMP,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    duree INT,
    conditions TEXT
);

-- ===========================
-- MISSION - DONNEES
-- ===========================


-- Mission en cours
INSERT INTO mission (titre, descriptions_mission, intervenant_id, ecole_id, date_debut, date_fin)
VALUES (
    'Mission En Cours',
    'Mission test pour vérifier état en cours',
    'INTV-1',
    'ECL-1',
    NOW() - INTERVAL '1 day',  -- Commencée hier
    NOW() + INTERVAL '2 days'  -- Finira dans 2 jours
);

-- Mission passée
INSERT INTO mission (titre, descriptions_mission, intervenant_id, ecole_id, date_debut, date_fin)
VALUES (
    'Mission Passée',
    'Mission test pour vérifier état passée',
    'INTV-2',
    'ECL-2',
    NOW() - INTERVAL '10 days',  -- Commencée il y a 10 jours
    NOW() - INTERVAL '5 days'    -- Finie il y a 5 jours
);

-- donnees mission conditionss
INSERT INTO mission (
    titre,
    descriptions_mission,
    intervenant_id,
    ecole_id,
    date_debut,
    date_fin,
    date_creation,
    duree,
    conditions
) VALUES
(
    'Professeur de Mathématiques',
    'Enseignement des mathématiques avancées pour classes de terminale',
    'INTV-1',
    'ECL-1',
    '2024-09-01 08:00:00',
    '2025-06-30 17:00:00',
    '2024-08-15 10:00:00',
    10,
    'Diplôme en mathématiques, 5 ans d''expérience minimum'
);

-- ===========================
-- FACTURES
-- ===========================
CREATE TABLE factures (
    id_facture VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('FAC-', nextval('seq_facture')),
    mission_id VARCHAR(20) REFERENCES mission(id_mission) ON DELETE CASCADE,
    intervenant_id VARCHAR(20) REFERENCES intervenant(id_intervenant) ON DELETE CASCADE,
    ecole_id VARCHAR(20) REFERENCES ecole(id_ecole) ON DELETE CASCADE,
    montant NUMERIC(12,2) NOT NULL,
    statut VARCHAR(50) DEFAULT 'en attente', -- en attente / payée / en validation
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_paiement TIMESTAMP
);
-- ===========================
-- FACTURES - DONNEES
-- ===========================

CREATE TABLE factures (
    id_facture VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('FAC-', nextval('seq_facture')),
    mission_id VARCHAR(20) REFERENCES mission(id_mission) ON DELETE CASCADE,
    intervenant_id VARCHAR(20) REFERENCES intervenant(id_intervenant) ON DELETE CASCADE,
    ecole_id VARCHAR(20) REFERENCES ecole(id_ecole) ON DELETE CASCADE,
    montant NUMERIC(12,2) NOT NULL,
    statut VARCHAR(50) DEFAULT 'en attente', -- en attente / payée / en validation
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_paiement TIMESTAMP
);

-- ===========================
-- FACTURES - DONNEES
-- ===========================

INSERT INTO factures (
    mission_id, intervenant_id, ecole_id, montant, statut, date_paiement
) VALUES
('MIS-1', 'INTV-1', 'ECL-1', 500.00, 'en attente', NULL),
('MIS-2', 'INTV-2', 'ECL-2', 750.00, 'payée', '2025-10-10 14:30:00');

-- ('MIS-3', 'INTV-3', 'ECL-3', 300.00, 'en validation', NULL);


-- ===========================
-- FAVORIS INTERVENANT POUR ECOLE
-- ===========================
CREATE TABLE favoris_intervenant (
    id_favoris VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('FAV-', nextval('seq_favoris')),
    ecole_id VARCHAR(20) REFERENCES ecole(id_ecole) ON DELETE CASCADE,
    intervenant_id VARCHAR(20) REFERENCES intervenant(id_intervenant) ON DELETE CASCADE,
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO favoris_intervenant (ecole_id, intervenant_id)
VALUES
('ECL-1', 'INTV-1'),
('ECL-1', 'INTV-2'),
('ECL-2', 'INTV-1'),
('ECL-2', 'INTV-2');


-- ===========================
-- DECLARATIONS D'ACTIVITE (style URSSAF)
-- ===========================
CREATE TABLE declarations_activite (
    id_declaration VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('DEC-', nextval('seq_declaration')),
    intervenant_id VARCHAR(20) REFERENCES intervenant(id_intervenant) ON DELETE CASCADE,
    date_declaration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    details VARCHAR(255)
);

-- ===========================
-- NOTIFICATIONS
-- ===========================
CREATE TABLE notifications (
    id_notification VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('NOT-', nextval('seq_notification')),
    utilisateur_type VARCHAR(50) NOT NULL, -- 'intervenant' ou 'ecole' ou 'admin'
    utilisateur_id VARCHAR(20) NOT NULL,
    type_notification VARCHAR(255),
    message TEXT,
    lu BOOLEAN DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================
-- SUPPORT ECOLE
-- ===========================
CREATE TABLE support_ecole (
    id_ticket VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('TIC-', nextval('seq_ticket')),
    ecole_id VARCHAR(20) REFERENCES ecole(id_ecole) ON DELETE CASCADE,
    sujet VARCHAR(255),
    message TEXT,
    reponse TEXT,
    statut VARCHAR(50) DEFAULT 'ouvert',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================
-- ADMINS VIZION
-- ===========================
CREATE TABLE admin (
    id_admin VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('ADM-', nextval('seq_admin')),
    nom_admin VARCHAR(255),
    email VARCHAR(255),
    mot_de_passe VARCHAR(255),
    role VARCHAR(50) DEFAULT 'admin',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================
-- LOGS DE SUPPORT ADMIN
-- ===========================
CREATE TABLE logs_support (
    id_log VARCHAR(20) PRIMARY KEY DEFAULT CONCAT('LOG-', nextval('seq_logs')),
    admin_id VARCHAR(20) REFERENCES admins(id_admin) ON DELETE CASCADE,
    cible_type VARCHAR(50), -- intervenant / ecole / mission / facture
    cible_id VARCHAR(20),
    action TEXT,
    date_action TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
