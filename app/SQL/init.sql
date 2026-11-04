START TRANSACTION;

CREATE TABLE IF NOT EXISTS `server`(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    displayName VARCHAR(100),
    motd VARCHAR(255),
    maxPlayers INT,
    gameType VARCHAR(20),
    map VARCHAR(10) NOT NULL,
    timeLimit INT,
    pointLimit INT,
    forceCharacter VARCHAR(25),
    port INT,
    password VARCHAR(50),
    room VARCHAR(2),
    masterServer VARCHAR(100),
    allowDownload BOOLEAN,
    downloadSize INT
);

CREATE TABLE IF NOT EXISTS `gametype`(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(25),
    identifier VARCHAR(25),
    typeoflevel VARCHAR(25)
);

CREATE TABLE IF NOT EXISTS `map`(
    id VARCHAR(10) NOT NULL PRIMARY KEY,
    levelName VARCHAR(100),
    ACT INT,
    NextLevel VARCHAR(2)
);

CREATE TABLE IF NOT EXISTS `typeoflevel`(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    value VARCHAR(25),
    map_id VARCHAR(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS `addon`(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    size INT,
    icon VARCHAR(100),
    description VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS `command`(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    command VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS `character`(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    skinName VARCHAR(25),
    displayName VARCHAR(25)
);

-- Associations

CREATE TABLE IF NOT EXISTS `server_load_addon`(
    server_id INT NOT NULL,
    addon_id INT NOT NULL
);


CREATE TABLE IF NOT EXISTS `server_execute_commande`(
    server_id INT NOT NULL,
    command_id INT NOT NULL
);

CREATE TABLE IF NOT EXISTS `addon_contain_character`(
    addon_id INT NOT NULL,
    character_id INT NOT NULL
);

CREATE TABLE IF NOT EXISTS `addon_include_map`(
    map_id VARCHAR(10) NOT NULL,
    addon_id INT NOT NULL
);

-- FOREIGN KEYS

ALTER TABLE `server`
    ADD CONSTRAINT fk_server_map FOREIGN KEY (map) REFERENCES `map`(id);

ALTER TABLE `server_load_addon`
    ADD CONSTRAINT fk_load_server FOREIGN KEY (server_id) REFERENCES `server`(id),
    ADD CONSTRAINT fk_load_addon FOREIGN KEY (addon_id) REFERENCES `addon`(id);

ALTER TABLE `server_execute_commande`
    ADD CONSTRAINT fk_execute_server FOREIGN KEY (server_id) REFERENCES `server`(id),
    ADD CONSTRAINT fk_execute_command FOREIGN KEY (command_id) REFERENCES `command`(id);

ALTER TABLE `addon_contain_character`
    ADD CONSTRAINT fk_contain_addon FOREIGN KEY (addon_id) REFERENCES `addon`(id),
    ADD CONSTRAINT fk_contain_character FOREIGN KEY (character_id) REFERENCES `character`(id);

ALTER TABLE `addon_include_map`
    ADD CONSTRAINT fk_include_map FOREIGN KEY (map_id) REFERENCES `map`(id),
    ADD CONSTRAINT fk_include_addon FOREIGN KEY (addon_id) REFERENCES `addon`(id);

ALTER TABLE `typeoflevel`
    ADD CONSTRAINT fk_typeoflevel_map FOREIGN KEY (map_id) REFERENCES `map`(id);

COMMIT;