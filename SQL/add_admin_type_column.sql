-- Insert test data for admin table
INSERT INTO `admin` (`admin_id`, `username`, `wachtwoord`, `email`, `volledige_naam`, `is_actief`, `laatste_login`, `aangemaakt_op`, `bijgewerkt_op`, `type`) VALUES
(2, 'SuElect\\NA-MeerveldA', '$2y$10$abc123def456ghi789jkl012mno345pqr678stu901vwx234yz567890', 'anouk.meerveld@suelect.sr', 'Anouk Marie Meerveld', 1, '2025-06-10 14:20:15', '2025-03-15 09:15:22', '2025-06-10 14:20:15', 'normal_admin'),
(3, 'SuElect\\NA-KrosenR', '$2y$10$def456ghi789jkl012mno345pqr678stu901vwx234yz567890abc123', 'ricardo.krosen@suelect.sr', 'Ricardo David Krosen', 1, '2025-06-09 16:45:30', '2025-03-18 11:30:45', '2025-06-09 16:45:30', 'normal_admin'),
(4, 'SuElect\\NA-BlankenburgL', '$2y$10$ghi789jkl012mno345pqr678stu901vwx234yz567890abc123def456', 'lucia.blankenburg@suelect.sr', 'Lucia Elisabeth Blankenburg', 0, NULL, '2025-04-02 13:22:10', '2025-04-02 13:22:10', 'normal_admin');

-- Insert test data for distrikt table
INSERT INTO `distrikt` (`distrikt_id`, `naam`, `aantal_zetels`, `aangemaakt_op`, `bijgewerkt_op`) VALUES
(1, 'Paramaribo', 12, '2025-01-15 10:00:00', '2025-01-15 10:00:00'),
(2, 'Wanica', 8, '2025-01-15 10:05:00', '2025-01-15 10:05:00'),
(3, 'Nickerie', 6, '2025-01-15 10:10:00', '2025-01-15 10:10:00'),
(4, 'Commewijne', 4, '2025-01-15 10:15:00', '2025-01-15 10:15:00'),
(5, 'Saramacca', 3, '2025-01-15 10:20:00', '2025-01-15 10:20:00'),
(6, 'Para', 2, '2025-01-15 10:25:00', '2025-01-15 10:25:00'),
(7, 'Marowijne', 2, '2025-01-15 10:30:00', '2025-01-15 10:30:00'),
(8, 'Brokopondo', 1, '2025-01-15 10:35:00', '2025-01-15 10:35:00'),
(9, 'Coronie', 1, '2025-01-15 10:40:00', '2025-01-15 10:40:00'),
(10, 'Sipaliwini', 1, '2025-01-15 10:45:00', '2025-01-15 10:45:00');

-- Insert test data for partij table
INSERT INTO `partij` (`partij_id`, `naam`, `logo_url`, `beschrijving`, `aangemaakt_op`, `bijgewerkt_op`) VALUES
(1, 'Progressieve Volkspartij (PVP)', '/assets/logos/pvp.png', 'Een politieke partij gericht op vooruitgang en sociale rechtvaardigheid voor alle burgers.', '2025-01-20 09:00:00', '2025-01-20 09:00:00'),
(2, 'Nieuwe Democratische Beweging (NDB)', '/assets/logos/ndb.png', 'De Nieuwe Democratische Beweging streeft naar een moderne democratie en economische groei.', '2025-01-20 09:15:00', '2025-01-20 09:15:00'),
(3, 'Eenheidspartij voor Ontwikkeling (EPO)', '/assets/logos/epo.png', 'EPO werkt aan de eenheid en duurzame ontwikkeling van alle gemeenschappen.', '2025-01-20 09:30:00', '2025-01-20 09:30:00'),
(4, 'Sociaal Democratische Unie (SDU)', '/assets/logos/sdu.png', 'SDU bevordert sociale democratie en gelijkheid tussen alle bevolkingsgroepen.', '2025-01-20 09:45:00', '2025-01-20 09:45:00'),
(5, 'Liberale Hervormingspartij (LHP)', '/assets/logos/lhp.png', 'Een liberale partij voor een modern en hervormd politiek systeem.', '2025-01-20 10:00:00', '2025-01-20 10:00:00'),
(6, 'Arbeiderspartij voor Rechtvaardigheid (APR)', '/assets/logos/apr.png', 'APR vertegenwoordigt de belangen van werknemers en bevordert sociale rechtvaardigheid.', '2025-01-20 10:15:00', '2025-01-20 10:15:00');

-- Insert test data for gebruiker table
INSERT INTO `gebruiker` (`gebruiker_id`, `voornaam`, `achternaam`, `id_nummer`, `wachtwoord`, `email`, `geboorte_datum`, `geslacht`, `gestemd`, `aangemaakt_op`, `bijgewerkt_op`, `laatste_login`) VALUES
(3, 'Marcus', 'de Vries', '9YHI89ZB4', '$2y$10$pqr678stu901vwx234yz567890abc123def456ghi789jkl012mno345', 'marcus.devries@email.sr', '1985-07-12', 'M', 1, '2025-02-01 08:30:00', '2025-06-01 10:15:30', '2025-06-01 10:15:30'),
(4, 'Priya', 'Ramnarain', '7WGF67YC2', '$2y$10$stu901vwx234yz567890abc123def456ghi789jkl012mno345pqr678', 'priya.ramnarain@email.sr', '1992-11-23', 'V', 1, '2025-02-05 14:20:00', '2025-05-28 16:45:20', '2025-05-28 16:45:20'),
(5, 'Erik', 'van der Berg', '6VFE56XD1', '$2y$10$vwx234yz567890abc123def456ghi789jkl012mno345pqr678stu901', 'erik.vandenberg@email.sr', '1978-03-15', 'M', 0, '2025-02-10 11:45:00', '2025-06-05 09:30:15', '2025-06-05 09:30:15'),
(6, 'Anita', 'Soekhlal', '5UED45WE9', '$2y$10$yz567890abc123def456ghi789jkl012mno345pqr678stu901vwx234', 'anita.soekhlal@email.sr', '1990-09-08', 'V', 1, '2025-02-15 16:10:00', '2025-05-30 14:20:45', '2025-05-30 14:20:45'),
(7, 'Roberto', 'Fernandez', '4TDC34VF8', '$2y$10$890abc123def456ghi789jkl012mno345pqr678stu901vwx234yz567', 'roberto.fernandez@email.sr', '1987-12-03', 'M', 0, '2025-02-20 12:30:00', '2025-06-08 11:15:30', '2025-06-08 11:15:30'),
(8, 'Kamala', 'Bisessar', '3SCB23UG7', '$2y$10$abc123def456ghi789jkl012mno345pqr678stu901vwx234yz567890', 'kamala.bisessar@email.sr', '1995-05-20', 'V', 1, '2025-02-25 09:15:00', '2025-06-02 15:30:20', '2025-06-02 15:30:20'),
(9, 'Devon', 'Toussaint', '2RBA12TH6', '$2y$10$def456ghi789jkl012mno345pqr678stu901vwx234yz567890abc123', 'devon.toussaint@email.sr', '1982-08-14', 'M', 0, '2025-03-01 13:40:00', '2025-06-07 12:45:15', '2025-06-07 12:45:15'),
(10, 'Kavita', 'Mahadew', '1QAZ01SI5', '$2y$10$ghi789jkl012mno345pqr678stu901vwx234yz567890abc123def456', 'kavita.mahadew@email.sr', '1993-01-27', 'V', 1, '2025-03-05 10:20:00', '2025-06-03 13:20:40', '2025-06-03 13:20:40');

-- Insert test data for kandidaat table
INSERT INTO `kandidaat` (`kandidaat_id`, `naam`, `partij_id`, `distrikt_id`, `aantal_stemmen`, `type`, `bio`, `foto_url`, `aangemaakt_op`, `bijgewerkt_op`) VALUES
-- PVP Candidates
(1, 'Dr. Alexander Hendriks', 1, 1, 2547, 1, 'Ervaren advocaat en voormalig rechter met een sterke focus op rechtvaardigheid en transparantie in de politiek.', '/assets/photos/hendriks.jpg', '2025-01-25 10:00:00', '2025-06-11 16:00:00'),
(2, 'Isabella Kramer-Vos', 1, 1, 1832, 1, 'Voormalig minister van Onderwijs en advocate met jarenlange ervaring in sociale rechtvaardigheid.', '/assets/photos/kramer_vos.jpg', '2025-01-25 10:15:00', '2025-06-11 16:00:00'),
(3, 'Rafael Boekhoudt', 1, 2, 1654, 1, 'Ondernemer en gemeenschapsleider met focus op economische ontwikkeling en innovatie.', '/assets/photos/boekhoudt.jpg', '2025-01-25 10:30:00', '2025-06-11 16:00:00'),
(4, 'Maya Sewdien', 1, 2, 1423, 1, 'Onderwijskundige en voormalig schooldirecteur, gespecialiseerd in onderwijs en jeugdbeleid.', '/assets/photos/sewdien.jpg', '2025-01-25 10:45:00', '2025-06-11 16:00:00'),

-- NDB Candidates  
(5, 'Victor Bergman', 2, 1, 2134, 1, 'Voormalig minister van Buitenlandse Zaken met decennia ervaring in internationale betrekkingen.', '/assets/photos/bergman.jpg', '2025-01-25 11:00:00', '2025-06-11 16:00:00'),
(6, 'Carmen Valdez', 2, 1, 1765, 1, 'Econoom en voormalig minister van Financiën met expertise in economische planning.', '/assets/photos/valdez.jpg', '2025-01-25 11:15:00', '2025-06-11 16:00:00'),
(7, 'Diana Oosterhoff', 2, 3, 1456, 1, 'Advocate en politica uit Nickerie, bekend om haar werk in de agrarische sector.', '/assets/photos/oosterhoff.jpg', '2025-01-25 11:30:00', '2025-06-11 16:00:00'),
(8, 'Fernando Delgado', 2, 3, 1289, 1, 'Ingenieur en projectmanager met focus op infrastructuur en regionale ontwikkeling.', '/assets/photos/delgado.jpg', '2025-01-25 11:45:00', '2025-06-11 16:00:00'),

-- EPO Candidates
(9, 'Samuel Rodrigues', 3, 4, 987, 1, 'Zakenman en gemeenschapsleider, bekend om zijn werk in lokale ontwikkelingsprojecten.', '/assets/photos/rodrigues.jpg', '2025-01-25 12:00:00', '2025-06-11 16:00:00'),
(10, 'Patricia Mackenzie', 3, 4, 834, 1, 'Advocate en mensenrechtenactivist uit Commewijne met focus op sociale rechtvaardigheid.', '/assets/photos/mackenzie.jpg', '2025-01-25 12:15:00', '2025-06-11 16:00:00'),
(11, 'Roberto Gonzalez', 3, 5, 756, 1, 'Gemeenschapsleider en ondernemer uit Saramacca met focus op duurzame ontwikkeling.', '/assets/photos/gonzalez.jpg', '2025-01-25 12:30:00', '2025-06-11 16:00:00'),

-- SDU Candidates
(12, 'Thomas van Leeuwen', 4, 5, 623, 1, 'Voormalig vakbondsleider en ervaren politicus uit Saramacca.', '/assets/photos/vanleeuwen.jpg', '2025-01-25 12:45:00', '2025-06-11 16:00:00'),
(13, 'Natasha Poeran', 4, 6, 543, 1, 'Onderwijzeres en gemeenschapsleider uit Para met focus op sociale voorzieningen.', '/assets/photos/poeran.jpg', '2025-01-25 13:00:00', '2025-06-11 16:00:00'),
(14, 'Miguel Santos', 4, 6, 487, 1, 'Voormalig minister van Sociale Zaken en ervaren beleidsmaker.', '/assets/photos/santos.jpg', '2025-01-25 13:15:00', '2025-06-11 16:00:00'),

-- LHP Candidates
(15, 'Charlotte Vermeulen', 5, 7, 412, 1, 'Advocate en politica uit Marowijne met focus op modernisering van het rechtssysteem.', '/assets/photos/vermeulen.jpg', '2025-01-25 13:30:00', '2025-06-11 16:00:00'),
(16, 'Andre Morrison', 5, 7, 365, 1, 'Ondernemer en gemeenschapsleider met expertise in internationale handel.', '/assets/photos/morrison.jpg', '2025-01-25 13:45:00', '2025-06-11 16:00:00'),
(17, 'Elena Vasquez', 5, 8, 298, 1, 'Ingenieur en projectmanager uit Brokopondo met focus op technologische innovatie.', '/assets/photos/vasquez.jpg', '2025-01-25 14:00:00', '2025-06-11 16:00:00'),

-- APR Candidates
(18, 'Gregory Fernandez', 6, 9, 234, 1, 'Vakbondsleider en arbeidsrechten activist uit Coronie.', '/assets/photos/g_fernandez.jpg', '2025-01-25 14:15:00', '2025-06-11 16:00:00'),
(19, 'Indira Ramlal', 6, 10, 187, 1, 'Onderwijzeres en gemeenschapsleider uit Sipaliwini met focus op sociale rechtvaardigheid.', '/assets/photos/ramlal.jpg', '2025-01-25 14:30:00', '2025-06-11 16:00:00'),
(20, 'Marcus Liem', 6, 1, 1654, 1, 'Econoom en beleidsadviseur uit Paramaribo met expertise in arbeidsrecht.', '/assets/photos/liem.jpg', '2025-01-25 14:45:00', '2025-06-11 16:00:00');

-- Insert test data for stem table
INSERT INTO `stem` (`stem_id`, `gebruiker_id`, `kandidaat_id`, `gestemd_op`) VALUES
(1, 3, 1, '2025-05-15 09:30:00'),
(2, 4, 1, '2025-05-15 10:45:00'),
(3, 6, 5, '2025-05-15 11:20:00'),
(4, 8, 3, '2025-05-15 14:15:00'),
(5, 10, 7, '2025-05-15 15:30:00');

-- Update vote counts in kandidaat table based on stem table
UPDATE kandidaat SET aantal_stemmen = (
    SELECT COUNT(*) FROM stem WHERE stem.kandidaat_id = kandidaat.kandidaat_id
) WHERE kandidaat_id IN (1, 3, 5, 7);

-- Update gestemd status for users who have voted
UPDATE gebruiker SET gestemd = 1 WHERE gebruiker_id IN (3, 4, 6, 8, 10);