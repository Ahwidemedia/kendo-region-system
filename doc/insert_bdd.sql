
INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'BENJAMIN'),
(4, 'CADET'),,
(15, 'EQUIPES HONNEURS'),
(3, 'ESPOIR'),
(5, 'EXCELLENCES FEMMES'),
(10, 'EXELLENCES HOMMES'),
(12, 'HONNEURS'),
(7, 'JUNIORS'),
(8, 'KYU FEMMES'),
(9, 'KYU HOMMES'),
(2, 'MINIME'),
(13, 'SAMOURAI');

INSERT INTO `clubs` (`id`, `name`, `region_id`) VALUES
(1, 'JKCF', 6),
(2, 'KETSUGO ANGERS', 6),
(3, 'ANGERS KENDO IAIDO', 6),
(4, 'ESVN', 6),
(5, 'CPB KENSHIKAI RENNES', 5),
(6, 'KCSB', 5),
(7, 'KENDO CLUB POITIERS', 7),
(8, 'DOJO NANTAIS', 6),
(9, 'CEJC QUIMPER', 5),
(10, 'AME AGARU CAEN', 4),
(11, 'KENDO CLUB BRESTOIS', 5),
(12, 'LE POINÇONNET', 7),
(13, 'LE MANS', 6),
(14, 'USO KENDO IAIDO', 7),
(15, 'PATRONAGE LAÏQUE DE LORIENT', 5),
(16, 'JCN', 5),
(17, 'KENDO CLUB DE BRIONNE', 7),
(18, 'KENDO CLUB CONDEEN', 7),
(19, 'WAKOKAI', 5),
(20, 'ADAKI', 7),
(21, 'SHODOKAN', 6),
(22, 'CBB KENDO', 7),
(23, 'YUSHINKAN CHANTEPIE', 5),
(24, 'SUISHINKAI', 6),
(25, 'NITEN', 13),
(26, 'SHODOKAN Vendée' , 6),
(27, 'ESVN' ,6),
(28, 'JUDO CLUB DE VERTOU - KENDO' , 6),
(29, 'JUDO CLUB NAZAIRIEN', 6),
(30, 'KEN SHIN KAN PLOERMEL', 5),
(31, 'CERCLE PAUL BERT GINGUENE', 5),
(32, 'ASSOCIATION SPORTIVE CHANTEPIE KENDO',5);

INSERT INTO `disciplines` (`id`, `name`) VALUES
(2, 'IAIDO'),
(5, 'JODO'),
(1, 'KENDO'),
(4, 'NAGINATA'),
(3, 'SPORT CHAMBARA');

INSERT INTO `grades` (`id`, `name`) VALUES
(1, '10ème Kyu'),
(2, '9ème Kyu'),
(3, '8ème Kyu'),
(4, '7ème Kyu'),
(5, '6ème Kyu'),
(6, '5ème Kyu'),
(7, '4ème Kyu'),
(8, '3ème Kyu'),
(9, '2ème Kyu'),
(10, '1er Kyu'),
(18, '8ème Dan'),
(17, '7ème Dan'),
(16, '6ème Dan'),
(15, '5ème Dan'),
(14, '4ème Dan'),
(13, '3ème Dan'),
(12, '2ème Dan'),
(11, '1er Dan');

INSERT INTO `regions` (`id`, `name`) VALUES
(14, 'DOM TOM'),
(13, 'ILE DE FRANCE'),
(3, 'NORD EST - Bourgogne Franche Comté'),
(2, 'NORD EST - Grand Est'),
(1, 'NORD EST - Hauts de France'),
(5, 'NORD OUEST - Bretagne'),
(7, 'NORD OUEST - Centre Val de Loire'),
(4, 'NORD OUEST - Normandie'),
(6, 'NORD OUEST - Pays de la Loire'),
(8, 'SUD EST - Auvergne Rhone Alpes'),
(10, 'SUD EST - Corse'),
(9, 'SUD EST - PACA'),
(11, 'SUD OUEST - Nouvelle Aquitaine'),
(12, 'SUD OUEST - Occitanie');


INSERT INTO `profils` (`id`, `name`) VALUES
(1, 'Administrateur'),
(2, 'Gestionnaire'),
(3, 'Utilisateur');