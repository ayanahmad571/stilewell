CREATE TABLE `sw_products_list` (
  `pr_id` int(255) NOT NULL,
  `pr_rel_prty_id` int(255) NOT NULL,
  `pr_rel_sup_id` int(255) NOT NULL,
  `pr_code` varchar(698) NOT NULL,
  `pr_img` varchar(698) NOT NULL DEFAULT 'pr_imgs/default.png',
  `pr_img_2` varchar(698) DEFAULT 'pr_imgs/default.png',
  `pr_img_3` varchar(698) NOT NULL DEFAULT 'pr_imgs/default.png',
  `pr_name` varchar(698) NOT NULL,
  `pr_desc` varchar(698) NOT NULL,
  `pr_price` varchar(698) NOT NULL,
  `pr_qty` varchar(255) NOT NULL DEFAULT '0',
  `pr_dnt` varchar(698) NOT NULL,
  `pr_visible` int(2) NOT NULL DEFAULT '1',
  `pr_valid` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sw_products_list`
--

INSERT INTO `sw_products_list` (`pr_id`, `pr_rel_prty_id`, `pr_rel_sup_id`, `pr_code`, `pr_img`, `pr_img_2`, `pr_img_3`, `pr_name`, `pr_desc`, `pr_price`, `pr_qty`, `pr_dnt`, `pr_visible`, `pr_valid`) VALUES
(1, 2, 1, 'T10101', 'pr_imgs/5940e86510336-updated-1497426021/_1.jpg', 'pr_imgs/5940e86510336-updated-1497426021/_2.jpg', 'pr_imgs/5940e86510336-updated-1497426021/_3.jpg', 'Nylon Carpet', 'STILE / MINERAL SERIES Â  SUPPLY ONLY - EX WAREHOUSENexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,Loop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),Total weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '42', '500', '1497426012', 1, 1),
(2, 2, 1, 'T10104', 'pr_imgs/5940e92cb3495-T10104Nylon Carpet2-80/T10104Nylon Carpet_1.jpg', 'pr_imgs/5940e92cb3495-T10104Nylon Carpet2-80/T10104Nylon Carpet_2.jpg', 'pr_imgs/5940e92cb3495-T10104Nylon Carpet2-80/T10104Nylon Carpet_3.jpg', 'Nylon Carpet', 'STILE / MINERAL SERIESSUPPLY ONLY - EX WAREHOUSENexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,Loop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),Total weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '42', '500', '1497426220', 1, 1),
(3, 2, 1, 'T10106', 'pr_imgs/5940e9c1a1b69-T10106Nylon Carpet2-495/T10106Nylon Carpet_1.jpg', 'pr_imgs/5940e9c1a1b69-T10106Nylon Carpet2-495/T10106Nylon Carpet_2.jpg', 'pr_imgs/5940e9c1a1b69-T10106Nylon Carpet2-495/T10106Nylon Carpet_3.jpg', 'Nylon Carpet', 'STILE / MINERAL SERIESSUPPLY ONLY - EX WAREHOUSENexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,Loop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),Total weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '42', '1140', '1497426369', 1, 1),
(4, 2, 1, 'T10109', 'pr_imgs/5940e9f2a0e4e-updated-1497426418/_1.jpg', 'pr_imgs/5940e9f2a0e4e-updated-1497426418/_2.jpg', 'pr_imgs/5940e9f2a0e4e-updated-1497426418/_3.jpg', 'Nylon Carpet', 'STILE / MINERAL SERIESSUPPLY ONLY - EX WAREHOUSENexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,Loop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),Total weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '42', '2500', '1497426410', 1, 1),
(5, 2, 1, 'T10114', 'pr_imgs/5940ea1419a3b-updated-1497426452/_1.jpg', 'pr_imgs/5940ea1419a3b-updated-1497426452/_2.jpg', 'pr_imgs/5940ea1419a3b-updated-1497426452/_3.jpg', 'Nylon Carpet', 'STILE / MINERAL SERIESSUPPLY ONLY - EX WAREHOUSENexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,Loop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),Total weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '42', '500', '1497426444', 1, 1),
(6, 2, 1, 'T10117', 'pr_imgs/5940ea3238aef-T10117Nylon Carpet2-495/T10117Nylon Carpet_1.jpg', 'pr_imgs/5940ea3238aef-T10117Nylon Carpet2-495/T10117Nylon Carpet_2.jpg', 'pr_imgs/5940ea3238aef-T10117Nylon Carpet2-495/T10117Nylon Carpet_3.jpg', 'Nylon Carpet', 'STILE / MINERAL SERIESSUPPLY ONLY - EX WAREHOUSENexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,Loop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),Total weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '42', '500', '1497426482', 1, 1),
(7, 2, 1, 'T10121', 'pr_imgs/59410e56eed15-updated-1497435734/_1.jpg', 'pr_imgs/59410e56eed15-updated-1497435734/_2.jpg', 'pr_imgs/59410e56eed15-updated-1497435734/_3.jpg', 'Nylon Carpet', 'STILE / MINERAL SERIES\r\nSUPPLY ONLY - EX WAREHOUSE\r\nNexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,\r\nLoop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),\r\nTotal weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '42', '700', '1497435726', 1, 1),
(8, 2, 1, 'T10127', 'pr_imgs/59410f39b02e1-updated-1497435961/_1.jpg', 'pr_imgs/59410f39b02e1-updated-1497435961/_2.jpg', 'pr_imgs/59410f39b02e1-updated-1497435961/_3.jpg', 'Nylon Carpet', 'STILE / MINERAL SERIES\r\nSUPPLY ONLY - EX WAREHOUSE\r\nNexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,\r\nLoop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),\r\nTotal weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '42', '500', '1497435954', 1, 1),
(9, 3, 2, 'AW649', 'pr_imgs/5942423701673-updated-1497514551/_1.jpg', 'pr_imgs/5942423701673-updated-1497514551/_2.jpg', 'pr_imgs/5942423701673-updated-1497514551/_3.jpg', 'Luxury Vinyl Tile 3mm', '100% VIRGIN PVC WITH UV COATING,\r\nTOP LAYER FILM 0.5MM, \r\nGLUE DOWN,\r\nPLANK SIZE 1219X203X3mm (+/- 10mm)', '20', '202.15', '1497514533', 1, 1),
(10, 3, 2, 'LS107-2', 'pr_imgs/59424713425cf-LS107-2Luxury Vinyl Tile 3mm3-202/LS107-2Luxury Vinyl Tile 3mm_1.jpg', 'pr_imgs/59424713425cf-LS107-2Luxury Vinyl Tile 3mm3-202/LS107-2Luxury Vinyl Tile 3mm_2.jpg', 'pr_imgs/59424713425cf-LS107-2Luxury Vinyl Tile 3mm3-202/LS107-2Luxury Vinyl Tile 3mm_3.jpg', 'Luxury Vinyl Tile 3mm', '100% VIRGIN PVC WITH UV COATING,\r\n TOP LAYER FILM 0.5MM, \r\nGLUE DOWN, \r\nPLANK SIZE 1219X203X3mm (+/- 10mm)', '20', '202.15', '1497515795', 1, 1),
(12, 2, 1, 'T65201', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Nylon Carpet', 'STILE / MINERAL SERIESSUPPLY ONLY - EX WAREHOUSENexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,Loop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),Total weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '66.75', '70', '1498559530', 1, 1),
(13, 2, 1, 'T70704G', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Nylon Carpet', 'STILE / MINERAL SERIESSUPPLY ONLY - EX WAREHOUSENexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,Loop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),Total weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '90.2', '280', '1498559627', 1, 1),
(14, 2, 1, 'T70804G', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Nylon Carpet', 'STILE / MINERAL SERIESSUPPLY ONLY - EX WAREHOUSENexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,Loop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),Total weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '99.5', '24', '1498559707', 1, 1),
(15, 2, 1, 'T70806G', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Nylon Carpet', 'STILE / MINERAL SERIESSUPPLY ONLY - EX WAREHOUSENexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,Loop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),Total weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '99.5', '64', '1498559937', 1, 1),
(16, 2, 1, 'T65301', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Nylon Carpet', 'STILE / MINERAL SERIESSUPPLY ONLY - EX WAREHOUSENexlonâ„¢ Premium Solution Dyed Nylon,Gauge : 1/10G,Loop construction,S.P.I 10.2, Total height 6.6mm(Â± 0.5 mm),Total weight approx 4900 g/mÂ²,Tile size 500x500 mm.', '64.1', '270.4', '1498559979', 1, 1),
(17, 3, 2, 'LS130-2', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'LUXURY VINYL TILE 3MM', '100% VIRGIN PVC WITH UV COATING, TOP LAYER FILM 0.5MM, GLUE DOWN, PLANK SIZE 1219X203X3mm (+/- 10mm)', '20', '202.15', '1498560296', 1, 1),
(18, 3, 2, 'LS112-8', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'LUXURY VINYL TILE 3MM', '100% VIRGIN PVC WITH UV COATING, TOP LAYER FILM 0.5MM, GLUE DOWN, PLANK SIZE 1219X203X3mm (+/- 10mm)', '20', '202.15', '1498560404', 1, 1),
(19, 3, 2, 'TCM205-11', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'LUXURY VINYL TILE 3MM', '100% VIRGIN PVC WITH UV COATING, TOP LAYER FILM 0.5MM, GLUE DOWN, PLANK SIZE 1219X203X3mm (+/- 10mm)', '20', '202.15', '1498560448', 1, 1),
(20, 3, 2, 'LS118-10', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'LUXURY VINYL TILE 5MM', '100% VIRGIN PVC WITH UV COATING, TOP LAYER FILM 0.5MM, GLUE DOWN, PLANK SIZE 1220X196X5mm (+/- 10mm)', '45', '390.24', '1498560551', 1, 1),
(21, 3, 2, 'LS112-7', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'LUXURY VINYL TILE 5MM', '100% VIRGIN PVC WITH UV COATING, TOP LAYER FILM 0.5MM, GLUE DOWN, PLANK SIZE 1220X196X5mm (+/- 10mm)', '45', '390.24', '1498560610', 1, 1),
(22, 3, 2, 'AW628', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'LUXURY VINYL TILE 5MM', '100% VIRGIN PVC WITH UV COATING, TOP LAYER FILM 0.5MM, GLUE DOWN, PLANK SIZE 1220X196X5mm (+/- 10mm)', '45', '390.24', '1498560672', 1, 1),
(23, 3, 2, 'LS111-33', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'LUXURY VINYL TILE 5MM', '100% VIRGIN PVC WITH UV COATING, TOP LAYER FILM 0.5MM, GLUE DOWN, PLANK SIZE 1220X196X5mm (+/- 10mm)', '45', '390.24', '1498560710', 1, 1),
(24, 3, 2, 'LS115-27', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'LUXURY VINYL TILE 5MM', '100% VIRGIN PVC WITH UV COATING, TOP LAYER FILM 0.5MM, GLUE DOWN, PLANK SIZE 1220X196X5mm (+/- 10mm)', '45', '390.24', '1498560741', 1, 1),
(25, 4, 6, 'A-18160', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'SPORTS FLOORING', 'LENGTH: 15M |newline|\r\nWIDTH: 1.8M |newline|\r\nTHICKNESS: 6MM  |newline|\r\nCOLOR: RED', '48', '270', '1498561433', 1, 1),
(26, 4, 6, 'A-38160', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'SPORTS FLOORING', 'LENGTH: 15M |newline|\r\nWIDTH: 1.8M |newline|\r\nTHICKNESS: 6MM  |newline|\r\nCOLOR: GREY', '48', '270', '1498561528', 1, 1),
(27, 4, 6, 'A-28160', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'SPORTS FLOORING', 'LENGTH: 15M |newline|\r\nWIDTH: 1.8M |newline|\r\nTHICKNESS: 6MM  |newline|\r\nCOLOR: GREEN', '48', '270', '1498561591', 1, 1),
(28, 4, 6, 'A-88160', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'SPORTS FLOORING', 'LENGTH: 15M |newline|\r\nWIDTH: 1.8M |newline|\r\nTHICKNESS: 6MM  |newline|\r\nCOLOR: BLUE', '48', '540', '1498561644', 1, 1),
(29, 4, 6, 'A-65160', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'SPORTS FLOORING', 'LENGTH: 15M |newline|\r\nWIDTH: 1.8M |newline|\r\nTHICKNESS: 6MM  |newline|\r\nCOLOR: MAPLE WOOD', '48', '675', '1498561721', 1, 1),
(30, 5, 5, 'LA-862MH-1', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '600', '1', '1498562479', 1, 1),
(31, 5, 5, 'LA-869H', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '550', '1', '1498562547', 1, 1),
(32, 5, 5, 'LA-861MH-1', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '265', '26', '1498562589', 1, 1),
(33, 5, 5, 'LA-829AH', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '265', '26', '1498562650', 1, 1),
(34, 5, 5, 'LA-867H-1', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '200', '24', '1498562702', 1, 1),
(35, 5, 5, 'LA-876L-1', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '170', '26', '1498562745', 1, 1),
(37, 5, 5, 'LA-854-1', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '115', '100', '1498562828', 1, 1),
(38, 5, 5, 'LA-853H-1', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '140', '4', '1498562876', 1, 1),
(39, 5, 5, 'LA-854-1', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '115', '5', '1498562936', 1, 1),
(41, 5, 5, 'LA-884L', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '175', '4', '1498563046', 1, 1),
(42, 5, 5, 'LA-855-1', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '125', '229', '1498563380', 1, 1),
(43, 5, 5, 'LA-829AH', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CHAIRS', 'CHAIRS', '265', '70', '1498563422', 1, 1),
(44, 2, 4, 'NOV03', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'NOVARA CARPET', 'NOV ARA CARPET 03', '25', '602.25', '1498563649', 1, 1),
(45, 2, 4, 'NOV 06', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'NOVARA CARPET', 'NOV ARA CARPET 06', '25', '600.25', '1498563857', 1, 1),
(46, 2, 4, 'STRK01', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'STAR TREK CARPET', 'STAR TREK CARPET-01', '26', '582', '1498564033', 1, 1),
(47, 2, 4, 'STRK02', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'STAR TREK CARPET', 'STAR TREK CARPET-02', '26', '531', '1498564117', 1, 1),
(48, 2, 4, 'CSTLN-02', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'COASTLINE CARPET', 'COASTLINE CARPET-02', '26', '600.25', '1498564229', 1, 1),
(49, 11, 3, 'PNLT2', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Steel Panel Type 2', 'STEEL PANEL TYPE 2', '0', '3024', '1498567814', 1, 1),
(50, 8, 3, 'PEDF30', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Pedestal Flathead 300mm', 'Pedestal Flathead 300mm', '0', '3000', '1498567887', 1, 1),
(51, 10, 3, 'SCRM645', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Screws M645', 'Screws M645', '0', '110776', '1498567943', 1, 1),
(52, 10, 3, 'SCRM640', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Screws M640', 'Screws M640', '0', '2160', '1498567980', 1, 1),
(53, 11, 3, 'PNLT1', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Steel Panel Type 1 FS800', 'Steel Panel Type 1 FS800', '0', '16024', '1498568436', 1, 1),
(54, 11, 3, 'PNLHPL', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Steel Panel HPL', 'Steel Panel HPL', '0', '556', '1498568479', 1, 1),
(55, 7, 3, 'PEDC20', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Pedestal Crosshead 200mm', 'Pedestal Crosshead 200mm', '0', '7345', '1498568813', 1, 1),
(56, 12, 3, 'PEDBRD20', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'PEDESTAL BORDER 200mm', 'PEDESTAL BORDER 200mm', '0', '3180', '1498569159', 1, 1),
(57, 8, 3, 'PEDF50', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Pedestal Flathead 500mm', 'Pedestal Flathead 500mm', '0', '1925', '1498569386', 1, 1),
(58, 9, 3, 'STRNG', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Stringer', 'Stringer', '0', '16000', '1498569498', 1, 1),
(59, 11, 3, 'GSKT', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'RAISED FLOOR GAS KIT', 'RAISED FLOOR GAS KIT', '0', '6938', '1498569829', 1, 1),
(60, 7, 3, 'PEDC15', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Pedestal Crosshead 150mm', 'Pedestal |bold|Crosshead|.bold| 150mm', '0', '3500', '1498569901', 1, 1),
(61, 12, 3, 'PEDBRD15', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'PEDESTAL BORDER 150mm', 'PEDESTAL BORDER 150mm', '0', '1000', '1498569964', 1, 1),
(62, 8, 3, 'PEDF150SS', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Pedestal Flathead 1500mm SUPER STONG', 'Pedestal Flathead 1500mm SUPER STONG', '0', '900', '1498570056', 1, 1),
(63, 8, 3, 'PEDF100SS', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Pedestal Flathead 1000mm SUPER STONG', 'Pedestal Flathead 1000mm SUPER STONG', '0', '800', '1498570104', 1, 1),
(64, 8, 3, 'PEDF70SS', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Pedestal Flathead 700mm SUPER STONG', 'Pedestal Flathead 700mm SUPER STONG', '0', '1000', '1498570180', 1, 1),
(65, 8, 3, 'PEDF60', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Pedestal Flathead 600mm', 'Pedestal Flathead 600mm', '0', '1000', '1498570224', 1, 1),
(66, 8, 3, 'PEDF20', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Pedestal Flathead 200mm', 'Pedestal Flathead 200mm', '0', '400', '1498570258', 1, 1),
(67, 8, 3, 'PEDF15', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'Pedestal Flathead 150mm', 'Pedestal Flathead 150mm', '0', '800', '1498570284', 1, 1),
(68, 13, 3, 'CLMP38', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CLAMP M38', 'CLAMP M38', '0', '900', '1498570461', 1, 1),
(69, 13, 3, 'CLMP32', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'CLAMP M32', 'CLAMP M38', '0', '1800', '1498570492', 1, 1),
(70, 15, 3, 'BRCNG75', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'BRACING 750MM', 'BRACING 750MM', '0', '4166', '1498570568', 1, 1),
(71, 14, 3, 'EXPBLT', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'EXPANSION BOLTS', 'EXPANSION BOLTS', '0', '15000', '1498570616', 1, 1),
(72, 16, 3, 'NUTS32', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'NUTS M32', 'NUTS FOR M32', '0', '300', '1498571088', 1, 1),
(73, 16, 3, 'NUTS38', 'pr_imgs/default.png', 'pr_imgs/default.png', 'pr_imgs/default.png', 'NUTS M38', 'NUTS FOR M38', '0', '300', '1498571114', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sw_products_list`
--
ALTER TABLE `sw_products_list`
  ADD PRIMARY KEY (`pr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sw_products_list`
--
ALTER TABLE `sw_products_list`
  MODIFY `pr_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;