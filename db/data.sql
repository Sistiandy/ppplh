
--
-- Dumping data for table `user_role`
--

INSERT INTO `user_roles` (`role_id`, `role_name`) VALUES
(1, 'Super Admin'),
(2, 'Admin');

--
-- Dumping data for table `user`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_full_name`, `user_password`, `user_email`, `user_pob`, `user_dob`, `user_input_date`, `user_last_update`, `user_role_role_id`, `user_is_deleted`) VALUES
(1, 'admin', 'Admin', 'cfae66c98aa8d86383e07f1e1ea5d68e1cc6a613', 'admin@example.com', 'Jakarta', '2015-07-30 04:32:54', '2015-07-30 04:32:54', '2015-07-30 04:32:54', 1, 0);

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
