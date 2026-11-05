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

-- Import types of level

-- Greenflower ACT 1

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','1');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','1');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','1');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','1');

-- Greenflower ACT 2

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','2');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','2');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','2');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','2');

-- Greenflower ACT 3

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','3');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','3');

-- Techno Hill ACT 1

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','4');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','4');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','4');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','4');

-- Techno Hill ACT 2

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','5');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','5');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','5');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','5');

-- Techno Hill ACT 3

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','6');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','6');

-- Deep Sea ACT 1

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','7');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','7');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','7');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','7');

-- Deep Sea ACT 2

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','8');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','8');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','8');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','8');

-- Deep Sea ACT 3

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','9');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','9');

-- Castle Eggman ACT 1

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','10');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','10');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','10');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','10');

-- Castle Eggman ACT 2

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','11');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','11');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','11');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','11');

-- Castle Eggman ACT 3

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','12');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','12');

-- Arid Canyon ACT 1

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','13');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','13');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','13');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','13');

-- Arid Canyon ACT 2

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','14');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','14');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','14');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','14');

-- Arid Canyon ACT 3

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','15');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','15');

-- Red Volcano ACT 1

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','16');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','16');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','16');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','16');

-- Egg Rock ACT 1

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','22');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','22');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','22');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','22');

-- Egg Rock ACT 2

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','23');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','23');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','23');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','23');

-- Black Core ACT 1

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','25');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','25');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','25');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','25');

-- Black Core ACT 2

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','26');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','26');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','26');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','26');

-- Black Core ACT 3

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','27');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','27');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','27');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','27');

-- Frozen Hillside

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','30');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','30');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','30');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','30');

-- Pipe Towers

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','31');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','31');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','31');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','31');
INSERT INTO typeoflevel (value,map_id) VALUES ('Mario','31');

-- Forest Fortress

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','32');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','32');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','32');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','32');

-- Final Demo

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','33');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','33');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','33');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','33');

-- Haunted Heights

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','40');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','40');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','40');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','40');

-- Aerial Garden

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','41');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','41');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','41');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','41');

-- Azure Temple

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','42');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','42');
INSERT INTO typeoflevel (value,map_id) VALUES ('Competition','42');
INSERT INTO typeoflevel (value,map_id) VALUES ('Race','42');

-- Floral Field

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','50');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','50');

-- Toxic Plateau

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','51');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','51');

-- Flooded Cove

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','52');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','52');

-- Cavern Fortress

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','53');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','53');

-- Dusty Wasteland

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','54');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','54');

-- Magma Caves

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','55');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','55');

-- Egg Satellite

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','56');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','56');

-- Black Hole

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','57');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','57');

-- MP Special Stage 1

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','60');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','60');

-- MP Special Stage 2

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','61');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','61');

-- MP Special Stage 3

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','62');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','62');

-- MP Special Stage 4

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','63');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','63');

-- MP Special Stage 5

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','64');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','64');

-- MP Special Stage 6

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','65');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','65');

-- MP Special Stage 7

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','66');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','66');

-- Christmas Chime

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','70');
INSERT INTO typeoflevel (value,map_id) VALUES ('Xmas','70');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','70');

-- Dream Hill

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','71');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','71');

-- Alpine Paradise

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','72');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','72');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','72');

-- Alpine Paradise

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','73');
INSERT INTO typeoflevel (value,map_id) VALUES ('Co-op','73');
INSERT INTO typeoflevel (value,map_id) VALUES ('NiGHTS','73');

-- Lime Forest

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','F0');

-- Lost Palace

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','F1');

-- Silver Cascade

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','F2');

-- Icicle Falls

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','F3');

-- Twisted Terminal

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','F4');

-- Clockwork Towers

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','F5');

-- Iron Turret

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','F6');

-- Dual Fortress

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','F7');

-- Nimbus Ruins

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','F8');

-- Blazing Precipice

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','F9');

-- Meadow Match

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','FA');

-- Sapphire Rapids

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','FB');

-- Metal Star

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','G0');

-- Conveyor Conflict

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','G1');

-- Isolated Canyon

INSERT INTO typeoflevel (value,map_id) VALUES ('CTF','G2');

-- Jade Valley

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','M0');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','M0');
-- Noxious Factory

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','M1');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','M1');

-- Tidal Palace

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','M2');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','M2');

-- Thunder Citadel

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','M3');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','M3');

-- Desolate Twilight

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','M4');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','M4');

-- Frigid Mountain

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','M5');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','M5');

-- Orbital Hangar

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','M6');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','M6');

-- Sapphire Falls

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','M7');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','M7');

-- Diamond Blizzard

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','M8');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','M8');

-- Celestial Sanctuary

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','M9');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','M9');

-- Frost Columns

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','MA');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','MA');

-- Meadow Match

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','MB');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','MB');

-- Granite Lake

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','MC');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','MC');

-- Summit Showdown

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','MD');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','MD');

-- Silver Shiver

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','ME');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','ME');

-- Uncharted Badlands

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','MF');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','MF');

-- Pristine Shores

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','MG');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','MG');

-- Crystalline Heights

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','MH');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','MH');

-- Starlit Warehouse

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','N0');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','N0');

-- Midnight Abyss

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','N1');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','N1');

-- Airborne Temple

INSERT INTO typeoflevel (value,map_id) VALUES ('Match','N2');
INSERT INTO typeoflevel (value,map_id) VALUES ('Tag','N2');

-- Tutorial

INSERT INTO typeoflevel (value,map_id) VALUES ('Singleplayer','Z0');

COMMIT;