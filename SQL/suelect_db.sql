CREATE TABLE `Gebruiker` (
    `gebruiker_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `voornaam` TEXT NOT NULL,
    `achternaam` TEXT NOT NULL,
    `id_nummer` VARCHAR(255) NOT NULL UNIQUE,
    `wachtwoord` VARCHAR(255) NOT NULL, 
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `geboorte_datum` DATE NOT NULL,
    `gestemd` BOOLEAN NOT NULL DEFAULT FALSE,
    `aangemaakt_op` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `bijgewerkt_op` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `laatste_login` TIMESTAMP NULL  
);
 
CREATE TABLE `Admin` (
    `admin_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `wachtwoord` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `volledige_naam` TEXT NOT NULL,
    `is_actief` BOOLEAN NOT NULL DEFAULT TRUE,
    `laatste_login` TIMESTAMP NULL,
    `aangemaakt_op` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `bijgewerkt_op` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `Kandidaat` (
    `kandidaat_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `naam` TEXT NOT NULL,
    `partij_id` BIGINT UNSIGNED NOT NULL,
    `distrikt_id` BIGINT UNSIGNED NOT NULL,
    `aantal_stemmen` BIGINT NOT NULL DEFAULT 0,
    `type` BIGINT NOT NULL,
    `bio` TEXT, 
    `foto_url` VARCHAR(255), 
    `aangemaakt_op` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `bijgewerkt_op` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `Stem` (
    `stem_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `gebruiker_id` BIGINT UNSIGNED NOT NULL,
    `kandidaat_id` BIGINT UNSIGNED NOT NULL,
    `gestemd_op` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `Partij` (
    `partij_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `naam` TEXT NOT NULL,
    `logo_url` VARCHAR(255), 
    `beschrijving` TEXT, 
    `aangemaakt_op` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `bijgewerkt_op` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `Distrikt` (
    `distrikt_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `naam` TEXT NOT NULL,
    `aantal_zetels` INT NOT NULL DEFAULT 1, 
    `aangemaakt_op` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `bijgewerkt_op` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `Inlogpogingen` (
    `poging_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `gebruiker_id` BIGINT UNSIGNED NULL, 
    `succes` BOOLEAN NOT NULL,
    `poging_datum` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `AdminInlogpogingen` (
    `poging_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `admin_id` BIGINT UNSIGNED NULL,
    `username` VARCHAR(50) NULL,
    `succes` BOOLEAN NOT NULL,
    `poging_datum` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `admin_inlogpogingen_admin_id_foreign` FOREIGN KEY(`admin_id`) REFERENCES `Admin`(`admin_id`)
);

-- Foreign Key relaties
ALTER TABLE `Kandidaat` 
    ADD CONSTRAINT `kandidaat_distrikt_id_foreign` 
    FOREIGN KEY(`distrikt_id`) REFERENCES `Distrikt`(`distrikt_id`);

ALTER TABLE `Kandidaat` 
    ADD CONSTRAINT `kandidaat_partij_id_foreign` 
    FOREIGN KEY(`partij_id`) REFERENCES `Partij`(`partij_id`);

ALTER TABLE `Stem` 
    ADD CONSTRAINT `stem_kandidaat_id_foreign` 
    FOREIGN KEY(`kandidaat_id`) REFERENCES `Kandidaat`(`kandidaat_id`);

ALTER TABLE `Stem` 
    ADD CONSTRAINT `stem_gebruiker_id_foreign` 
    FOREIGN KEY(`gebruiker_id`) REFERENCES `Gebruiker`(`gebruiker_id`);

ALTER TABLE `Inlogpogingen`
    ADD CONSTRAINT `inlogpogingen_gebruiker_id_foreign`
    FOREIGN KEY(`gebruiker_id`) REFERENCES `Gebruiker`(`gebruiker_id`);