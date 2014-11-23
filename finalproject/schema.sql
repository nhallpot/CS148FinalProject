-- Database: `NHALLPOT_Final_Project`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblCount`
--

CREATE TABLE IF NOT EXISTS `tblCount` (
  `fldCorrect` int(1) NOT NULL DEFAULT '0',
  `fldOver` int(3) NOT NULL,
  `fldUnder` int(3) NOT NULL,
  `fnkUserId` int(3) NOT NULL,
  `pmkCountId` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblItem`
--

CREATE TABLE IF NOT EXISTS `tblItem` (
  `pmkItemID` varchar(50) NOT NULL,
  `fldItemName` varchar(20) NOT NULL,
  `fldTotalOnHand` int(3) NOT NULL,
  `fldDepartment` varchar(20) NOT NULL,
  `fnkCountId` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblUser`
--

CREATE TABLE IF NOT EXISTS `tblUser` (
  `pmkUserId` int(3) NOT NULL,
  `fldEmail` varchar(25) NOT NULL,
  `fldAdmin` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblCount`
--
ALTER TABLE `tblCount`
 ADD PRIMARY KEY (`pmkCountId`);

--
-- Indexes for table `tblItem`
--
ALTER TABLE `tblItem`
 ADD PRIMARY KEY (`pmkItemID`);

--
-- Indexes for table `tblUser`
--
ALTER TABLE `tblUser`
 ADD PRIMARY KEY (`pmkUserId`);