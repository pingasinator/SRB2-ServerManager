START TRANSACTION;

-- import the gametypes

INSERT INTO gametype (name,identifier,typeoflevel) Values ('Co-op','Co-op','Co-op');
INSERT INTO gametype (name,identifier,typeoflevel) Values ('Competition','Competition','Competition');
INSERT INTO gametype (name,identifier,typeoflevel) Values ('Race','Race','Race');
INSERT INTO gametype (name,identifier,typeoflevel) Values ('Match','Match','Match');
INSERT INTO gametype (name,identifier,typeoflevel) Values ('Tag','Tag','Tag');
INSERT INTO gametype (name,identifier,typeoflevel) Values ('Capture the flag','Ctf','Ctf');

-- import the maps

INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('1','Greenflower','1','2');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('2','Greenflower','2','3');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('3','Greenflower','3','4');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('4','Techno Hill','1','5');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('5','Techno Hill','2','6');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('6','Techno Hill','3','7');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('7','Deep Sea','1','8');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('8','Deep Sea','2','9');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('9','Deep Sea','3','10');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('10','Castle Eggman','1','11');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('11','Castle Eggman','2','12');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('12','Castle Eggman','3','13');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('13','Arid Canyon','1','14');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('14','Arid Canyon','2','15');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('15','Arid Canyon','3','16');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('16','Red Volcano','1','22');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('22','Egg Rock','1','23');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('23','Egg Rock','2','25');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('25','Black Core','1','26');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('26','Black Core','2','27');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('27','Black Core','3','ENDING');

-- Bonus Levels

INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('30','Frozen Hillside','0','1100');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('31','Pipe Towers','','1100');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('32','Forest Fortress','','1100');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('33','Final Demo','0','1100');

-- Challenge Stages

INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('40','Haunted Heights','','41');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('41','Aerial Garden','','42');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('42','Azure Temple','','1100');

-- Special Stages

INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('50','Floral Field','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('51','Toxic Plateau','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('52','Flooded Cove','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('53','Cavern Fortress','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('54','Dusty Wasteland','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('55','Magma Caves','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('56','Egg Satellite','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('57','Black Hole','','');

-- Multiplayer

INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('60','MP Special Stage 1','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('61','MP Special Stage 2','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('62','MP Special Stage 3','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('63','MP Special Stage 4','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('64','MP Special Stage 5','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('65','MP Special Stage 6','','');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('66','MP Special Stage 7','','');

-- NiGHTs Stages

INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('70','Christmas Chime','','1100');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('71','Dream Hill','0','1100');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('72','Alpine Paradise','1','1100');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('73','Alpine Paradise','2','1100');

-- Capture the Flag

INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('F0','Lime Forest','','F1');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('F1','Lost Palace','','F2');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('F2','Silver Cascade','','F3');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('F3','Icicle Falls','','F4');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('F4','Twisted Terminal','','F5');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('F5','Clockwork Towers','','F6');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('F6','Iron Turret','','F7');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('F7','Dual Fortress','','F8');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('F8','Nimbus Ruins','','F9');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('F9','Blazing Precipice','','FA');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('FA','Meadow Match','','F0');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('FB','Sapphire Rapids','','FA');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('G0','Metal Star','','G1');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('G1','Conveyor Conflict','','G2');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('G2','Isolated Canyon','','G0');

-- Match

INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('M0','Jade Valley','','M1');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('M1','Noxious Factory','','M2');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('M2','Tidal Palace','','M3');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('M3','Thunder Citadel','','M4');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('M4','Desolate Twilight','','M5');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('M5','Frigid Mountain','','M6');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('M6','Orbital Hangar','','M7');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('M7','Sapphire Falls','','M8');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('M8','Diamond Blizzard','','M9');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('M9','Celestial Sanctuary','','MA');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('MA','Frost Columns','','MB');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('MB','Meadow Match','','MC');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('MC','Granite Lake','','MD');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('MD','Summit Showdown','','ME');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('ME','Silver Shiver','','MF');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('MF','Uncharted Badlands','','MG');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('MG','Pristine Shores','','MH');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('MH','Crystalline Heights','','M0');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('N0','Starlit Warehouse','','N1');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('N1','Midnight Abyss','','N2');
INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('N2','Airborne Temple','','N0');

-- Tutorial

INSERT INTO map (id,levelName,ACT,NextLevel) VALUES ('Z0','Tutorial','0','1');

COMMIT;