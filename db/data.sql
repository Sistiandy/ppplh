
--
-- Dumping data for table `user_role`
--

INSERT INTO `user_roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Staff'),
(3, 'Analis');

--
-- Dumping data for table `user`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_full_name`, `user_password`, `user_email`, `user_pob`, `user_dob`, `user_input_date`, `user_last_update`, `user_role_role_id`, `user_is_deleted`) VALUES
(1, 'admin', 'Admin', 'f99aecef3d12e02dcbb6260bbdd35189c89e6e73', 'admin@example.com', 'Jakarta', '2015-07-30 04:32:54', '2015-07-30 04:32:54', '2015-07-30 04:32:54', 1, 0),
(2, 'staff', 'Staff SUBBID GAKUM', 'f99aecef3d12e02dcbb6260bbdd35189c89e6e73', 'staff@example.com', 'Jakarta', '2015-07-30 04:32:54', '2015-07-30 04:32:54', '2015-07-30 04:32:54', 2, 0),
(3, 'analis', 'SUBBID GAKUM', 'f99aecef3d12e02dcbb6260bbdd35189c89e6e73', 'analis@example.com', 'Jakarta', '2015-07-30 04:32:54', '2015-07-30 04:32:54', '2015-07-30 04:32:54', 3, 0);

--
-- Dumping data for table `channels`
--

INSERT INTO `channels` (`channel_id`, `channel_name`) VALUES
(1, 'Bidang Pengawasan Dampak Lingkungan'),
(2, 'Bidang Pencegahan Dampak Lingkungan'),
(3, 'KPLH Wilayah'),
(4, 'KASUS'),
(5, 'KLHK RI');

--
-- Dumping data for table `violations`
--

INSERT INTO `violations` (`violation_id`, `violation_title`) VALUES
(1, 'Tidak memenuhi baku mutu lingkungan hidup'),
(2, 'Membuang limbah ke media lingkungan tidak memiliki izin dari Menteri, Gubernur, Bupati/Walikota'),
(3, 'Tidak memiliki amdal'),
(4, 'Tidak memiliki ukl-upl'),
(5, 'Tidak memiliki izin lingkungan');
