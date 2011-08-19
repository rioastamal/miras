-- This file SHOULD NOT executed directly since its containt some prefix
-- that will be replace during script installation

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acl`
--
ALTER TABLE `MR_PREFIX_acl`
  ADD CONSTRAINT `fk_acl_user_type1` FOREIGN KEY (`user_type_id`) REFERENCES `MR_PREFIX_user_type` (`user_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `MR_PREFIX_users`
  ADD CONSTRAINT `fk_users_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `MR_PREFIX_user_type` (`user_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_meta`
--
ALTER TABLE `MR_PREFIX_user_meta`
  ADD CONSTRAINT `fk_users_meta_users1` FOREIGN KEY (`user_id`) REFERENCES `MR_PREFIX_users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
